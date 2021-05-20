<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Appointment
 * 
 * @property int $a_id
 * @property bool $status
 * @property Carbon $time
 * @property int|null $assigned_to
 * @property int|null $booked_by
 * 
 * @property Staff|null $staff
 * @property Patient|null $patient
 *
 * @package App\Models
 */
class Appointment extends Model
{
	protected $table = 'appointment';
	protected $primaryKey = 'a_id';
	public $timestamps = false;

	protected $casts = [
		'status' => 'bool',
		'assigned_to' => 'int',
		'booked_by' => 'int'
	];

	protected $dates = [
		'time'
	];

	protected $fillable = [
		'status',
		'time',
		'assigned_to',
		'booked_by'
	];

	public function staff()
	{
		return $this->belongsTo(Staff::class, 'assigned_to');
	}

	public function patient()
	{
		return $this->belongsTo(Patient::class, 'booked_by');
	}
}
