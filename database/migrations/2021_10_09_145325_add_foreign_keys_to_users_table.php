<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign(['countries_id'], 'fk_users_countries1')->references(['id'])->on('countries')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['subscriptions_id'], 'fk_users_subscriptions1')->references(['id'])->on('subscriptions')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['towns_id'], 'fk_users_towns1')->references(['id'])->on('towns')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['zones_id'], 'fk_users_zones1')->references(['id'])->on('zones')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('fk_users_countries1');
            $table->dropForeign('fk_users_subscriptions1');
            $table->dropForeign('fk_users_towns1');
            $table->dropForeign('fk_users_zones1');
        });
    }
}
