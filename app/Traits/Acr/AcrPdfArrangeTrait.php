<?php

namespace App\Traits\Acr;

use App\Models\Acr\AcrMasterTraining;

trait AcrPdfArrangeTrait
{
    /**
     * @param $acr
     * @param $milestone
     * @return mixed
     */
    public function arrangePagesForPdf($acr, $milestone)
    {
        $pages = [];
        $view = true;

        if (in_array($milestone, ['submit', 'report', 'review', 'accept', 'reject', 'correctnotice'])) {
            list($employee, $appraisalOfficers, $leaves, $appreciations, $inbox, $reviewed, $accepted, $officeWithParentList) = $acr->firstFormData();
            $pages[] = view('employee.acr.view_part1', ['acr' => $acr, 'employee' => $employee, 'appraisalOfficers' => $appraisalOfficers, 'leaves' => $leaves, 'appreciations' => $appreciations, 'inbox' => $inbox, 'reviewed' => $reviewed, 'accepted' => $accepted, 'officeWithParentList' => $officeWithParentList]);

            if ($acr->isSinglePage) {
                $pages[] = view('employee.acr.form.single_page.user_show', compact('acr'));
            }elseif ($acr->isIfmsClerk){               
                $pages[] = view('employee.acr.form.ifms_ministerial.user_show', compact('acr')); //todo page for this acr
            } else {
                $data_groups = $acr->type1RequiremntsWithFilledData();
                $negative_groups = $acr->negative_groups();
                $selected_trainings = $acr->employee->EmployeeProposedTrainings->pluck('training_id');
                $master_trainings = AcrMasterTraining::whereIn('id', $selected_trainings)->get()->groupBy('topic');
                $pages[] = view('employee.acr.form.show', compact('acr', 'data_groups', 'negative_groups', 'master_trainings', 'selected_trainings', 'view'));
            }
        }

        if (in_array($milestone, ['report', 'review', 'accept', 'correctnotice'])) {
            if ($acr->isSinglePage) {
                $pages[] = view('employee.acr.form.single_page.report_review_show', compact('acr'));
            }elseif ($acr->isIfmsClerk){    
                $pages[] = view('employee.acr.form.ifms_ministerial.report_review_show', compact('acr'));
            }  else {
                $requiredParameters = $acr->type1RequiremntsWithFilledData()->first();
                $applicableParameters = $requiredParameters->where('applicable', 1)->count();
                if ($applicableParameters == 0) {
                    $exceptional_reporting_marks = $requiredParameters->sum('reporting_marks');
                    $exceptional_reviewing_marks = $requiredParameters->sum('reviewing_marks');
                } else {
                    $exceptional_reporting_marks = $exceptional_reviewing_marks = 0;
                }

                $requiredNegativeParameters = $acr->type2RequiremntsWithFilledData();
                $personal_attributes = $acr->peronalAttributeSWithMasterData();

                $pages[] = view('employee.acr.form.appraisalShow', compact('acr', 'requiredParameters', 'personal_attributes', 'requiredNegativeParameters', 'applicableParameters', 'exceptional_reporting_marks', 'exceptional_reviewing_marks'));
            }
            //integirty view
            $pages[] = view('employee.other_acr.view_reported_acr', compact('acr'));
        }

        if (in_array($milestone, ['accept', 'correctnotice'])) {
            $pages[] = view('employee.other_acr.view_accepted_acr', compact('acr'));
        }

        return $pages;
    }
}
