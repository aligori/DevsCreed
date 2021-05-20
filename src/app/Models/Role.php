<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * 
 * @property int $role_id
 * @property string $name
 * 
 * @property Collection|UserAccount[] $user_accounts
 *
 * @package App\Models
 */
class Role extends Model
{
	protected $table = 'role';
	protected $primaryKey = 'role_id';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	public function user_accounts()
	{
		return $this->hasMany(UserAccount::class);
	}
}
