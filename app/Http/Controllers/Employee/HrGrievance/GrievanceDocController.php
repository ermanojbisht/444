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

class GrievanceDocController extends Controller
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
    protected function doclist(HrGrievance $hr_grievance, $is_question = 1)
    {
        $doclist = $hr_grievance->documents();
        if ($is_question != 2) {
            $doclist = $doclist->where('is_question', $is_question);
        }
        $doclist = $doclist->get();
        $hr_grievance_id = $hr_grievance->id;

        return view('employee.hr_grievance.document.doclist', compact('hr_grievance_id', 'doclist'));

    }

    /**
     * @param $hr_hrivance
     */
    public function addDocument(HrGrievance $hr_grievance)
    {
        $hr_grievance_id = $hr_grievance->id;
        return view('employee.hr_grievance.document.create', compact('hr_grievance_id'));
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
                'hr_grievance_id' => 'required',
                'doctitle' => 'required|max:100',
                'uploaded_file' => 'required|mimes:pdf,jpeg,jpg,png'  //    todo:: check send filed  ?? 
            ]
        );

        

        $hr_grievance_id = $request->input('hr_grievance_id');
        $hr_grievance = HrGrievance::findOrFail($hr_grievance_id);
        $doctitle = $request->input('doctitle');

        if ($hr_grievance->checkSimlirityOfDocTitle($doctitle)) {
            return redirect()->back()->with('message', "Title '$doctitle already exist' , please review the same and then upload if you have new document.");
        }

        if ($request->hasFile('uploaded_file') && $request->file('uploaded_file')->isValid()) {

            $extension = $request->uploaded_file->getClientOriginalExtension();
            //Log::info("extension = ".print_r($extension,true));
            $title_in_slug = Str::slug($doctitle, '-');
            $fileName = $hr_grievance_id . '-' . $title_in_slug . '.' . $extension;
            $path = $request->uploaded_file->storeAs('hrgrievancedocs/' . $hr_grievance_id, $fileName, 'public');
            $doc_address = config('site.app_url_mis') . '/' . $path;

            $document = new HrGrievanceDocument;
            $document->hr_grievance_id = $hr_grievance_id;
            $document->name = $doctitle;
            $document->uploaded_by = Auth::id();  //  todo:: employee logged in Employee Id to be supplied
            $document->address = $doc_address;
            $document->description = $request->input('description');
            $document->save();
        }

       return  Redirect::route('employee.hr_grievance')->with('success' , $this->textMessageAfterAddingGrievance($hr_grievance_id, 'saved ')); 
    }

 
    public function textMessageAfterAddingGrievance($hrGrievance_id, $actionCompleted)
    {
        return  'Your Grievance and related document has been ' . $actionCompleted . ', please note down your Grievance Id : '
         . $hrGrievance_id . '  Kindly note this Id for future reference. \n you can add doc \n '.
        ' 2 days editable '; 
    } 

}
