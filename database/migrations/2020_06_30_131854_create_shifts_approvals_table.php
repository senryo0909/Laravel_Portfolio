<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShiftsApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts_approvals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('managements_id');
            $table->unsignedBigInteger('status_descriptions_id');
            $table->timestamps();

            $table->foreign('managements_id')
            ->references('id')
            ->on('managements')
            ->onDelete('cascade');
            $table->foreign('status_descriptions_id')
            ->references('id')
            ->on('status_descriptions')
            ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shifts_approvals');
    }
}
