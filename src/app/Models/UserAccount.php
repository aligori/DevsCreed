<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserAccount
 * 
 * @property string $uuid
 * @property string $password
 * @property string $username
 * @property int $role_id
 * 
 * @property Role $role
 *
 * @package App\Models
 */
class UserAccount extends Model
{
	protected $table = 'user account';
	protected $primaryKey = 'uuid';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'role_id' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'password',
		'username',
		'role_id'
	];

	public function role()
	{
		return $this->belongsTo(Role::class);
	}
}
