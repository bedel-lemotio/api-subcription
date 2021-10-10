<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 *
 * @property int $id
 * @property string|null $api_token
 * @property string|null $statut
 * @property int|null $active
 * @property int|null $is_online
 * @property string|null $picture
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string $email
 * @property string|null $password
 * @property string|null $remenber_token
 * @property Carbon|null $created_at
 * @property int|null $address_verified
 * @property int|null $identity_verified
 * @property string|null $codeParrainage
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $subscriptions_id
 * @property int|null $countries_id
 * @property int|null $towns_id
 * @property int|null $zones_id
 *
 * @property Country|null $country
 * @property Subscription|null $subscription
 * @property Town|null $town
 * @property Zone|null $zone
 *
 * @package App\Models
 */
class User extends Authenticatable  implements JWTSubject
{
    use HasFactory, Notifiable;
    use SoftDeletes;
    protected $table = 'users';

	protected $casts = [
		'active' => 'int',
		'is_online' => 'int',
		'address_verified' => 'int',
		'identity_verified' => 'int',
		'subscriptions_id' => 'int',
		'countries_id' => 'int',
		'towns_id' => 'int',
		'zones_id' => 'int'
	];

	protected $hidden = [
		'api_token',
		'password',
		'remenber_token'
	];

	protected $fillable = [
		'api_token',
		'statut',
		'active',
		'is_online',
		'picture',
		'first_name',
		'last_name',
		'email',
		'password',
		'remenber_token',
		'address_verified',
		'identity_verified',
		'codeParrainage',
		'subscriptions_id',
		'countries_id',
		'towns_id',
		'zones_id'
	];

	public function country()
	{
		return $this->belongsTo(Country::class, 'countries_id');
	}

	public function subscription()
	{
		return $this->belongsTo(Subscription::class, 'subscriptions_id');
	}

	public function town()
	{
		return $this->belongsTo(Town::class, 'towns_id');
	}

	public function zone()
	{
		return $this->belongsTo(Zone::class, 'zones_id');
	}

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
