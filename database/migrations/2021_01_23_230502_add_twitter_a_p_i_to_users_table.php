<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTwitterAPIToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		//TwitterAPI用のカラム追加
        Schema::table('users', function (Blueprint $table) {
            //
			$table->integer('twitter_id')->nullable();//ツイッター側のID
			$table->string('access_token')->nullable();//APIを使用するためのアクセストークン
			$table->string('access_token_secret')->nullable();//APIを使用する為のアクセストークンシークレット
			$table->string('avatar')->nullable();//ツイッター側の画像を保存
			$table->string('profile')->nullable();//ツイッターのプロフィールを保存

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
            //
        });
    }
}
