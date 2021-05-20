<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PatientDiagnosi
 * 
 * @property string $details
 * @property bool $isCurrent
 * @property int $patient_id
 * @property int $patient_diagnosis_id
 * @property int $diagnosis_id
 * 
 * @property Patient $patient
 * @property Diagnosi $diagnosi
 *
 * @package App\Models
 */
class PatientDiagnosi extends Model
{
	protected $table = 'patient diagnosis';
	protected $primaryKey = 'patient_diagnosis_id';
	public $timestamps = false;

	protected $casts = [
		'isCurrent' => 'bool',
		'patient_id' => 'int',
		'diagnosis_id' => 'int'
	];

	protected $fillable = [
		'details',
		'isCurrent',
		'patient_id',
		'diagnosis_id'
	];

	public function patient()
	{
		return $this->belongsTo(Patient::class);
	}

	public function diagnosi()
	{
		return $this->belongsTo(Diagnosi::class, 'diagnosis_id');
	}
}
