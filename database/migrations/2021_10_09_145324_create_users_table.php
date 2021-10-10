<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('api_token')->nullable();
            $table->string('statut')->nullable();
            $table->tinyInteger('active')->nullable()->default(0);
            $table->tinyInteger('is_online')->nullable()->default(0);
            $table->string('picture')->nullable();
            $table->string('first_name', 105)->nullable();
            $table->string('last_name', 105)->nullable();
            $table->string('principal_phone_number', 45)->nullable();
            $table->string('email')->unique('email_UNIQUE');
            $table->string('password', 115)->nullable();
            $table->string('workplace')->nullable();
            $table->string('remenber_token')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->tinyInteger('address_verified')->nullable();
            $table->tinyInteger('identity_verified')->nullable();
            $table->string('codeParrainage', 45)->nullable();
            $table->timestamp('updated_at')->nullable()->useCurrent();
            $table->softDeletes();
            $table->integer('subscriptions_id')->nullable()->index('fk_users_subscriptions1_idx');
            $table->integer('countries_id')->nullable()->index('fk_users_countries1_idx');
            $table->integer('towns_id')->nullable()->index('fk_users_towns1_idx');
            $table->integer('zones_id')->nullable()->index('fk_users_zones1_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
