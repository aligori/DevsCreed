<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HealthRecord
 * 
 * @property int $record_id
 * @property string $prescription
 * @property string|null $description
 * @property Carbon $date
 * @property int $written_by
 * @property int $for_patient
 * @property int $patient_diagnosis_id
 * 
 * @property Staff $staff
 * @property Patient $patient
 *
 * @package App\Models
 */
class HealthRecord extends Model
{
	protected $table = 'health records';
	protected $primaryKey = 'record_id';
	public $timestamps = false;

	protected $casts = [
		'written_by' => 'int',
		'for_patient' => 'int',
		'patient_diagnosis_id' => 'int'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'prescription',
		'description',
		'date',
		'written_by',
		'for_patient',
		'patient_diagnosis_id'
	];

	public function staff()
	{
		return $this->belongsTo(Staff::class, 'written_by');
	}

	public function patient()
	{
		return $this->belongsTo(Patient::class, 'for_patient');
	}
}
