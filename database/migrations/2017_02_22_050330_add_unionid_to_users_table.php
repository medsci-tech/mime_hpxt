<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUnionidToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('openid',60)->comment('微信openid');
            $table->string('unionid',60)->comment('微信unionid');
            $table->string('nickname',60)->comment('微信昵称');
            $table->string('headimgurl',250)->comment('微信图像');
            $table->tinyInteger('sex')->default(0)->comment('性别');
            //
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
            $table->dropColumn(['openid', 'unionid', 'nickname', 'headimgurl', 'sex']);
        });
    }
}
