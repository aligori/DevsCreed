<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Transaction
 * 
 * @property Carbon $date
 * @property string $client
 * @property int $total
 *
 * @package App\Models
 */
class Transaction extends Model
{
	protected $table = 'transaction';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'total' => 'int'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'date',
		'client',
		'total'
	];
}
