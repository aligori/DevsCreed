<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Patient
 * 
 * @property int $patient_id
 * @property string $full name
 * @property string $email
 * @property string|null $address
 * @property string|null $phone
 * @property Carbon|null $birthday
 * @property string|null $uuid
 * 
 * @property Collection|Appointment[] $appointments
 * @property Collection|HealthRecord[] $health_records
 * @property Collection|Diagnosi[] $diagnosis
 *
 * @package App\Models
 */
class Patient extends Model
{
	protected $table = 'patient';
	protected $primaryKey = 'patient_id';
	public $timestamps = false;

	protected $dates = [
		'birthday'
	];

	protected $fillable = [
		'full name',
		'email',
		'address',
		'phone',
		'birthday',
		'uuid'
	];

	public function appointments()
	{
		return $this->hasMany(Appointment::class, 'booked_by');
	}

	public function health_records()
	{
		return $this->hasMany(HealthRecord::class, 'for_patient');
	}

	public function diagnosis()
	{
		return $this->belongsToMany(Diagnosi::class, 'patient diagnosis', 'patient_id', 'diagnosis_id')
					->withPivot('details', 'isCurrent', 'patient_diagnosis_id');
	}
}
