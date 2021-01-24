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
			$table->integer('twitter_id');//ツイッター側のID
			$table->string('access_token');//APIを使用するためのアクセストークン
			$table->string('access_token_secret');//APIを使用する為のアクセストークンシークレット
			$table->string('avatar');//ツイッター側の画像を保存
			$table->string('profile');//ツイッターのプロフィールを保存

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
