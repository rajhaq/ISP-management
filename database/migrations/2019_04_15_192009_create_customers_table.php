<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('admin_id');
            $table->string('customer_email')->nullable();
            $table->string('customer_name');
            $table->string('customer_contact')->nullable();;
            $table->string('customer_instagram')->nullable();;
            $table->string('customer_facebook')->nullable();;
            $table->string('customer_snapchat')->nullable();;
            $table->text('customer_address');
            $table->string('customer_type')->default('regular');
            $table->boolean('customer_map')->default(false);
            $table->string('customer_location')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
