<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Zone
 * 
 * @property int $id
 * @property string|null $libelle
 * 
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Zone extends Model
{
	protected $table = 'zones';
	public $timestamps = false;

	protected $fillable = [
		'libelle'
	];

	public function users()
	{
		return $this->hasMany(User::class, 'zones_id');
	}
}
