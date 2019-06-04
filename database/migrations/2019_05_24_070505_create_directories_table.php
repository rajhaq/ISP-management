<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDirectoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('admin_id');
            $table->string('name');
            $table->string('position');
            $table->string('account_permission')->nullable();
            $table->string('gender');
            $table->string('nickname')->nullable();
            $table->string('routine')->nullable();
            $table->text('notes')->nullable();
            $table->text('call_eligible')->nullable();
            $table->text('emergency')->nullable();
            $table->text('oncall')->nullable();
            $table->text('general')->nullable();
            $table->text('message_handling')->nullable();

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
        Schema::dropIfExists('directories');
    }
}
