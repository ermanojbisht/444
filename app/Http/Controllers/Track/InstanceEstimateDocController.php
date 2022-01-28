<?php

namespace App\Http\Controllers\Track;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\EeOffice;
use App\Models\Track\EstimateDocument;
use App\Models\Track\InstanceEstimate;
use App\Models\Work;
use Auth;
use Dawson\Youtube\Facades\Youtube;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InstanceEstimateDocController extends Controller
{
    /**
     * @var mixed
     */
    protected $user;
    /**
     * @return mixed
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            //abort_if(Gate::denies('----todo make power'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $this->user = Auth::User();

            return $next($request);
        });
    }

    /**
     * @param $work_code
     */
    public function checkIfinstanceIsAllowed($ee_office_id)
    {
        if ($this->user->inRole('SuperAdmin')) {return;}
        //otherwise check
        $emp_code = $this->user->emp_code;
        if (!$this->user->emp_code) {
            //return with invalid emp code for logged user
            //return redirect()->back()->with('failure', "invalid emp code for logged user");
            return abort(403, 'Unauthorized action.Invalid emp code for logged user');
        } else {
            $allowedPersonEmpIdsArray = EeOffice::find($ee_office_id)->allowedPersonEmpIdsOnBasisOfOfficeHierarchy();
            //add empid of superuser

            //Log::info("allowedPersonEmpIdsArray = ".print_r($allowedPersonEmpIdsArray,true));
            if (!in_array($emp_code, $allowedPersonEmpIdsArray)) {
                return abort(403, 'Unauthorized action.emp code of logged user not allowed');
            }
        }
    }

    /**
     * @param $work_code
     * @param false        $doctypeid
     */
    protected function doclist(InstanceEstimate $instanceEstimate, $doctypeid = false)
    {
        if (!$instanceEstimate->exists) {
            return abort(403, 'Either Estimate Instance Id is not provided or it is invalid.Please provide proper Estimate Instance Id');
        }
        //if(Auth::user()->hasPermission('doc_view_gen_cat_0')){
        $this->checkIfinstanceIsAllowed($instanceEstimate->ee_office_id);
        //for listing of all documents in view
        $docTypes = DocumentType::orderBy('name')->get();
        //DB::enableQueryLog();
        if ($doctypeid) {
            $doctype = DocumentType::findOrFail($doctypeid);
            $doctypeName = $doctype->name;

            if (Auth::user()->can('site_level_mgt')) {
                $doclist = $instanceEstimate->documents()->with('documentTypeGeneral')->where('doctype_id', $doctypeid)->get()->where('documentTypeGeneral', '<>', null);
            } else {
                $doclist = $instanceEstimate->documents()->where('is_active', 1)->with('documentTypeGeneral')->where('doctype_id', $doctypeid)->get()->where('documentTypeGeneral', '<>', null);
            }
        } else {
            if (Auth::user()->can('site_level_mgt')) {
                $doclist = $instanceEstimate->documents()->with('documentTypeGeneral')->get()->where('documentTypeGeneral', '<>', null);
            } else {
                $doclist = $instanceEstimate->documents()->where('is_active', 1)->with('documentTypeGeneral')->get()->where('documentTypeGeneral', '<>', null);
            }

            $doctypeName = "All";
        }

        //log::info(DB::getQueryLog());
        //return $doclist;

        return view('track.document.doclist', compact('instanceEstimate', 'doclist', 'doctypeName', 'docTypes', 'doctypeid'));
        /* }else{
    return abort(403, 'Unauthorized action.');
     */
    }

    /**
     * @param $work_code
     */
    public function addDocument(InstanceEstimate $instanceEstimate)
    {
        $this->checkIfinstanceIsAllowed($instanceEstimate->ee_office_id);
        $docTypes = DocumentType::orderBy('name')->get();

        return view('track.document.create', compact('instanceEstimate', 'docTypes'));
    }

    /**
     * @param $docTypeMimeAllowed
     * @return mixed
     */
    public function allowedMimes($docTypeMimeAllowed)
    {
        //todo other mime type setting
        switch ($docTypeMimeAllowed) {
            /* case 0:
            $validationRequired='required|mimes:xls,xlsx';
            break;*/
            case 1:
                $validationRequired = [
                    'required',
                    function ($attribute, $value, $fail) {
                        /*Log::info("this = " . print_r($value->getClientMimeType(), true));*/
                        if ($value->getClientMimeType() !== 'application/vnd.google-earth.kml+xml') {
                            $fail($attribute.'\'s extension is invalid.');
                        }
                    }
                ];
                break;

            default:
                $validationRequired = 'required';
                break;
        }

        return $validationRequired;
    }

    /**
     * @param Request $request
     */
    public function saveDocument(Request $request)
    {
        //Log::debug('saveDocument is called. ' . $request);
        //Log::info("this = ".print_r($request->all(),true));
        $this->validate($request,
            [
                'instance_estimate_id' => 'required',
                'documenttype' => 'required',
                'version' => 'required',
                'doctitle' => 'required|max:100',
                'doe' => 'date | nullable',
                'externallink' => 'required_without:uploaded_file',
                'uploaded_file' => 'required_without:externallink|nullable'
            ]
        );

        $instance_estimate_id = $request->input('instance_estimate_id');
        $this->checkIfinstanceIsAllowed($request->input('ee_office_id'));
        $instanceEstimate = InstanceEstimate::findOrFail($instance_estimate_id);
        $doctitle = $request->input('doctitle');
        $version = $request->input('version');
        $documenttype = $request->input('documenttype');
        $similarDocExist = $instanceEstimate->checkSimlirityOfDocTitle($doctitle, $version);
        if ($similarDocExist == 'not_allowed') {
            return redirect()->back()->with('message', "Title '$doctitle already exist' , please review the same and then upload if you have new document.");
        } else {
            if ($request->hasFile('uploaded_file') && $request->file('uploaded_file')->isValid()) {
                $filetypeRequired = $this->allowedMimes($request->documenttype);
                //now check mime types
                $this->validate($request, [
                    'uploaded_file' => $filetypeRequired
                ]);
                if ($request->input('documenttype') == 14) {
                    $video = Youtube::upload($request->file('uploaded_file')->getPathName(), [
                        'title' => $request->input('doctitle'),
                        'description' => $request->input('description')
                    ], 'public');
                    $videoId = $video->getVideoId();
                    $doc_address = 'https://www.youtube.com/embed/'.$videoId;
                } else {
                    $extension = $request->uploaded_file->getClientOriginalExtension();
                    //Log::info("extension = ".print_r($extension,true));
                    $title_in_slug = Str::slug($doctitle, '-');
                    $fileName = $instance_estimate_id.'-'.$documenttype.'-'.$title_in_slug.'.'.$extension;
                    $path = $request->uploaded_file->storeAs('estimatedocs/'.$instance_estimate_id, $fileName, 'public');
                    $doc_address = config('site.app_url_mis').'/'.$path;
                }
            } else {
                $doc_address = $request->input('externallink');
            }
            if ($similarDocExist == 'allowed') {
                $document = new EstimateDocument;
                $document->instance_estimate_id = $instance_estimate_id;
            } else {
                $document = EstimateDocument::find($similarDocExist);
            }
            $document->doctype_id = $documenttype;
            $document->name = $doctitle;
            $document->uploaded_by = Auth::user()->id;

            $document->address = $doc_address;
            $document->description = $request->input('description');
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
    public function publishToggle($docid, $isactive)
    {
        $doc = EstimateDocument::findOrFail($docid);
        $this->checkIfinstanceIsAllowed($doc->instanceEstimate->ee_office_id);
        if ($isactive) {
            $doc->is_active = 0;
        } else {
            $doc->is_active = 1;
        }
        $doc->save();

        return redirect()->back()->with('success', 'Document Status Changed Successfully');
    }

    /**
     * @param $id
     */
    public function editDocument($id)
    {
        $docdetails = Document::findOrFail($id);
        $this->checkIfWorkIsAllowed($docdetails->work_code);
        $docTypes = DocumentType::orderBy('name')->get();

        return view('managedocuments.edit', compact('docdetails', 'docTypes'));
    }

    /**
     * @param Request $request
     */
    public function searchDoc(Request $request)
    {
        return redirect()
            ->route('instance.estimate.doclist', ['instance_estimate' => $request->input('instance_estimate_id'), 'doctypeid' => $request->input('doctype')])
            ->with('status', session('status'));
        //return redirect('doclist/'.$request->input('instance_estimate_id').'/'.$request->input('doctype'));
    }
}
