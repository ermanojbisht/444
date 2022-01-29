<?php

namespace App\Http\Controllers\Employee\HrGrievance;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\HrGrievance\HrGrievance;
use App\Models\HrGrievance\HrGrievanceDocument;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Redirect;

class GrivanceDocController extends Controller
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
     * @param false        $doctypeid
     */
    protected function doclist(HrGrievance $hr_grivance, $is_question = 1)
    {
        $doclist = $hr_grivance->documents();
        if ($is_question != 2) {
            $doclist = $doclist->where('is_question', $is_question);
        }
        $doclist = $doclist->get();
        $hr_grivance_id = $hr_grivance->id;

        return view('employee.hr_grivance.document.doclist', compact('hr_grivance_id', 'doclist'));

    }

    /**
     * @param $hr_hrivance
     */
    public function addDocument(HrGrievance $hr_grivance)
    {
        $hr_grivance_id = $hr_grivance->id;
        return view('employee.hr_grivance.document.create', compact('hr_grivance_id'));
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
                            $fail($attribute . '\'s extension is invalid.');
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
        $this->validate(
            $request,
            [
                'hr_grivance_id' => 'required',
                'doctitle' => 'required|max:100',
                'uploaded_file' => 'required|mimes:pdf,jpeg,jpg,png'  //    todo:: check send filed  ?? 
            ]
        );

        $hr_grivance_id = $request->input('hr_grivance_id');
        $hr_grivance = HrGrievance::findOrFail($hr_grivance_id);
        $doctitle = $request->input('doctitle');

        if ($hr_grivance->checkSimlirityOfDocTitle($doctitle)) {
            return redirect()->back()->with('message', "Title '$doctitle already exist' , please review the same and then upload if you have new document.");
        }

        if ($request->hasFile('uploaded_file') && $request->file('uploaded_file')->isValid()) {

            $extension = $request->uploaded_file->getClientOriginalExtension();
            //Log::info("extension = ".print_r($extension,true));
            $title_in_slug = Str::slug($doctitle, '-');
            $fileName = $hr_grivance_id . '-' . $title_in_slug . '.' . $extension;
            $path = $request->uploaded_file->storeAs('hrgrivancedocs/' . $hr_grivance_id, $fileName, 'public');
            $doc_address = config('site.app_url_mis') . '/' . $path;

            $document = new HrGrievanceDocument;
            $document->hr_grivance_id = $hr_grivance_id;
            $document->name = $doctitle;
            $document->uploaded_by = Auth::user()->id;  //  todo:: employee logged in Employee Id to be supplied 
            $document->address = $doc_address;
            $document->description = $request->input('description');
            $document->save();
        }

       return  Redirect::route('employee.hr_grivance')->with('success' , $this->textMessageAfterAddingGrivance($hr_grivance_id, 'saved ')); 
    }

 
    public function textMessageAfterAddingGrivance($hrGrivance_id, $actionCompleted)
    {
        return  'Your Grivance and related document has been ' . $actionCompleted . ', please note down your Grivance Id : '
         . $hrGrivance_id . '  Kindly note this Id for future reference. \n you can add doc \n '.
        ' 2 days editable '; 
    } 

}
