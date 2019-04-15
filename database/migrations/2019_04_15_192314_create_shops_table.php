<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('shop_email')->nullable();
            $table->string('shop_name');
            $table->string('shop_contact');
            $table->string('shop_instagram')->nullable();
            $table->string('shop_facebook')->nullable();
            $table->string('shop_snapchat')->nullable();
            $table->text('shop_address');
            $table->boolean('shop_map')->default(false);
            $table->string('shop_location')->nullable();
            $table->string('shop_type')->default('regular');
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
}
