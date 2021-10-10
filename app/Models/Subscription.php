<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Subscription
 * 
 * @property int $id
 * @property string|null $description
 * @property int|null $subscription_types_id
 * @property string|null $subscription_zone
 * @property string|null $subcription_price
 * 
 * @property SubscriptionType|null $subscription_type
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Subscription extends Model
{
	protected $table = 'subscriptions';
	public $timestamps = false;

	protected $casts = [
		'subscription_types_id' => 'int'
	];

	protected $fillable = [
		'description',
		'subscription_types_id',
		'subscription_zone',
		'subcription_price'
	];

	public function subscription_type()
	{
		return $this->belongsTo(SubscriptionType::class, 'subscription_types_id');
	}

	public function users()
	{
		return $this->hasMany(User::class, 'subscriptions_id');
	}
}
