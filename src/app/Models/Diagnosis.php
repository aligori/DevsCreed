<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Diagnosis
 *
 * @property int $diagnosis_id
 * @property string $name
 *
 * @property Collection|Patient[] $patients
 *
 * @package App\Models
 */
class Diagnosis extends Model
{
	protected $table = 'diagnosis';
	protected $primaryKey = 'diagnosis_id';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	public function patients()
	{
		return $this->belongsToMany(Patient::class, 'patient diagnosis', 'diagnosis_id')
					->withPivot('details', 'isCurrent', 'patient_diagnosis_id');
	}
}
