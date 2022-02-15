<?php

return [

 1001=>[
    'head'=>'1- Assessment of Performance',
    'head_note'=>'Assigned Tasks / Works',
    'foot_note'=>'',
    'table_type'=>1, // 1 mean only Target Achivement Table 
    ],
 1002=>[
    'head'=>'1- Assessment of Performance',
    'head_note'=>'Assigned Tasks / Works',
    'foot_note'=>'',
    'table_type'=>2, // 2 mean only Status Table 
    ],

// Negative Parameters
   2999=>[
    //'head'=>'Training Program',
    'head_note'=>'',
    'foot_note'=>'Note:- If the officer does not submit the training report and certificate to Executive Engineer, upto 05 marks will be deducted as given on Part-II (Self-Appraisal). except under exceptional substances. This deduction will be decided at Executive Engineer level.',
    'multi_rows'=>true,
    'columns'=>[
         1=>[
               'text'=>'S.No.',
               'input_type'=>false,
            ],
         2=>[
               'text'=>'Name of Training Program',
               'input_type'=>'text',
               'input_name'=>'col_1',
            ],
         3=>[
               'text'=>'Nominated Man-Days',
               'input_type'=>'number',
               'input_name'=>'col_2',
            ],
         4=>[
               'text'=>'Attended Man-Days',
               'input_type'=>'number',
               'input_name'=>'col_3',
            ],
         5=>[
               'text'=>'Date of Submission of training reports & copy of Certificate given after Successful training',
               'input_type'=>'text',
               'input_name'=>'col_4',
            ],
      ]
   ],

 2001=>[
      //'head'=>'Enquiry Report',
      'head_note'=>'',
      'foot_note'=>'Note :- If the officer does not submit the Enquiry Report within prescribed time, upto max marks shown above will be deducted as given on part II (Self-Appraisal), except under exceptional circumstances.',
      'multi_rows'=>true,
      'columns'=>[
         1=>[
               'text'=>'S.No.',
               'input_type'=>false,
            ],
         2=>[
               'text'=>'Name of work for which Enquiry was setup',
               'input_type'=>'text',
               'input_name'=>'col_1',
            ],
         3=>[
               'text'=>'Date of Commencement of Enquiry',
               'input_type'=>'text',
               'input_name'=>'col_2',
            ],
         4=>[
               'text'=>'Time Limit for Enquiry (in Days)',
               'input_type'=>'text',
               'input_name'=>'col_3',
            ],
         5=>[
               'text'=>'Date of submission of Enquiry report',
               'input_type'=>'text',
               'input_name'=>'col_4',
            ],
         6=>[
               'text'=>'Cause of delay if any',
               'input_type'=>'text',
               'input_name'=>'col_5',
            ],
      ],
   ],
   2002=>[
      //'head'=>'Inspection Report to Govt.',
      'head_note'=>'',
      'foot_note'=>'Note:- If the officer does not submit the Inspection Report to Govt. in regular way every month, marks will be deducted as given in Part II (Self Appraisal), except under exceptional circumstances.',
      'multi_rows'=>true,
      'columns'=>[
         1=>[
               'text'=>'S.No.',
               'input_type'=>false,
            ],
         2=>[
               'text'=>'Name of Circle',
               'input_type'=>'text',
               'input_name'=>'col_1',
            ],
         3=>[
               'text'=>'No. of Works',
               'input_type'=>'number',
               'input_name'=>'col_2',
            ],
         4=>[
               'text'=>'No. of lnspections Conducted for the period under consideration (target frequency is 1 Inspection per work per year during construction)',
               'input_type'=>'text',
               'input_name'=>'col_3',
            ],
      ],
   ],
   2003=>[
      //'head'=>'Quality Assurance of Works under Construction with Sanctioned Cost equal or above 20 crore with Comliance notes. ',
      'head_note'=>'',
      'foot_note'=>'Note:- If the officer does not submit the Comliance Report to Govt. in regular way every month, marks will be deducted as given in Part II (Self Appraisal), except under exceptional circumstances.',
      'multi_rows'=>true,
      'columns'=>[
         1=>[
               'text'=>'S.No.',
               'input_type'=>false,
            ],
         2=>[
               'text'=>'Name of Circle',
               'input_type'=>'text',
               'input_name'=>'col_1',
            ],
         3=>[
               'text'=>'No. of lnspections Conducted for the period under consideration (target frequency is I Inspection per work per year during construction)',
               'input_type'=>'text',
               'input_name'=>'col_2',
            ],
            
         4=>[
               'text'=>'Number of Compliances on Inspection Noteffechnical Audit ensured',
               'input_type'=>'text',
               'input_name'=>'col_3',
            ],
         ],
   ],

   2004=>[
    //'head'=>'',//'Details of Detailed Project Report (DPR) submitted for Technical Sanction (T.S.) to Executive Engineer',
    'head_note'=>'',
    'foot_note'=>'Note: If the officer does not submit the DPR to Executive Engineer as directed by Executive Engineer, upto 10 marks will be deducted as given on part II (Self-Appraisal), except under exceptional circumstances. This deduction will be decided at Executive Engineer level.',
      'multi_rows'=>false,
    'columns'=>[
         1=>[
               'text'=>'No of DPR to be submitted',
               'input_type'=>'number',
               'input_name'=>'col_1',
            ],
         2=>[
               'text'=>'No of DPR submitted',
               'input_type'=>'number',
               'input_name'=>'col_2',
            ],
         3=>[
               'text'=>'No of DPR not submitted with the specific reasons thereof',
               'input_type'=>'text',
               'input_name'=>'col_3',
            ],
      ]
   ],
   2005=>[
    //'head'=>'Quality Assurance of different Works in progress during current financial year',
    'head_note'=>'',
    'foot_note'=>'Note :- If the officer does not check the work before payment in regular way, upto 10 marks will be deducted as given on part II (Self-Appraisal), except under exceptional circumstances. This deduction will be decided at Executive Engineer level.',
    'multi_rows'=>false,
    'columns'=>[
         1=>[
               'text'=>'No of works in progress',
               'input_type'=>'number',
               'input_name'=>'col_1',
            ],
         2=>[
               'text'=>'No. of Works checked Physically & Qualitatively by the officer before Payment',
               'input_type'=>'number',
               'input_name'=>'col_2',
            ],
         3=>[
               'text'=>'Number of works not checked out of mentioned works with the reasons thereof',
               'input_type'=>'text',
               'input_name'=>'col_3',
            ],
      ]
   ],
   2006=>[
    //'head'=>'',//'Reply of audit paras of AG',
    'head_note'=>'',
    'foot_note'=>'',//'Note :- If the officer does not submit the reply of Audit paras of the Sub Division under his Jurisdiction to Executive Engineer as per direction of Executive Engineer, upto OS marks will be deducted as given on part II (Self-Appraisal), except under exceptional circumstances. This deduction will be decided at Executive Engineer level.',
    'multi_rows'=>false,
    'columns'=>[
         1=>[
               'text'=>'No. of Audit paras pending in the Jurisdiction of the Officer',
               'input_type'=>'number',
               'input_name'=>'col_1',
            ],
         2=>[
               'text'=>'Number of Audit paras replied',
               'input_type'=>'number',
               'input_name'=>'col_2',
            ],
         3=>[
               'text'=>'Date of Submission of reply',
               'input_type'=>'text',
               'input_name'=>'col_3',
            ],
         4=>[
               'text'=>'No. of Audit paras not replied with the reasons thereof',
               'input_type'=>'text',
               'input_name'=>'col_4',
            ],
      ]
   ],
   2007=>[
   // 'head'=>'',//'Preparing and Uploading of Forest land transfer cases',
    'head_note'=>'',
    'foot_note'=>'',//'Note :- If the officer does not submit the reply of Audit paras of the Sub Division under his Jurisdiction to Executive Engineer as per direction of Executive Engineer, upto O5 marks will be deducted as given on part II (Self-Appraisal), except under exceptional circumstances. This deduction will be decided at Executive Engineer level.',
    'multi_rows'=>false,
    'columns'=>[
         1=>[
               'text'=>'No. of Forest land transfer proposal pending in the Jurisdiction of the Officer',
               'input_type'=>'number',
               'input_name'=>'col_1',
            ],
         2=>[
               'text'=>'No. of Forest land transfer proposal prepared',
               'input_type'=>'number',
               'input_name'=>'col_2',
            ],
         3=>[
               'text'=>'No. of forest proposal uploaded',
               'input_type'=>'text',
               'input_name'=>'col_3',
            ],
         4=>[
               'text'=>'Reasons of not preparing/uploading forest land transfer proposal',
               'input_type'=>'text',
               'input_name'=>'col_4',
            ],
      ]
   ],
   2008=>[ //Submission of Audit Report of Divisions to Chief Engineer.
   // 'head'=>'',
    'head_note'=>'',
    'foot_note'=>'',//'Note :- If the officer does not submit the reply of Audit paras of the Sub Division under his Jurisdiction to Executive Engineer as per direction of Executive Engineer, upto O5 marks will be deducted as given on part II (Self-Appraisal), except under exceptional circumstances. This deduction will be decided at Executive Engineer level.',
    'multi_rows'=>true,
    'columns'=>[
         1=>[
               'text'=>'S.No.',
               'input_type'=>false,
            ],
         2=>[
               'text'=>'Name of Division',
               'input_type'=>'text',
               'input_name'=>'col_1',
            ],
         3=>[
               'text'=>'Number of Audits Conducted',
               'input_type'=>'text',
               'input_name'=>'col_2',
            ],
            
         4=>[
               'text'=>'Date of Submission of Audit report of Divisions to Chief Engineer',
               'input_type'=>'text',
               'input_name'=>'col_3',
            ],
         ],
   ],
   
   2009=>[ //Profit I Loss of Machine, Vehicles etc
   // 'head'=>'',
    'head_note'=>'',
    'foot_note'=>'',//'Note :- If the officer does not submit the reply of Audit paras of the Sub Division under his Jurisdiction to Executive Engineer as per direction of Executive Engineer, upto O5 marks will be deducted as given on part II (Self-Appraisal), except under exceptional circumstances. This deduction will be decided at Executive Engineer level.',
    'multi_rows'=>false,
    'columns'=>[
         
         1=>[
               'text'=>'No. of Machines I Equipment',
               'input_type'=>'number',
               'input_name'=>'col_1',
            ],
         2=>[
               'text'=>'Total Hire Charges Earned',
               'input_type'=>'text',
               'input_name'=>'col_2',
            ],
            
         3=>[
               'text'=>'Hire charges received',
               'input_type'=>'text',
               'input_name'=>'col_3',
            ],
         4=>[
               'text'=>'Expenditure',
               'input_type'=>'text',
               'input_name'=>'col_4',
            ],
         5=>[
               'text'=>'Profit / Loss',
               'input_type'=>'text',
               'input_name'=>'col_5',
            ],
         ],
   ],
   
 2010=>[ //
   //   'head'=>'submission of charge sheets',
      'head_note'=>'',
      'foot_note'=>'', //'Note :- If the officer does not submit the Enquiry Report within prescribed time, upto max marks shown above will be deducted as given on part II (Self-Appraisal), except under exceptional circumstances.',
      'multi_rows'=>true,
      'columns'=>[
         1=>[
               'text'=>'S.No.',
               'input_type'=>false,
            ],
         2=>[
               'text'=>'Name of work for which charge sheet was required',
               'input_type'=>'text',
               'input_name'=>'col_1',
            ],
         3=>[
               'text'=>'Target Date of submission of charge sheet',
               'input_type'=>'text',
               'input_name'=>'col_2',
            ],
         4=>[
               'text'=>'Actual Date of submission of charge sheet to SE Office',
               'input_type'=>'text',
               'input_name'=>'col_3',
            ],
         5=>[
               'text'=>'Cause of delay if any',
               'input_type'=>'text',
               'input_name'=>'col_4',
            ],
      ],
   ],
   2011=>[ //
    //  'head'=>'submission of charge sheets',
      'head_note'=>'',
      'foot_note'=>'', //'Note :- If the officer does not submit the Enquiry Report within prescribed time, upto max marks shown above will be deducted as given on part II (Self-Appraisal), except under exceptional circumstances.',
      'multi_rows'=>false,
      'columns'=>[
         
         1=>[
               'text'=>'No of Technical sanction to be accorded on DPR',
               'input_type'=>'number',
               'input_name'=>'col_1',
            ],
         2=>[
               'text'=>'No. of Technical sanction accorded on DPR',
               'input_type'=>'number',
               'input_name'=>'col_2',
            ],
            
         3=>[
               'text'=>'Number of Technical sanction not accorded and the specific reasons if any',
               'input_type'=>'text',
               'input_name'=>'col_3',
            ],
      ],
   ],
   2012=>[ //
    //  'head'=>'',//'submission of charge sheets',
      'head_note'=>'',
      'foot_note'=>'', //'Note :- If the officer does not submit the Enquiry Report within prescribed time, upto max marks shown above will be deducted as given on part II (Self-Appraisal), except under exceptional circumstances.',
      'multi_rows'=>false,
      'columns'=>[
         
         1=>[
               'text'=>'No of works in progress in current financial year',
               'input_type'=>'number',
               'input_name'=>'col_1',
            ],
         2=>[
               'text'=>'No. of Works inspected by the officer and issued inspection note and copy sent to higher authorities',
               'input_type'=>'number',
               'input_name'=>'col_2',
            ],
            
         3=>[
               'text'=>'Number of works not inspected out and reasons thereof',
               'input_type'=>'text',
               'input_name'=>'col_3',
            ],
      ],
   ],
   2013=>[
    //'head'=>'',//'Preparation of Proposal of Alignment of Road and site selection of Bridge and submitted for sanction to Assistant Engineer.',
    'head_note'=>'',
    'foot_note'=>'',
    'multi_rows'=>false,
    'columns'=>[
         1=>[
               'text'=>'Total No to be submitted',
               'input_type'=>'number',
               'input_name'=>'col_1',
            ],
         2=>[
               'text'=>'No submitted ',
               'input_type'=>'number',
               'input_name'=>'col_2',
            ],
         3=>[
               'text'=>'Nos not submitted with the specific reasons thereof',
               'input_type'=>'text',
               'input_name'=>'col_3',
            ],
      ]
   ],
   2014=>[
    //'head'=>'',//'Quality Assurance Compliance of different.Works in progress during current financial year',
    'head_note'=>'',
    'foot_note'=>'',
    'multi_rows'=>false,
    'columns'=>[
         1=>[
               'text'=>'No of works in progress',
               'input_type'=>'number',
               'input_name'=>'col_1',
            ],
         2=>[
               'text'=>'No. of Works checked by the Higher official',
               'input_type'=>'number',
               'input_name'=>'col_2',
            ],
         3=>[
               'text'=>'No. of Works with Satisfactory Report',
               'input_type'=>'number',
               'input_name'=>'col_3',
            ],
         4=>[
               'text'=>'No. of Works with R.I Report',
               'input_type'=>'number',
               'input_name'=>'col_4',
            ],
         5=>[
               'text'=>'No. of Works with Unsatisfactory Report',
               'input_type'=>'number',
               'input_name'=>'col_5',
            ],
         6=>[
               'text'=>'Compliance made (No. of Works) R.I',
               'input_type'=>'number',
               'input_name'=>'col_6',
            ],
         7=>[
               'text'=>'Compliance made (No. of Works) Unsatisfactory',
               'input_type'=>'number',
               'input_name'=>'col_7',
            ],
      ]
   ],
   2015=>[
    //'head'=>'',//'Submission of RMR Account to Assistant Engineer office',
    'head_note'=>'',
    'foot_note'=>'',
    'multi_rows'=>false,
    'columns'=>[
         1=>[
               'text'=>'Total No. of RMR Account',
               'input_type'=>'number',
               'input_name'=>'col_1',
            ],
         2=>[
               'text'=>'Number of RMR Account Submitted to Assistant Engineer',
               'input_type'=>'number',
               'input_name'=>'col_2',
            ],
         3=>[
               'text'=>'Number of RMR Account Adjusted by Division Office',
               'input_type'=>'number',
               'input_name'=>'col_3',
            ],
         4=>[
               'text'=>'Number of Pending RMR Account in the Jurisdiction or the Junior Engineer',
               'input_type'=>'number',
               'input_name'=>'col_4',
            ],
      ]
   ],
   2016=>[
    //'head'=>'',//'Submission of T&P Account to Assistant Engineer office',
    'head_note'=>'',
    'foot_note'=>'',
    'multi_rows'=>false,
    'columns'=>[
         1=>[
               'text'=>'Total No. of T&P Account',
               'input_type'=>'number',
               'input_name'=>'col_1',
            ],
         2=>[
               'text'=>'Number of T&P Account Submitted to Assistant Engineer',
               'input_type'=>'number',
               'input_name'=>'col_2',
            ],
         3=>[
               'text'=>'Number of T&P Account Adjusted by Division Office',
               'input_type'=>'number',
               'input_name'=>'col_3',
            ],
         4=>[
               'text'=>'Number of Pending T&P Account in the Jurisdiction or the Junior Engineer',
               'input_type'=>'number',
               'input_name'=>'col_4',
            ],
      ]
   ],
   3001=>[
      'head'=>'Action on Administrative Matters and Policy Implementation',
      'head_note'=>'',
      'foot_note'=>'',
      'multi_rows'=>false,
      'columns'=>[],
   ],
   3002=>[
      'head'=>'Submission of Reports',
      'head_note'=>'',
      'foot_note'=>'',
      'multi_rows'=>false,
      'columns'=>[],
   ],

 
];