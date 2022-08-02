<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Ae
 *
 * @property int|null $ee_office_id
 * @property string|null $id
 * @property string|null $name
 * @property string|null $name_h
 * @property string|null $AE_Add
 * @property string|null $AE_ph
 * @property int $unique_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Work[] $works
 * @property-read int|null $works_count
 * @method static \Illuminate\Database\Eloquent\Builder|Ae newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ae newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ae query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ae whereAEAdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ae whereAEPh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ae whereEeOfficeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ae whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ae whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ae whereNameH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ae whereUniqueId($value)
 */
	class Ae extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AeWork
 *
 * @property int $id
 * @property string $AE_code
 * @property string $WORK_code
 * @property string|null $emp_code
 * @property string|null $doe
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property string|null $doj
 * @property-read \App\Models\Employee $employee
 * @method static \Illuminate\Database\Eloquent\Builder|AeWork newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AeWork newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AeWork query()
 * @method static \Illuminate\Database\Eloquent\Builder|AeWork whereAECode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AeWork whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AeWork whereDoe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AeWork whereDoj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AeWork whereEmpCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AeWork whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AeWork whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AeWork whereWORKCode($value)
 */
	class AeWork extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AlertProject
 *
 * @property int $id
 * @property int $alert_for_id
 * @property string $project_detail
 * @property string $refference_no
 * @property \Illuminate\Support\Carbon|null $valid_from
 * @property \Illuminate\Support\Carbon $valid_upto
 * @property string|null $amount
 * @property string $contractor_details
 * @property string $issuing_authority
 * @property int $office_id
 * @property string|null $users_for_notification
 * @property string|null $remark
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \App\Models\AlertType $alertType
 * @property-read \App\Models\AlertType $alert_for
 * @property-read \App\Models\EeOffice $office
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $userForNotification
 * @property-read int|null $user_for_notification_count
 * @property-read \App\Models\WorkDashboard $workDashboard
 * @method static \Illuminate\Database\Eloquent\Builder|AlertProject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AlertProject newQuery()
 * @method static \Illuminate\Database\Query\Builder|AlertProject onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AlertProject query()
 * @method static \Illuminate\Database\Eloquent\Builder|AlertProject whereAlertForId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertProject whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertProject whereContractorDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertProject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertProject whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertProject whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertProject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertProject whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertProject whereIssuingAuthority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertProject whereOfficeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertProject whereProjectDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertProject whereRefferenceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertProject whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertProject whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertProject whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertProject whereUsersForNotification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertProject whereValidFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertProject whereValidUpto($value)
 * @method static \Illuminate\Database\Query\Builder|AlertProject withTrashed()
 * @method static \Illuminate\Database\Query\Builder|AlertProject withoutTrashed()
 */
	class AlertProject extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AlertType
 *
 * @property int $id
 * @property string $type
 * @property int $hr_before_1
 * @property int|null $hr_before_2
 * @property int|null $hr_before_3
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|AlertType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AlertType newQuery()
 * @method static \Illuminate\Database\Query\Builder|AlertType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AlertType query()
 * @method static \Illuminate\Database\Eloquent\Builder|AlertType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertType whereHrBefore1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertType whereHrBefore2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertType whereHrBefore3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertType whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|AlertType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|AlertType withoutTrashed()
 */
	class AlertType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AllotmentBackup
 *
 * @property int $id
 * @property string|null $work_code
 * @property float|null $ALOTMENT
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AllotmentBackup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AllotmentBackup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AllotmentBackup query()
 * @method static \Illuminate\Database\Eloquent\Builder|AllotmentBackup whereALOTMENT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllotmentBackup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllotmentBackup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllotmentBackup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AllotmentBackup whereWorkCode($value)
 */
	class AllotmentBackup extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AnnualPhysicalTargetAchievement
 *
 * @property string $WORK_code
 * @property int $yearno
 * @property float|null $plength
 * @property float|null $pno
 * @property float|null $pspan
 * @property int|null $pjob
 * @property int|null $pbuild
 * @property float|null $plength_t
 * @property float|null $pno_t
 * @property float|null $pspan_t
 * @property int|null $pjob_t
 * @property int|null $pbuild_t
 * @property int|null $lastdata
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualPhysicalTargetAchievement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualPhysicalTargetAchievement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualPhysicalTargetAchievement query()
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualPhysicalTargetAchievement whereLastdata($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualPhysicalTargetAchievement wherePbuild($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualPhysicalTargetAchievement wherePbuildT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualPhysicalTargetAchievement wherePjob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualPhysicalTargetAchievement wherePjobT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualPhysicalTargetAchievement wherePlength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualPhysicalTargetAchievement wherePlengthT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualPhysicalTargetAchievement wherePno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualPhysicalTargetAchievement wherePnoT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualPhysicalTargetAchievement wherePspan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualPhysicalTargetAchievement wherePspanT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualPhysicalTargetAchievement whereWORKCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnnualPhysicalTargetAchievement whereYearno($value)
 */
	class AnnualPhysicalTargetAchievement extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AuditLog
 *
 * @property int $id
 * @property string $description
 * @property int|null $subject_id
 * @property string|null $subject_type
 * @property int|null $user_id
 * @property \Illuminate\Support\Collection|null $properties
 * @property string|null $host
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AuditLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AuditLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AuditLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|AuditLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditLog whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditLog whereHost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditLog whereProperties($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditLog whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditLog whereSubjectType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuditLog whereUserId($value)
 */
	class AuditLog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Block
 *
 * @property int $id
 * @property int $district_id
 * @property string $name
 * @property string $name_h
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\District $district
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tehsil[] $tehsils
 * @property-read int|null $tehsils_count
 * @method static \Illuminate\Database\Eloquent\Builder|Block newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Block newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Block query()
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereNameH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereUpdatedAt($value)
 */
	class Block extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Bottleneck
 *
 * @property int $id
 * @property string $name
 * @property string $name_h
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Bottleneck newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bottleneck newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bottleneck query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bottleneck whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bottleneck whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bottleneck whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bottleneck whereNameH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bottleneck whereUpdatedAt($value)
 */
	class Bottleneck extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BottleneckBackup
 *
 * @property int $id
 * @property string|null $work_code
 * @property int|null $Bottelneck
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BottleneckBackup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BottleneckBackup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BottleneckBackup query()
 * @method static \Illuminate\Database\Eloquent\Builder|BottleneckBackup whereBottelneck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BottleneckBackup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BottleneckBackup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BottleneckBackup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BottleneckBackup whereWorkCode($value)
 */
	class BottleneckBackup extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CeOffice
 *
 * @property int $id
 * @property string $name
 * @property string|null $name_h
 * @property string $address
 * @property string|null $district
 * @property string|null $contact_no
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $is_exist
 * @property int|null $hr_office_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $email
 * @property string|null $head_emp_code
 * @property int|null $period_category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SeOffice[] $SeOffices
 * @property-read int|null $se_offices_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SeOffice[] $ceOfficeSeOffices
 * @property-read int|null $ce_office_se_offices_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EeOffice[] $eeOffices
 * @property-read int|null $ee_offices_count
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice newQuery()
 * @method static \Illuminate\Database\Query\Builder|CeOffice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice query()
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice whereContactNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice whereHeadEmpCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice whereHrOfficeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice whereIsExist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice whereNameH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice wherePeriodCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|CeOffice withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CeOffice withoutTrashed()
 */
	class CeOffice extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Constituency
 *
 * @property int $id
 * @property int $district_id
 * @property string $name
 * @property string|null $name_h
 * @property string|null $mla_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\District $district
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Work[] $works
 * @property-read int|null $works_count
 * @method static \Illuminate\Database\Eloquent\Builder|Constituency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Constituency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Constituency query()
 * @method static \Illuminate\Database\Eloquent\Builder|Constituency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Constituency whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Constituency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Constituency whereMlaName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Constituency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Constituency whereNameH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Constituency whereUpdatedAt($value)
 */
	class Constituency extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DemandBackup
 *
 * @property int $id
 * @property string|null $work_code
 * @property float|null $demand
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DemandBackup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DemandBackup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DemandBackup query()
 * @method static \Illuminate\Database\Eloquent\Builder|DemandBackup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DemandBackup whereDemand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DemandBackup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DemandBackup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DemandBackup whereWorkCode($value)
 */
	class DemandBackup extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Designation
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $short_code
 * @property int|null $is_active
 * @property int|null $sort_order
 * @method static \Illuminate\Database\Eloquent\Builder|Designation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Designation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Designation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Designation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Designation whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Designation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Designation whereShortCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Designation whereSortOrder($value)
 */
	class Designation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\District
 *
 * @property int $id
 * @property string $name
 * @property string $name_h
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Block[] $blocks
 * @property-read int|null $blocks_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Constituency[] $constituencies
 * @property-read int|null $constituencies_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tehsil[] $tehsils
 * @property-read int|null $tehsils_count
 * @method static \Illuminate\Database\Eloquent\Builder|District newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|District newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|District query()
 * @method static \Illuminate\Database\Eloquent\Builder|District whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereNameH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereUpdatedAt($value)
 */
	class District extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Document
 *
 * @property-read \App\Models\DocumentType $documentType
 * @property-read \App\Models\Work $work
 * @method static \Illuminate\Database\Eloquent\Builder|Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document query()
 */
	class Document extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DocumentType
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType genDocOnly($value = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType query()
 */
	class DocumentType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EeOffice
 *
 * @property int $id
 * @property int $se_office_id
 * @property string $name
 * @property string|null $name_h
 * @property string|null $addresss
 * @property string|null $district
 * @property int|null $contact_no
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float|null $phyper
 * @property float|null $finper
 * @property float|null $rank
 * @property int|null $is_exist
 * @property int|null $hr_office_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $tressury_code
 * @property int|null $ddo_code
 * @property string|null $email
 * @property string|null $head_emp_code
 * @property string|null $email_2
 * @property string|null $lat
 * @property string|null $lon
 * @property string|null $all_related_users
 * @property int|null $is_pwd
 * @property int|null $period_category
 * @property int|null $div_type 0=unknown,1=civil,2=nh,3=adb,4=wb,5=pmgsy
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ae[] $aes
 * @property-read int|null $aes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AlertProject[] $officeAlertProjects
 * @property-read int|null $office_alert_projects_count
 * @property-read \App\Models\Employee|null $officeHead
 * @property-read \App\Models\SeOffice $se_office
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice newQuery()
 * @method static \Illuminate\Database\Query\Builder|EeOffice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice query()
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereAddresss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereAllRelatedUsers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereContactNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereDdoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereDivType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereEmail2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereFinper($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereHeadEmpCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereHrOfficeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereIsExist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereIsPwd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereNameH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice wherePeriodCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice wherePhyper($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereSeOfficeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereTressuryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|EeOffice withTrashed()
 * @method static \Illuminate\Database\Query\Builder|EeOffice withoutTrashed()
 */
	class EeOffice extends \Eloquent implements \Spatie\MediaLibrary\HasMedia\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Employee
 *
 * @property string $id
 * @property string|null $name
 * @property int|null $phone_no
 * @property int|null $phone_no1
 * @property int|null $chat_id
 * @property int|null $chat_id1
 * @property int|null $office_type 1=ce,2=se,3=ee,0=enc
 * @property int|null $office_id
 * @property string|null $father_name
 * @property \Illuminate\Support\Carbon|null $joining_date
 * @property \Illuminate\Support\Carbon|null $birth_date
 * @property \Illuminate\Support\Carbon|null $retirement_date
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property int|null $designation_id
 * @property string|null $gender
 * @property string|null $h_district
 * @property string|null $h_state
 * @property string|null $h_tahsil
 * @property string|null $email
 * @property int|null $phone_no
 * @property int|null $s_y
 * @property int|null $s_m
 * @property int|null $s_d
 * @property int|null $s_t
 * @property int|null $d_y
 * @property int|null $d_m
 * @property int|null $d_d
 * @property int|null $d_t
 * @property string|null $last_office_name
 * @property int|null $last_office_type
 * @property int|null $orignal_office_days
 * @property string|null $orignal_office_name
 * @property int|null $orignal_office_type
 * @property int|null $durgam_days_reduction
 * @property int|null $is_locked
 * @property-read \App\Models\Designation|null $designation
 * @property-read mixed $nameemp
 * @method static \Illuminate\Database\Eloquent\Builder|Employee aeOnly()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereChatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereChatId1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDM($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDesignationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDurgamDaysReduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereFatherName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereHDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereHState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereHTahsil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereIsLocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereJoiningDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereLastOfficeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereLastOfficeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereOfficeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereOfficeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereOrignalOfficeDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereOrignalOfficeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereOrignalOfficeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePhoneNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePhoneNo1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereRetirementDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereSD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereSM($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereST($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereSY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUpdatedAt($value)
 */
	class Employee extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FinancialProgress
 *
 * @property int $id
 * @property string $WORK_code
 * @property float $expe
 * @property \Illuminate\Support\Carbon $doe
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $remark
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialProgress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialProgress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialProgress query()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialProgress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialProgress whereDoe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialProgress whereExpe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialProgress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialProgress whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialProgress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialProgress whereWORKCode($value)
 */
	class FinancialProgress extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ForestProposal
 *
 * @property int $id
 * @property string|null $no
 * @property string|null $WORK_code
 * @property string|null $name
 * @property string|null $area
 * @property int|null $tree
 * @property string|null $forest_division
 * @property string|null $kml_file
 * @property string|null $users_for_notification comma seperated value of user id
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $status_date
 * @property int|null $onlineuserid
 * @property string|null $user_agency_name
 * @property \Illuminate\Support\Carbon|null $date_from_ua_to_nodal
 * @property \Illuminate\Support\Carbon|null $date_of_recomm
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $timeline_updated_at
 * @property-read \App\Models\WorkDashboard|null $work
 * @method static \Illuminate\Database\Eloquent\Builder|ForestProposal filteredForReleventMsg()
 * @method static \Illuminate\Database\Eloquent\Builder|ForestProposal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ForestProposal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ForestProposal query()
 * @method static \Illuminate\Database\Eloquent\Builder|ForestProposal whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForestProposal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForestProposal whereDateFromUaToNodal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForestProposal whereDateOfRecomm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForestProposal whereForestDivision($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForestProposal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForestProposal whereKmlFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForestProposal whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForestProposal whereNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForestProposal whereOnlineuserid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForestProposal whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForestProposal whereStatusDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForestProposal whereTimelineUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForestProposal whereTree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForestProposal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForestProposal whereUserAgencyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForestProposal whereUsersForNotification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForestProposal whereWORKCode($value)
 */
	class ForestProposal extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\IfmsAllotment
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $doe
 * @property int $grant
 * @property int $major_head
 * @property int $scheme_code
 * @property string $scheme_type
 * @property string $ddo_code
 * @property int $amount
 * @property string $status
 * @method static \Illuminate\Database\Eloquent\Builder|IfmsAllotment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IfmsAllotment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IfmsAllotment query()
 * @method static \Illuminate\Database\Eloquent\Builder|IfmsAllotment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IfmsAllotment whereDdoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IfmsAllotment whereDoe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IfmsAllotment whereGrant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IfmsAllotment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IfmsAllotment whereMajorHead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IfmsAllotment whereSchemeCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IfmsAllotment whereSchemeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IfmsAllotment whereStatus($value)
 */
	class IfmsAllotment extends \Eloquent {}
}

namespace App\Models\Nabard{
/**
 * App\Models\Nabard\NabardLoanDisburshment
 *
 * @property int $id
 * @property string|null $picno
 * @property \Illuminate\Support\Carbon|null $doe
 * @property string|null $disbursment
 * @property string|null $advance_recovery
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|NabardLoanDisburshment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NabardLoanDisburshment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NabardLoanDisburshment query()
 * @method static \Illuminate\Database\Eloquent\Builder|NabardLoanDisburshment whereAdvanceRecovery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NabardLoanDisburshment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NabardLoanDisburshment whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NabardLoanDisburshment whereDisbursment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NabardLoanDisburshment whereDoe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NabardLoanDisburshment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NabardLoanDisburshment wherePicno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NabardLoanDisburshment whereUpdatedAt($value)
 */
	class NabardLoanDisburshment extends \Eloquent {}
}

namespace App\Models\Nabard{
/**
 * App\Models\Nabard\NabardWorkDetail
 *
 * @property string|null $WORK_code
 * @property string $picno
 * @property string|null $ridf_loan
 * @property string|null $advance
 * @property string|null $pcc_at
 * @property string|null $pcr_at
 * @property string|null $disburshment_total
 * @property string|null $advance_recovery_total
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nabard\NabardLoanDisburshment[] $nlrs
 * @property-read int|null $nlrs_count
 * @method static \Illuminate\Database\Eloquent\Builder|NabardWorkDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NabardWorkDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NabardWorkDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|NabardWorkDetail whereAdvance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NabardWorkDetail whereAdvanceRecoveryTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NabardWorkDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NabardWorkDetail whereDisburshmentTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NabardWorkDetail wherePccAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NabardWorkDetail wherePcrAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NabardWorkDetail wherePicno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NabardWorkDetail whereRidfLoan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NabardWorkDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NabardWorkDetail whereWORKCode($value)
 */
	class NabardWorkDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OfficeJob
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OfficeJobDefault[] $usersAndOfiices
 * @property-read int|null $users_and_ofiices_count
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJob newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJob newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJob query()
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJob whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJob whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJob whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJob whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJob whereUpdatedAt($value)
 */
	class OfficeJob extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OfficeJobDefault
 *
 * @property int $id
 * @property int $ee_office_id
 * @property int $job_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\EeOffice $eeOffice
 * @property-read \App\Models\OfficeJob $jobType
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJobDefault newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJobDefault newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJobDefault query()
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJobDefault whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJobDefault whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJobDefault whereEeOfficeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJobDefault whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJobDefault whereJobId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJobDefault whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJobDefault whereUserId($value)
 */
	class OfficeJobDefault extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Query\Builder|Permission onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Permission withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Permission withoutTrashed()
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PhysicalProgress
 *
 * @property string $WORK_code
 * @property \Illuminate\Support\Carbon $doe
 * @property int $proitem_id
 * @property float|null $remaining
 * @property float|null $target
 * @property float|null $achivement
 * @property int|null $lastdata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ProgressItem $progressItems
 * @property-read \App\Models\WorkDashboard $workdashboard
 * @method static \Illuminate\Database\Eloquent\Builder|PhysicalProgress absLast()
 * @method static \Illuminate\Database\Eloquent\Builder|PhysicalProgress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PhysicalProgress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PhysicalProgress query()
 * @method static \Illuminate\Database\Eloquent\Builder|PhysicalProgress whereAchivement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhysicalProgress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhysicalProgress whereDoe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhysicalProgress whereLastdata($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhysicalProgress whereProitemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhysicalProgress whereRemaining($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhysicalProgress whereTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhysicalProgress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhysicalProgress whereWORKCode($value)
 */
	class PhysicalProgress extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Priority
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $name_h
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\WorkDetail[] $workDetails
 * @property-read int|null $work_details_count
 * @method static \Illuminate\Database\Eloquent\Builder|Priority newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Priority newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Priority query()
 * @method static \Illuminate\Database\Eloquent\Builder|Priority whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Priority whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Priority whereNameH($value)
 */
	class Priority extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProgressItem
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $category
 * @property string|null $name_h
 * @property string|null $unit
 * @property mixed|null $unit_h
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PhysicalProgress[] $physicalProgress
 * @property-read int|null $physical_progress_count
 * @method static \Illuminate\Database\Eloquent\Builder|ProgressItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgressItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgressItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgressItem whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgressItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgressItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgressItem whereNameH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgressItem whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgressItem whereUnitH($value)
 */
	class ProgressItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RoadBasicdatum
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RoadDiv[] $roadRoadDivs
 * @property-read int|null $road_road_divs_count
 * @method static \Illuminate\Database\Eloquent\Builder|RoadBasicdatum newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoadBasicdatum newQuery()
 * @method static \Illuminate\Database\Query\Builder|RoadBasicdatum onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RoadBasicdatum query()
 * @method static \Illuminate\Database\Query\Builder|RoadBasicdatum withTrashed()
 * @method static \Illuminate\Database\Query\Builder|RoadBasicdatum withoutTrashed()
 */
	class RoadBasicdatum extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RoadDiv
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EeOffice[] $divisions
 * @property-read int|null $divisions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RoadBasicdatum[] $roads
 * @property-read int|null $roads_count
 * @method static \Illuminate\Database\Eloquent\Builder|RoadDiv newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoadDiv newQuery()
 * @method static \Illuminate\Database\Query\Builder|RoadDiv onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RoadDiv query()
 * @method static \Illuminate\Database\Query\Builder|RoadDiv withTrashed()
 * @method static \Illuminate\Database\Query\Builder|RoadDiv withoutTrashed()
 */
	class RoadDiv extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Query\Builder|Role onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Role withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Role withoutTrashed()
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SeOffice
 *
 * @property int $id
 * @property int $ce_office_id
 * @property string $name
 * @property string|null $name_h
 * @property string $address
 * @property string|null $district
 * @property string|null $contact_no
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $is_exist
 * @property int|null $hr_office_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $email
 * @property string|null $head_emp_code
 * @property int|null $ddo_code
 * @property int|null $treasury_code
 * @property int|null $period_category
 * @property-read \App\Models\CeOffice $ce_office
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EeOffice[] $seOfficeEeOffices
 * @property-read int|null $se_office_ee_offices_count
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice newQuery()
 * @method static \Illuminate\Database\Query\Builder|SeOffice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice query()
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereCeOfficeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereContactNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereDdoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereHeadEmpCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereHrOfficeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereIsExist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereNameH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice wherePeriodCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereTreasuryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|SeOffice withTrashed()
 * @method static \Illuminate\Database\Query\Builder|SeOffice withoutTrashed()
 */
	class SeOffice extends \Eloquent implements \Spatie\MediaLibrary\HasMedia\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\StatusOfWork
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $name_h
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|StatusOfWork newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusOfWork newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusOfWork query()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusOfWork whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusOfWork whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusOfWork whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusOfWork whereNameH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusOfWork whereUpdatedAt($value)
 */
	class StatusOfWork extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Tehsil
 *
 * @property int $id
 * @property int $district_id
 * @property int $block_id
 * @property string $name
 * @property string $name_h
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Block $block
 * @property-read \App\Models\District $district
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Work[] $works
 * @property-read int|null $works_count
 * @method static \Illuminate\Database\Eloquent\Builder|Tehsil newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tehsil newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tehsil query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tehsil whereBlockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tehsil whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tehsil whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tehsil whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tehsil whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tehsil whereNameH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tehsil whereUpdatedAt($value)
 */
	class Tehsil extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TentativeCompletionDateBackup
 *
 * @property int $id
 * @property string|null $work_code
 * @property string|null $TC_DATE
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TentativeCompletionDateBackup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TentativeCompletionDateBackup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TentativeCompletionDateBackup query()
 * @method static \Illuminate\Database\Eloquent\Builder|TentativeCompletionDateBackup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TentativeCompletionDateBackup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TentativeCompletionDateBackup whereTCDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TentativeCompletionDateBackup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TentativeCompletionDateBackup whereWorkCode($value)
 */
	class TentativeCompletionDateBackup extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $name_h
 * @property string $email
 * @property string|null $avatar
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $oldcode
 * @property string|null $designation
 * @property int|null $approved
 * @property int|null $user_type 0=office,1=individulal
 * @property int|null $chat_id
 * @property \Illuminate\Support\Carbon|null $verified_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $verification_token
 * @property int|null $verified
 * @property int|null $status
 * @property string|null $emp_code
 * @property int|null $contact_no
 * @property string|null $remark
 * @property string $password
 * @property string|null $remember_token
 * @property mixed|null $notification_channel
 * @property mixed|null $notification_on
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read int|null $clients_count
 * @property-read mixed $is_admin
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereChatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereContactNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmpCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNameH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNotificationChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNotificationOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOldcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereVerificationToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereVerifiedAt($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserIm
 *
 * @property int $id
 * @property string $name
 * @property string|null $name_h
 * @property string $email
 * @property string|null $avatar
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $oldcode
 * @property string|null $designation
 * @property int|null $approved
 * @property int|null $user_type 0=office,1=individulal
 * @property int|null $chat_id
 * @property \Illuminate\Support\Carbon|null $verified_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $verification_token
 * @property int|null $verified
 * @property int|null $status
 * @property string|null $emp_code
 * @property int|null $contact_no
 * @property string|null $remark
 * @property string $password
 * @property string|null $remember_token
 * @property mixed|null $notification_channel
 * @property mixed|null $notification_on
 * @method static \Illuminate\Database\Eloquent\Builder|UserIm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserIm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserIm query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserIm whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserIm whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserIm whereChatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserIm whereContactNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserIm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserIm whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserIm whereDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserIm whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserIm whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserIm whereEmpCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserIm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserIm whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserIm whereNameH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserIm whereNotificationChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserIm whereNotificationOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserIm whereOldcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserIm wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserIm whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserIm whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserIm whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserIm whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserIm whereUserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserIm whereVerificationToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserIm whereVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserIm whereVerifiedAt($value)
 */
	class UserIm extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Work
 *
 * @property int|null $constituencies_id
 * @property int|null $ee_office_id
 * @property string $WORK_code
 * @property string|null $WORK_name
 * @property int|null $workserial
 * @property int|null $block_id
 * @property int|null $tahsil_id
 * @property float|null $road_type_id
 * @property string|null $road_id
 * @property string|null $work_nick
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ae[] $ae
 * @property-read int|null $ae_count
 * @property-read \App\Models\Block|null $block
 * @property-read \App\Models\Constituency|null $constituency
 * @property-read \App\Models\District $district
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[] $documents
 * @property-read int|null $documents_count
 * @property-read \App\Models\EeOffice|null $eeOffice
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Employee[] $employeeAsAe
 * @property-read int|null $employee_as_ae_count
 * @property-read \App\Models\Tehsil|null $tehsil
 * @property-read \App\Models\WorkDashboard|null $workDashboard
 * @property-read \App\Models\WorkDetail|null $workDetail
 * @property-read \App\Models\WorkDetail|null $workLive
 * @method static \Illuminate\Database\Eloquent\Builder|Work newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Work newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Work query()
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereBlockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereConstituenciesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereEeOfficeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereRoadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereRoadTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereTahsilId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereWORKCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereWORKName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereWorkNick($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereWorkserial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work withAndWhereHas($relation, $constraint)
 */
	class Work extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\WorkDashboard
 *
 * @property string $WORK_code
 * @property int|null $constituencies_id
 * @property int|null $ee_office_id
 * @property string|null $WORK_name
 * @property int|null $workserial
 * @property int|null $block_id
 * @property int|null $tahsil_id
 * @property float|null $road_type_id
 * @property string|null $road_id
 * @property string|null $date_survey
 * @property int|null $work_type_id
 * @property float|null $S_LO
 * @property int|null $S_B_NO
 * @property float|null $B_SO
 * @property float|null $S_LC
 * @property int|null $S_B_NC
 * @property float|null $B_SOC
 * @property \Illuminate\Support\Carbon|null $SYEAR
 * @property \Illuminate\Support\Carbon|null $STYEAR
 * @property float|null $SCOST
 * @property float|null $RSCOST
 * @property float|null $TCOST
 * @property float|null $LEX
 * @property float|null $DEMAND
 * @property float|null $ALOTMENT
 * @property int|null $PERCENT
 * @property int|null $yozana_id
 * @property string|null $AA
 * @property \Illuminate\Support\Carbon|null $AA_DATE
 * @property \Illuminate\Support\Carbon|null $TC_DATE
 * @property int $worktaken
 * @property string|null $remark
 * @property int $forest_case
 * @property string|null $Villagetoconnect
 * @property int|null $status_of_work_id
 * @property int|null $Bottelneck
 * @property int|null $sjob
 * @property int|null $rjob
 * @property int|null $sbuild
 * @property int|null $rbuild
 * @property int|null $atal_yozana
 * @property int|null $cm_announce
 * @property int|null $priority
 * @property float|null $length_a
 * @property float|null $no_a
 * @property float|null $span_a
 * @property float|null $job_a
 * @property float|null $build_a
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float|null $exp_cm
 * @property float|null $exp_fy
 * @property float|null $exp_total
 * @property int|null $district_id
 * @property string|null $forest_status
 * @property float|null $length_t
 * @property float|null $no_t
 * @property float|null $span_t
 * @property float|null $job_t
 * @property float|null $build_t
 * @property string|null $remark1
 * @property string|null $remark2
 * @property float|null $ts_amt
 * @property int|null $se_office_id
 * @property int|null $prog_rank
 * @property int|null $yozana_main_id
 * @property string|null $work_closed_on
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PhysicalProgress[] $physicalProgress
 * @property-read int|null $physical_progress_count
 * @property-read \App\Models\Work|null $work
 * @property-read \App\Models\WorkType|null $workType
 * @property-read \App\Models\Yozana|null $yozana
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard query()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereAA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereAADATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereALOTMENT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereAtalYozana($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereBSO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereBSOC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereBlockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereBottelneck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereBuildA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereBuildT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereCmAnnounce($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereConstituenciesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereDEMAND($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereDateSurvey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereEeOfficeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereExpCm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereExpFy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereExpTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereForestCase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereForestStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereJobA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereJobT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereLEX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereLengthA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereLengthT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereNoA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereNoT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard wherePERCENT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereProgRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereRSCOST($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereRbuild($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereRemark1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereRemark2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereRjob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereRoadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereRoadTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereSBNC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereSBNO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereSCOST($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereSLC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereSLO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereSTYEAR($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereSYEAR($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereSbuild($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereSeOfficeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereSjob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereSpanA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereSpanT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereStatusOfWorkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereTCDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereTCOST($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereTahsilId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereTsAmt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereVillagetoconnect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereWORKCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereWORKName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereWorkClosedOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereWorkTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereWorkserial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereWorktaken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereYozanaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDashboard whereYozanaMainId($value)
 */
	class WorkDashboard extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\WorkDetail
 *
 * @property string $WORK_code
 * @property string|null $date_survey
 * @property int|null $work_type_id
 * @property float|null $S_LO
 * @property int|null $S_B_NO
 * @property float|null $B_SO
 * @property float|null $S_LC
 * @property int|null $S_B_NC
 * @property float|null $B_SOC
 * @property \Illuminate\Support\Carbon|null $SYEAR
 * @property \Illuminate\Support\Carbon|null $STYEAR
 * @property float|null $SCOST
 * @property float|null $RSCOST
 * @property float|null $TCOST
 * @property float|null $LEX
 * @property float|null $DEMAND
 * @property float|null $ALOTMENT
 * @property int|null $PERCENT
 * @property int|null $yozana_id
 * @property string|null $AA
 * @property \Illuminate\Support\Carbon|null $AA_DATE
 * @property \Illuminate\Support\Carbon|null $TC_DATE
 * @property int $worktaken
 * @property string|null $remark
 * @property int $forest_case
 * @property string|null $Villagetoconnect
 * @property int|null $status_of_work_id
 * @property int|null $Bottelneck
 * @property int|null $sjob
 * @property int|null $rjob
 * @property int|null $sbuild
 * @property int|null $rbuild
 * @property int|null $atal_yozana
 * @property int|null $cm_announce
 * @property int|null $priority
 * @property string|null $remark1
 * @property string|null $remark2
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $work_closed_on
 * @property-read \App\Models\Priority|null $priorityName
 * @property-read \App\Models\Work|null $work
 * @property-read \App\Models\WorkType|null $workType
 * @property-read \App\Models\Yozana|null $yozana
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereAA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereAADATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereALOTMENT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereAtalYozana($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereBSO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereBSOC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereBottelneck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereCmAnnounce($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereDEMAND($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereDateSurvey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereForestCase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereLEX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail wherePERCENT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereRSCOST($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereRbuild($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereRemark1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereRemark2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereRjob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereSBNC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereSBNO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereSCOST($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereSLC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereSLO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereSTYEAR($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereSYEAR($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereSbuild($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereSjob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereStatusOfWorkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereTCDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereTCOST($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereVillagetoconnect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereWORKCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereWorkClosedOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereWorkTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereWorktaken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDetail whereYozanaId($value)
 */
	class WorkDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\WorkStatusBackup
 *
 * @property int $id
 * @property string|null $work_code
 * @property int|null $status_of_work_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|WorkStatusBackup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkStatusBackup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkStatusBackup query()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkStatusBackup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkStatusBackup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkStatusBackup whereStatusOfWorkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkStatusBackup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkStatusBackup whereWorkCode($value)
 */
	class WorkStatusBackup extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\WorkType
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $name_h
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|WorkType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkType query()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkType whereNameH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkType whereUpdatedAt($value)
 */
	class WorkType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Yozana
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $name_h
 * @property int|null $main_id
 * @property string|null $main_name
 * @property string|null $main_name_h
 * @property int|null $yozana_sort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Yozana newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Yozana newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Yozana query()
 * @method static \Illuminate\Database\Eloquent\Builder|Yozana whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Yozana whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Yozana whereMainId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Yozana whereMainName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Yozana whereMainNameH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Yozana whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Yozana whereNameH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Yozana whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Yozana whereYozanaSort($value)
 */
	class Yozana extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\user_office
 *
 * @property int|null $user_id
 * @property string|null $user_office_type
 * @property int|null $user_office_id
 * @property int|null $import_allowed
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|user_office newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|user_office newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|user_office query()
 * @method static \Illuminate\Database\Eloquent\Builder|user_office whereImportAllowed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|user_office whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|user_office whereUserOfficeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|user_office whereUserOfficeType($value)
 */
	class user_office extends \Eloquent {}
}

