<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SubscriptionType
 * 
 * @property int $id
 * @property string|null $description
 * 
 * @property Collection|Subscription[] $subscriptions
 *
 * @package App\Models
 */
class SubscriptionType extends Model
{
	protected $table = 'subscription_types';
	public $timestamps = false;

	protected $fillable = [
		'description'
	];

	public function subscriptions()
	{
		return $this->hasMany(Subscription::class, 'subscription_types_id');
	}
}
