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
 * App\Models\AdmissionFee
 *
 * @property int $id
 * @property string $unit_name
 * @property float $amount
 * @method static \Illuminate\Database\Eloquent\Builder|AdmissionFee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdmissionFee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdmissionFee query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdmissionFee units($param)
 * @method static \Illuminate\Database\Eloquent\Builder|AdmissionFee whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdmissionFee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdmissionFee whereUnitName($value)
 */
	class AdmissionFee extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AdmitCard
 *
 * @method static \Illuminate\Database\Eloquent\Builder|AdmitCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdmitCard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdmitCard query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdmitCard roll($param)
 * @method static \Illuminate\Database\Eloquent\Builder|AdmitCard tracking($param)
 * @method static \Illuminate\Database\Eloquent\Builder|AdmitCard unit($param)
 */
	class AdmitCard extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AppLog
 *
 * @method static \Illuminate\Database\Eloquent\Builder|AppLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppLog query()
 */
	class AppLog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Application
 *
 * @property int $id
 * @property int $bill_id
 * @property int $applicant_id
 * @property string $name
 * @property string $fname
 * @property string|null $sex
 * @property string $mname
 * @property string $hsc_roll
 * @property string $hsc_board
 * @property int $hsc_year
 * @property string $hsc_group
 * @property string $unit
 * @property string|null $quota
 * @property string $mobile_no
 * @property int|null $admission_roll
 * @property string|null $photo
 * @property int $download_count
 * @property string|null $exam_group
 * @property string|null $RU_HSC_GROUP
 * @property string|null $RANDOM_STRING
 * @property string|null $building
 * @property string|null $room
 * @property int|null $seat
 * @property int|null $room_roll_start
 * @property string|null $exam_date
 * @property string|null $exam_time
 * @property string|null $is_english
 * @property string|null $is_pdq
 * @property int|null $exam_group_no
 * @property string|null $sub_allow
 * @property string|null $omr_id
 * @property string|null $bundle_no
 * @property string|null $scan_sequence
 * @property int|null $SERIAL_BY_RANDOM_STRING
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Hsc|null $student
 * @property-read \App\Models\SubjectOption|null $subjectOption
 * @method static \Illuminate\Database\Eloquent\Builder|Application newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application query()
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereAdmissionRoll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereApplicantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereBillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereBuilding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereBundleNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereDownloadCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereExamDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereExamGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereExamGroupNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereExamTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereFname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereHscBoard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereHscGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereHscRoll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereHscYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereIsEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereIsPdq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereMname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereMobileNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereOmrId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereQuota($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereRANDOMSTRING($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereRUHSCGROUP($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereRoom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereRoomRollStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereSERIALBYRANDOMSTRING($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereScanSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereSeat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereSubAllow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereUpdatedAt($value)
 */
	class Application extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Bill
 *
 * @property int $id
 * @property int $applicant_id
 * @property string $bill_number
 * @property float $amount
 * @property string|null $bkash_payment_id
 * @property string|null $rocket_payment_id
 * @property string|null $units
 * @property string|null $quota
 * @property string|null $quota_docs
 * @property string|null $FFQ_type
 * @property string $mobile_no
 * @property string|null $payment_method
 * @property string|null $trx_id
 * @property string|null $rocket_trx_id
 * @property string|null $payment_date
 * @property string $payment_purpose
 * @property string $payment_status
 * @property string|null $photo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Application> $applications
 * @property-read int|null $applications_count
 * @property-read \App\Models\PhotoReview|null $photoReview
 * @property-read \App\Models\Hsc|null $student
 * @method static \Illuminate\Database\Eloquent\Builder|Bill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bill preApplicationBill($param = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereApplicantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereBillNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereBkashPaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereFFQType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereMobileNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill wherePaymentPurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereQuota($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereQuotaDocs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereRocketPaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereRocketTrxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereTrxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereUnits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereUpdatedAt($value)
 */
	class Bill extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Board
 *
 * @property int $id
 * @property string $exam
 * @property string $board_name
 * @property string $display_name
 * @method static \Illuminate\Database\Eloquent\Builder|Board newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Board newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Board query()
 * @method static \Illuminate\Database\Eloquent\Builder|Board whereBoardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Board whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Board whereExam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Board whereId($value)
 */
	class Board extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ComplainType
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ComplainType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ComplainType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ComplainType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ComplainType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplainType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplainType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplainType whereUpdatedAt($value)
 */
	class ComplainType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Department
 *
 * @property int $id
 * @property string $name
 * @property string $dept_code
 * @property int $faculty_id
 * @property int $seats
 * @property string|null $degree_name
 * @property string|null $short_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Faculty|null $faculty
 * @method static \Illuminate\Database\Eloquent\Builder|Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Department query()
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereDegreeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereDeptCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereFacultyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereSeats($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereUpdatedAt($value)
 */
	class Department extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\District
 *
 * @property int $id
 * @property string $name
 * @property int $division_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Division|null $division
 * @method static \Illuminate\Database\Eloquent\Builder|District newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|District newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|District query()
 * @method static \Illuminate\Database\Eloquent\Builder|District whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereDivisionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereUpdatedAt($value)
 */
	class District extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Division
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\District> $districts
 * @property-read int|null $districts_count
 * @method static \Illuminate\Database\Eloquent\Builder|Division newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Division newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Division query()
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereUpdatedAt($value)
 */
	class Division extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Enrollment
 *
 * @property int $id
 * @property int $applicant_id
 * @property int $bill_id
 * @property string $unit
 * @property string|null $quota
 * @property string $status
 * @property string $applied
 * @property string|null $RU_HSC_GROUP
 * @property string|null $HSC_GPA
 * @property string|null $CONV_1000
 * @property int|null $MERIT
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $phase
 * @property-read \App\Models\Bill|null $bill
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment whereApplicantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment whereApplied($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment whereBillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment whereCONV1000($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment whereHSCGPA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment whereMERIT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment wherePhase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment whereQuota($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment whereRUHSCGROUP($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment whereUpdatedAt($value)
 */
	class Enrollment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Faculty
 *
 * @property int $id
 * @property string $faculty_name
 * @property int $unit_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Department> $departments
 * @property-read int|null $departments_count
 * @property-read \App\Models\Unit|null $unit
 * @method static \Illuminate\Database\Eloquent\Builder|Faculty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Faculty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Faculty query()
 * @method static \Illuminate\Database\Eloquent\Builder|Faculty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faculty whereFacultyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faculty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faculty whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faculty whereUpdatedAt($value)
 */
	class Faculty extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Group
 *
 * @property int $id
 * @property string $exam
 * @property string $group_name
 * @property string $display_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Group exam($param)
 * @method static \Illuminate\Database\Eloquent\Builder|Group newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Group newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Group query()
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereExam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereGroupName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereUpdatedAt($value)
 */
	class Group extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Hall
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $hall_code
 * @property int|null $seats
 * @property int|null $assigned
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Hall newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Hall newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Hall query()
 * @method static \Illuminate\Database\Eloquent\Builder|Hall whereAssigned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hall whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hall whereHallCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hall whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hall whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hall whereSeats($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hall whereUpdatedAt($value)
 */
	class Hall extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Hsc
 *
 * @property int $id
 * @property string|null $NAME
 * @property string|null $FNAME
 * @property string|null $MNAME
 * @property string|null $DOB
 * @property string|null $SEX
 * @property string|null $EXAM_NAME
 * @property string|null $HSC_VERSION
 * @property string|null $HSC_REGNO
 * @property string|null $HSC_SESSION
 * @property string|null $HSC_BOARD_NAME
 * @property string|null $HSC_PASS_YEAR
 * @property string|null $HSC_ROLL_NO
 * @property string|null $C_TYPE
 * @property string|null $HSC_RESULT
 * @property string|null $HSC_GPA
 * @property string|null $TOT_OBT_ORI
 * @property string|null $TOT_OBT
 * @property string|null $TOT_FULL_ORI
 * @property string|null $TOT_FULL
 * @property string|null $CONV_1000_ORI
 * @property string|null $CONV_1000
 * @property string|null $HSC_LTRGRD
 * @property string $HSC_MARKS
 * @property string|null $HSC_GROUP
 * @property string|null $RU_HSC_GROUP
 * @property int|null $SCRUTINIZED
 * @property int $SSC_DATA
 * @property string|null $SSC_NAME
 * @property string|null $SSC_REGNO
 * @property string|null $SSC_SESSION
 * @property string|null $SSC_BOARD_NAME
 * @property string|null $SSC_PASS_YEAR
 * @property string|null $SSC_ROLL_NO
 * @property string|null $SSC_C_TYPE
 * @property string|null $SSC_GROUP
 * @property string|null $SSC_RESULT
 * @property string|null $SSC_GPA
 * @property string|null $SSC_LTRGRD
 * @property string|null $TOTAL_GPA
 * @property string $A
 * @property string $B
 * @property string $C
 * @property string $D
 * @property string $E
 * @property string|null $mobile_no
 * @property string|null $mobile_verification_code
 * @property int|null $mobile_no_verified
 * @property string|null $email
 * @property int|null $email_verified
 * @property string|null $email_verification_code
 * @property string|null $code_time
 * @property string|null $photo
 * @property string|null $selfie
 * @property string|null $suspect_photo
 * @property string|null $photo_similarity
 * @property string|null $SEQ_photo
 * @property string|null $PDQ_photo
 * @property string|null $WQ_photo
 * @property string|null $WQ_salary_id
 * @property string|null $FFQ_photo
 * @property string|null $FFQ_type
 * @property string|null $FFQ_number
 * @property string|null $BKSP_photo
 * @property string|null $tracking_no
 * @property string|null $oth_board
 * @property string|null $photo_status
 * @property string|null $selfie_status
 * @property string|null $photo_checked_by
 * @property int $has_photo
 * @property string|null $BIOLOGY
 * @property string|null $MATHEMATICS
 * @property int|null $edu_hsc_id
 * @property int|null $is_english
 * @property string|null $password
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Bill> $applicationBill
 * @property-read int|null $application_bill_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Application> $applications
 * @property-read int|null $applications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Bill> $bills
 * @property-read int|null $bills_count
 * @property-read \App\Models\Bill|null $enrollmentBill
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Enrollment> $enrollments
 * @property-read int|null $enrollments_count
 * @property-read mixed $eligibility_array
 * @property-read mixed $quota_array
 * @property-read mixed $quota_document_array
 * @property-read mixed $quota_string
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\User|null $photoCheckedBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PhotoReview> $photoReviews
 * @property-read int|null $photo_reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Result> $results
 * @property-read int|null $results_count
 * @property-read \App\Models\StudentDetails|null $studentDetails
 * @property-read \App\Models\SubjectOption|null $subjectOption
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc photoStatus($param)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc query()
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereBIOLOGY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereBKSPPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereCONV1000($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereCONV1000ORI($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereCTYPE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereCodeTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereDOB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereEXAMNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereEduHscId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereEmailVerificationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereEmailVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereFFQNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereFFQPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereFFQType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereFNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereHSCBOARDNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereHSCGPA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereHSCGROUP($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereHSCLTRGRD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereHSCMARKS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereHSCPASSYEAR($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereHSCREGNO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereHSCRESULT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereHSCROLLNO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereHSCSESSION($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereHSCVERSION($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereHasPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereIsEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereMATHEMATICS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereMNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereMobileNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereMobileNoVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereMobileVerificationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereOthBoard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc wherePDQPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc wherePhotoCheckedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc wherePhotoSimilarity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc wherePhotoStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereRUHSCGROUP($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereSCRUTINIZED($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereSEQPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereSEX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereSSCBOARDNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereSSCCTYPE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereSSCDATA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereSSCGPA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereSSCGROUP($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereSSCLTRGRD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereSSCNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereSSCPASSYEAR($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereSSCREGNO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereSSCRESULT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereSSCROLLNO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereSSCSESSION($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereSelfie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereSelfieStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereSuspectPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereTOTALGPA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereTOTFULL($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereTOTFULLORI($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereTOTOBT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereTOTOBTORI($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereTrackingNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereWQPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hsc whereWQSalaryId($value)
 */
	class Hsc extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\InfoReview
 *
 * @property int $id
 * @property string|null $NAME
 * @property string|null $FNAME
 * @property string|null $MNAME
 * @property string|null $HSC_REGNO
 * @property string|null $HSC_SESSION
 * @property string|null $HSC_ROLL_NO
 * @property int|null $HSC_PASS_YEAR
 * @property string|null $HSC_BOARD_NAME
 * @property string|null $HSC_GPA
 * @property string|null $HSC_LTRGRD
 * @property string|null $HSC_GROUP
 * @property string|null $SEX
 * @property string|null $SSC_REGNO
 * @property string|null $SSC_ROLL_NO
 * @property int|null $SSC_PASS_YEAR
 * @property string|null $SSC_BOARD_NAME
 * @property string|null $HSC_RESULT
 * @property int|null $SSC_DATA
 * @property string|null $SSC_NAME
 * @property string|null $SSC_GROUP
 * @property string|null $SSC_GPA
 * @property string|null $SSC_RESULT
 * @property string|null $RU_HSC_GROUP
 * @property float|null $TOTAL_GPA
 * @property string|null $MATHEMATICS
 * @property string|null $A
 * @property string|null $B
 * @property string|null $C
 * @property string|null $D
 * @property string|null $E
 * @property string|null $F
 * @property string|null $G
 * @property string|null $H
 * @property string|null $I
 * @property string|null $mobile_no
 * @property string|null $photo
 * @property string|null $photo_ssc
 * @property string|null $photo_hsc
 * @property string|null $tracking_no
 * @property string|null $dob
 * @property string|null $status
 * @property string|null $checked_by
 * @property string|null $message
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $complain_type_id
 * @property-read \App\Models\ComplainType|null $complainType
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview query()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview status($param)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereCheckedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereComplainTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereF($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereFNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereG($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereHSCBOARDNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereHSCGPA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereHSCGROUP($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereHSCLTRGRD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereHSCPASSYEAR($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereHSCREGNO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereHSCRESULT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereHSCROLLNO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereHSCSESSION($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereI($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereMATHEMATICS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereMNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereMobileNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview wherePhotoHsc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview wherePhotoSsc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereRUHSCGROUP($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereSEX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereSSCBOARDNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereSSCDATA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereSSCGPA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereSSCGROUP($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereSSCNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereSSCPASSYEAR($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereSSCREGNO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereSSCRESULT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereSSCROLLNO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereTOTALGPA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereTrackingNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoReview whereUpdatedAt($value)
 */
	class InfoReview extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MobileChange
 *
 * @property int $id
 * @property int $applicant_id
 * @property string $doc1
 * @property string|null $doc2
 * @property string|null $old_mobile_no
 * @property string $new_mobile_no
 * @property string $reason
 * @property string|null $meeting_url
 * @property string|null $meeting_time
 * @property string|null $comment
 * @property string|null $status
 * @property int|null $checked_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Hsc|null $applicant
 * @property-read \App\Models\User|null $user_checked
 * @method static \Illuminate\Database\Eloquent\Builder|MobileChange newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MobileChange newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MobileChange query()
 * @method static \Illuminate\Database\Eloquent\Builder|MobileChange status($param)
 * @method static \Illuminate\Database\Eloquent\Builder|MobileChange whereApplicantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MobileChange whereCheckedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MobileChange whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MobileChange whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MobileChange whereDoc1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MobileChange whereDoc2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MobileChange whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MobileChange whereMeetingTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MobileChange whereMeetingUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MobileChange whereNewMobileNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MobileChange whereOldMobileNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MobileChange whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MobileChange whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MobileChange whereUpdatedAt($value)
 */
	class MobileChange extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OthStudent
 *
 * @property int $id
 * @property string|null $NAME
 * @property string|null $FNAME
 * @property string|null $MNAME
 * @property string|null $HSC_REGNO
 * @property string|null $HSC_SESSION
 * @property string|null $HSC_ROLL_NO
 * @property int|null $HSC_PASS_YEAR
 * @property string|null $HSC_BOARD_NAME
 * @property string|null $HSC_GPA
 * @property string|null $HSC_LTRGRD
 * @property string|null $HSC_GROUP
 * @property string|null $HSC_RESULT
 * @property string|null $SEX
 * @property string|null $SSC_ROLL_NO
 * @property int|null $SSC_PASS_YEAR
 * @property string|null $SSC_BOARD_NAME
 * @property int|null $SSC_DATA
 * @property string|null $SSC_NAME
 * @property string|null $SSC_GROUP
 * @property string|null $SSC_GPA
 * @property string|null $SSC_RESULT
 * @property string|null $RU_HSC_GROUP
 * @property float|null $TOTAL_GPA
 * @property string|null $MATHEMATICS
 * @property string|null $A
 * @property string|null $B
 * @property string|null $C
 * @property string|null $D
 * @property string|null $E
 * @property string|null $mobile_no
 * @property string|null $photo
 * @property string|null $photo_ssc
 * @property string|null $photo_hsc
 * @property string|null $tracking_no
 * @property string|null $dob
 * @property string|null $status
 * @property string|null $comment
 * @property string|null $oth_board
 * @property string|null $checked_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent query()
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent status($param)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereCheckedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereFNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereHSCBOARDNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereHSCGPA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereHSCGROUP($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereHSCLTRGRD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereHSCPASSYEAR($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereHSCREGNO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereHSCRESULT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereHSCROLLNO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereHSCSESSION($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereMATHEMATICS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereMNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereMobileNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereOthBoard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent wherePhotoHsc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent wherePhotoSsc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereRUHSCGROUP($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereSEX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereSSCBOARDNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereSSCDATA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereSSCGPA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereSSCGROUP($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereSSCNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereSSCPASSYEAR($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereSSCRESULT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereSSCROLLNO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereTOTALGPA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereTrackingNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OthStudent whereUpdatedAt($value)
 */
	class OthStudent extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PageContent
 *
 * @property int $id
 * @property string $name
 * @property string $content
 * @property string|null $content_draft
 * @property int|null $draft_published
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent query()
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent whereContentDraft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent whereDraftPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent whereUpdatedAt($value)
 */
	class PageContent extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PaymentLog
 *
 * @property int $id
 * @property int $bill_id
 * @property string $payment_id
 * @property string $payment_method
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLog whereBillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLog wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLog wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentLog whereUpdatedAt($value)
 */
	class PaymentLog extends \Eloquent {}
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PhotoCheck
 *
 * @property int $id
 * @property string $hsc_id
 * @property string $status
 * @property string $checked_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoCheck newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoCheck newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoCheck query()
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoCheck status($param)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoCheck whereCheckedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoCheck whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoCheck whereHscId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoCheck whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoCheck whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoCheck whereUpdatedAt($value)
 */
	class PhotoCheck extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PhotoReview
 *
 * @property int $id
 * @property int $applicant_id
 * @property int $bill_id
 * @property string $bill_status
 * @property string $photo_reg
 * @property string $new_photo
 * @property string $previous_photo
 * @property string|null $status
 * @property string|null $checked_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Hsc|null $applicant
 * @property-read \App\Models\Bill|null $bill
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoReview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoReview newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoReview query()
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoReview status($param)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoReview whereApplicantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoReview whereBillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoReview whereBillStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoReview whereCheckedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoReview whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoReview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoReview whereNewPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoReview wherePhotoReg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoReview wherePreviousPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoReview whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoReview whereUpdatedAt($value)
 */
	class PhotoReview extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Quota
 *
 * @property int $id
 * @property string $code
 * @property string $quota
 * @method static \Illuminate\Database\Eloquent\Builder|Quota newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Quota newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Quota query()
 * @method static \Illuminate\Database\Eloquent\Builder|Quota whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quota whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quota whereQuota($value)
 */
	class Quota extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RegistrationFee
 *
 * @property int $id
 * @property string $unit_name
 * @property float $amount
 * @method static \Illuminate\Database\Eloquent\Builder|RegistrationFee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RegistrationFee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RegistrationFee query()
 * @method static \Illuminate\Database\Eloquent\Builder|RegistrationFee unit($param)
 * @method static \Illuminate\Database\Eloquent\Builder|RegistrationFee whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegistrationFee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegistrationFee whereUnitName($value)
 */
	class RegistrationFee extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Result
 *
 * @property int $id
 * @property string|null $unit
 * @property int|null $applicant_id
 * @property string $exam_roll
 * @property string|null $group_number
 * @property string $group_name
 * @property string $name
 * @property string $fname
 * @property string $quota
 * @property string|null $mcq_score
 * @property string|null $saq_score
 * @property string|null $total_score
 * @property string $test_score
 * @property string|null $position
 * @property string $status
 * @property string $interview_date
 * @property string $subject_choice
 * @method static \Illuminate\Database\Eloquent\Builder|Result newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Result newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Result query()
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereApplicantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereExamRoll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereFname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereGroupName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereGroupNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereInterviewDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereMcqScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereQuota($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereSaqScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereSubjectChoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereTestScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereTotalScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereUnit($value)
 */
	class Result extends \Eloquent {}
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SmsQueue
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SmsQueue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SmsQueue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SmsQueue query()
 */
	class SmsQueue extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Ssc
 *
 * @property int $id
 * @property string|null $NAME
 * @property string|null $FNAME
 * @property string|null $MNAME
 * @property string|null $SSC_REGNO
 * @property string|null $SSC_SESSION
 * @property string|null $SSC_BOARD_NAME
 * @property string|null $SSC_PASS_YEAR
 * @property string|null $SSC_ROLL_NO
 * @property string|null $BOARD_CODE
 * @property string|null $SSC_GROUP
 * @property string|null $SSC_GPA
 * @property string|null $SSC_LTRGRD
 * @property string|null $DOB
 * @property string|null $SEX
 * @property string|null $RESULT
 * @property string|null $C_TYPE
 * @method static \Illuminate\Database\Eloquent\Builder|Ssc newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ssc newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ssc query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ssc whereBOARDCODE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ssc whereCTYPE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ssc whereDOB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ssc whereFNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ssc whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ssc whereMNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ssc whereNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ssc whereRESULT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ssc whereSEX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ssc whereSSCBOARDNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ssc whereSSCGPA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ssc whereSSCGROUP($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ssc whereSSCLTRGRD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ssc whereSSCPASSYEAR($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ssc whereSSCREGNO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ssc whereSSCROLLNO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ssc whereSSCSESSION($value)
 */
	class Ssc extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\StudentCategory
 *
 * @property int $id
 * @property string $category_name
 * @property string $dept_codes
 * @property string $conditions
 * @property string $ratio
 * @property string|null $description
 * @method static \Illuminate\Database\Eloquent\Builder|StudentCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentCategory whereCategoryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentCategory whereConditions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentCategory whereDeptCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentCategory whereRatio($value)
 */
	class StudentCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\StudentChoice
 *
 * @property int $id
 * @property int $application_id
 * @property int $subjectoption_id
 * @property string $dept_code
 * @property int $priority
 * @property string|null $selection_status
 * @property int|null $opt_out
 * @property string|null $opted_out_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $applicant_id
 * @property string|null $unit
 * @property string|null $admission_roll
 * @property-read \App\Models\Application|null $application
 * @property-read \App\Models\Department|null $department
 * @property-read \App\Models\SubjectOption|null $subjectOption
 * @method static \Illuminate\Database\Eloquent\Builder|StudentChoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentChoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentChoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentChoice whereAdmissionRoll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentChoice whereApplicantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentChoice whereApplicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentChoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentChoice whereDeptCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentChoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentChoice whereOptOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentChoice whereOptedOutAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentChoice wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentChoice whereSelectionStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentChoice whereSubjectoptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentChoice whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentChoice whereUpdatedAt($value)
 */
	class StudentChoice extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\StudentDetails
 *
 * @property int $id
 * @property int $applicant_id
 * @property string|null $guardian_name
 * @property string|null $guardian_relation
 * @property string $dob
 * @property string $birth_place
 * @property string $gender
 * @property string $religion
 * @property string|null $blood_group
 * @property string $height
 * @property string|null $birth_reg_no
 * @property string|null $nid_no
 * @property string|null $passport_no
 * @property string $nationality
 * @property string|null $email
 * @property string $permanent_address
 * @property string $permanent_ps_upazila
 * @property string $permanent_post_office
 * @property string $permanent_district
 * @property string $current_address
 * @property string $current_ps_upazila
 * @property string $current_post_office
 * @property string $current_district
 * @property string $emergency_name
 * @property string|null $emergency_relation
 * @property string $emergency_contact
 * @property string $emergency_address
 * @property string $ssc_institute
 * @property string $hsc_institute
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails whereApplicantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails whereBirthPlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails whereBirthRegNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails whereBloodGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails whereCurrentAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails whereCurrentDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails whereCurrentPostOffice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails whereCurrentPsUpazila($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails whereEmergencyAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails whereEmergencyContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails whereEmergencyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails whereEmergencyRelation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails whereGuardianName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails whereGuardianRelation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails whereHscInstitute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails whereNationality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails whereNidNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails wherePassportNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails wherePermanentAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails wherePermanentDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails wherePermanentPostOffice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails wherePermanentPsUpazila($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails whereReligion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails whereSscInstitute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentDetails whereUpdatedAt($value)
 */
	class StudentDetails extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SubjectOption
 *
 * @property int $id
 * @property string|null $unit
 * @property string|null $exam_group_no
 * @property string|null $exam_group
 * @property string|null $applicant_id
 * @property string|null $application_id
 * @property string|null $admission_roll
 * @property string|null $name
 * @property string|null $exam_score
 * @property string|null $position
 * @property string|null $sub_allow
 * @property int $sub_completed
 * @property string|null $subjects
 * @property string|null $admission_allow
 * @property string|null $admission_subject
 * @property string|null $admission_completed
 * @property int|null $bill_id
 * @property string $office_status
 * @property string|null $reject_reason
 * @property string|null $comment
 * @property string $bill_status
 * @property string|null $migration_stop
 * @property string|null $migration_stopped_at
 * @property string|null $alloc_dept_code
 * @property int|null $student_category_id
 * @property int|null $allow_reg
 * @property int|null $ffq_position
 * @property int|null $pdq_position
 * @property int|null $seq_position
 * @property int|null $wq_position
 * @property string|null $alloc_dept_code_quota
 * @property int|null $quota_selected
 * @property int|null $list_number
 * @property int|null $allow_regc
 * @property string|null $quota
 * @property string|null $gender
 * @property int|null $hall_code
 * @property int|null $student_details_id
 * @property int|null $class_roll
 * @property string|null $admission_sub_eee
 * @property string|null $migration_stop_15
 * @property int|null $student_id
 * @property int|null $new_ad
 * @property string|null $sp_choice
 * @property string|null $pop_sci
 * @property string|null $alt_mobile_no
 * @property int|null $is_bksp
 * @property string|null $bksp_photo
 * @property string|null $Result
 * @property string|null $Remarks
 * @property string $admission_end
 * @property string|null $last_admission_subject
 * @property string|null $admission_subject_selection_status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\Department|null $admissionDepartment
 * @property-read \App\Models\Application|null $application
 * @property-read \App\Models\Bill|null $bill
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StudentChoice> $choices
 * @property-read int|null $choices_count
 * @property-read \App\Models\Hall|null $hall
 * @property-read \App\Models\Hsc|null $student
 * @property-read \App\Models\StudentCategory|null $studentCategory
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereAdmissionAllow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereAdmissionCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereAdmissionEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereAdmissionRoll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereAdmissionSubEee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereAdmissionSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereAdmissionSubjectSelectionStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereAllocDeptCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereAllocDeptCodeQuota($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereAllowReg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereAllowRegc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereAltMobileNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereApplicantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereApplicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereBillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereBillStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereBkspPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereClassRoll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereExamGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereExamGroupNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereExamScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereFfqPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereHallCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereIsBksp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereLastAdmissionSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereListNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereMigrationStop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereMigrationStop15($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereMigrationStoppedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereNewAd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereOfficeStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption wherePdqPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption wherePopSci($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereQuota($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereQuotaSelected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereRejectReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereSeqPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereSpChoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereStudentCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereStudentDetailsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereSubAllow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereSubCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereSubjects($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectOption whereWqPosition($value)
 */
	class SubjectOption extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Unit
 *
 * @property int $id
 * @property string $unit_name
 * @property string $description
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Department> $departments
 * @property-read int|null $departments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Faculty> $faculties
 * @property-read int|null $faculties_count
 * @method static \Illuminate\Database\Eloquent\Builder|Unit name($param)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit query()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereUnitName($value)
 */
	class Unit extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $username
 * @property string $fullname
 * @property string $office
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \App\Models\Unit|null $unit
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User orWherePermissionIs($permission = '')
 * @method static \Illuminate\Database\Eloquent\Builder|User orWhereRoleIs($role = '', $team = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDoesntHavePermission()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDoesntHaveRole()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFullname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOffice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePermissionIs($permission = '', $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleIs($role = '', $team = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Year
 *
 * @property int $id
 * @property string $exam
 * @property string $year
 * @property string $display_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Year exam($param)
 * @method static \Illuminate\Database\Eloquent\Builder|Year newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Year newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Year query()
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereExam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereYear($value)
 */
	class Year extends \Eloquent {}
}

