<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Staff
 * 
 * @property int $employee_id
 * @property string $full name
 * @property string $email
 * @property int $phone
 * @property boolean|null $photo
 * @property Carbon $birthday
 * @property int $salary
 * @property bool $status
 * @property string|null $uuid
 * 
 * @property Collection|Appointment[] $appointments
 * @property Collection|HealthRecord[] $health_records
 *
 * @package App\Models
 */
class Staff extends Model
{
	protected $table = 'staff';
	protected $primaryKey = 'employee_id';
	public $timestamps = false;

	protected $casts = [
		'phone' => 'int',
		'photo' => 'boolean',
		'salary' => 'int',
		'status' => 'bool'
	];

	protected $dates = [
		'birthday'
	];

	protected $fillable = [
		'full name',
		'email',
		'phone',
		'photo',
		'birthday',
		'salary',
		'status',
		'uuid'
	];

	public function appointments()
	{
		return $this->hasMany(Appointment::class, 'assigned_to');
	}

	public function health_records()
	{
		return $this->hasMany(HealthRecord::class, 'written_by');
	}
}
