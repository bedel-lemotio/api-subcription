<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Country
 * 
 * @property int $id
 * @property string|null $name
 * @property string|null $phoneCode
 * @property string|null $flag_image
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Country extends Model
{
	use SoftDeletes;
	protected $table = 'countries';

	protected $fillable = [
		'name',
		'phoneCode',
		'flag_image',
		'description'
	];

	public function users()
	{
		return $this->hasMany(User::class, 'countries_id');
	}
}
