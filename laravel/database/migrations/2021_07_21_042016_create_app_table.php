<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // items テーブルを作成
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->integer('price');
            $table->string('src', 100);
            $table->string('description', 1000);
            $table->timestamps();
        });

        // cart_items テーブルを作成
        Schema::create('cart_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('item_id');
            $table->integer('quantity');
            $table->timestamps();
        });

        // sold_items テーブルを作成
        Schema::create('sold_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('item_id');
            $table->integer('quantity');
            $table->timestamps();
        });

        // likes テーブルを作成
        Schema::create('likes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->timestamps();
        });

        // users テーブルにカラムを追加
        Schema::table('users', function (Blueprint $table) {
            $table->string('postalcode','10')->nullable();
            $table->string('region', '10')->nullable();
            $table->string('addressline1')->nullable();
            $table->string('addressline2')->nullable();
            $table->string('phonenumber', '10')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 各テーブルを削除
        Schema::dropIfExists('items');
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('sold_items');
        Schema::dropIfExists('likes');
        
        // users テーブルからカラムを削除
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('postalcode', 'region', 'addressline1', 'addressline2', 'phonenumber');
        });
    }
}
