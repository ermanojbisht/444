<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Work;
use Auth;
use Dawson\Youtube\Facades\Youtube;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DocController extends Controller {
    protected $user;
    /**
     * @return mixed
     */
    function __construct() {
        $this->middleware(function ($request, $next) {
            //abort_if(Gate::denies('----todo make power'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $this->user = Auth::User();
            return $next($request);
        });
    }

    /**
     * @param $work_code
     */
    public function checkIfWorkIsAllowed($work_code) {
        if ($this->user->inRole('SuperAdmin')) {return;}
        //otherwise check
        $emp_code = $this->user->emp_code;
        if (!$this->user->emp_code) {
            //return with invalid emp code for logged user
            //return redirect()->back()->with('failure', "invalid emp code for logged user");
            return abort(403, 'Unauthorized action.Invalid emp code for logged user');
        } else {
            $allowedPersonEmpIdsArray = Work::find($work_code)->allowedPersonEmpIds('docupload');
            //add empid of superuser

            //Log::info("allowedPersonEmpIdsArray = ".print_r($allowedPersonEmpIdsArray,true));
            if (!in_array($emp_code, $allowedPersonEmpIdsArray)) {
                return abort(403, 'Unauthorized action.emp code of logged user not allowed');
            }
        }
    }

    /**
     * @param $work_code
     * @param false $doctypeid
     */
    protected function doclist($work_code = false, $doctypeid = false) {
        //if(Auth::user()->hasPermission('doc_view_gen_cat_0')){
        $work = Work::find($work_code);
        if (!$work) {
            return abort(403, 'Either Work Code is not provided or it is invalid.Please provide proper work code');
        }
        $this->checkIfWorkIsAllowed($work_code);
        $docTypes = DocumentType::orderBy('name')->get();
        //DB::enableQueryLog();
        if ($doctypeid) {
            $doctype = DocumentType::findOrFail($doctypeid);
            $doctypeName = $doctype->name;

            if (Auth::user()->can('site_level_mgt')) {
                $doclist = $work->documents()->with('documentTypeGeneral')->where('doctype_id', $doctypeid)->get()->where('documentTypeGeneral', '<>', Null);
            } else {
                $doclist = $work->documents()->where('is_active', 1)->with('documentTypeGeneral')->where('doctype_id', $doctypeid)->get()->where('documentTypeGeneral', '<>', Null);
            }

        } else {
            if (Auth::user()->can('site_level_mgt')) {
                $doclist = $work->documents()->with('documentTypeGeneral')->get()->where('documentTypeGeneral', '<>', Null);
            } else {
                $doclist = $work->documents()->where('is_active', 1)->with('documentTypeGeneral')->get()->where('documentTypeGeneral', '<>', Null);
            }

            $doctypeName = "All";
        }

        //log::info(DB::getQueryLog());
        //return $doclist;
        return view('managedocuments.doclist', compact('doclist', 'doctypeName', 'docTypes', 'doctypeid'))->with(['workcode' => $work->WORK_code, 'workname' => $work->WORK_name]);
        /* }else{
    return abort(403, 'Unauthorized action.');
     */
    }

    /**
     * @param $work_code
     */
    public function addDocument($work_code) {
        $work = Work::findOrFail($work_code);
        $this->checkIfWorkIsAllowed($work_code);
        $docTypes = DocumentType::orderBy('name')->get();

        return view('managedocuments.create', compact('work', 'docTypes'));
    }

    /**
     * @param Request $request
     */
    public function saveDocument(Request $request) {
        //Log::debug('saveDocument is called. ' . $request);
        //Log::info("this = ".print_r($request->all(),true));
        $this->validate($request,
            [
                'work_code' => 'required',
                'documenttype' => 'required',
                'version' => 'required',
                'doctitle' => 'required|max:100',
                'lat' => 'numeric | nullable',
                'lng' => 'numeric | nullable',
                'doe' => 'date | nullable',
                'externallink' => 'required_without:uploaded_file',
                'uploaded_file' => 'required_without:externallink|nullable',
            ]
        );





        $work_code = $request->input('work_code');
        $this->checkIfWorkIsAllowed($work_code);
        $work = Work::findOrFail($work_code);
        $doctitle = $request->input('doctitle');
        $version = $request->input('version');
        $documenttype = $request->input('documenttype');
        $similarDocExist = $work->checkSimlirityOfDocTitle($doctitle,$version);
        if ($similarDocExist == 'not_allowed') {
            return redirect()->back()->with('message', "Title '$doctitle already exist' , please review the same and then upload if you have new document.");
        } else {

            if ($request->hasFile('uploaded_file') && $request->file('uploaded_file')->isValid()) {
                if($request->input('documenttype')==14){
                    $video = Youtube::upload($request->file('uploaded_file')->getPathName(), [
                        'title'       => $request->input('doctitle'),
                        'description' => $request->input('description')
                    ], 'public');
                    $videoId= $video->getVideoId();
                    $doc_address='https://www.youtube.com/embed/'.$videoId;
                }else{
                    $extension = $request->uploaded_file->extension();
                    //Log::info("extension = ".print_r($extension,true));
                    $title_in_slug = Str::slug($doctitle, '-');
                    $fileName = $work_code . '-' . $documenttype . '-' . $title_in_slug . '.' . $extension;
                    $path = $request->uploaded_file->storeAs('workdocs/' . $work_code, $fileName, 'public');
                    $doc_address=config('site.app_url_mis') . '/' . $path;
                }
            }else{
                $doc_address=$request->input('externallink');
            }
            if ($similarDocExist == 'allowed') {
                $document = new Document;
                $document->work_code = $work_code;
            } else {
                $document = Document::find($similarDocExist);
            }
            $document->doctype_id = $documenttype;
            $document->name = $doctitle;
            $document->uploaded_by = Auth::user()->id;

            $document->address =  $doc_address;
            $document->description = $request->input('description');
            $document->lat = $request->input('lat');
            $document->lng = $request->input('lng');
            $document->doe = $request->input('doe');
            $document->version = $request->input('version');
        }
        $document->save();
        return redirect()->back()->with('success', 'Document Added Successfully');
    }

    /**
     * @param $docid
     * @param $isactive
     */
    public function publishToggle($docid, $isactive) {
        $doc = Document::findOrFail($docid);
        $this->checkIfWorkIsAllowed($doc->work_code);
        if ($isactive) {
            $doc->is_active = 0;
        } else {
            $doc->is_active = 1;
        }
        $doc->save();
        return redirect()->back()->with('success', 'Document Status Changed Successfully');
    }

    public function editDocument($id) {
        $docdetails = Document::findOrFail($id);
        $this->checkIfWorkIsAllowed($docdetails->work_code);
        $docTypes = DocumentType::orderBy('name')->get();
        return view('managedocuments.edit', compact('docdetails', 'docTypes'));
        
        
        
    }

    /**
     * @param Request $request
     */
    public function searchDoc(Request $request) {
        return redirect('doclist/' . $request->input('work_code') . '/' . $request->input('doctype'));
    }
}
