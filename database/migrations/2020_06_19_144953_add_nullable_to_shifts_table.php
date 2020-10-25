<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullableToShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('shifts', function (Blueprint $table) {
            
            $table->time('start_time')->nullable()->change();
            $table->time('end_time')->nullable()->change();
            $table->time('rest_time')->nullable()->change();
            $table->time('total')->nullable()->change();
            $table->text('comments')->nullable()->change();
            $table->unsignedBigInteger('monthly_id')->nullable();
            $table->unsignedBigInteger('work_type_id')->nullable();

            
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('shifts', function (Blueprint $table) {
            $table->time('start_time')->nullable(false)->change();
            $table->time('end_time')->nullable(false)->change();
            $table->time('rest_time')->nullable(false)->change();
            $table->time('total')->nullable(false)->change();
            $table->text('comments')->nullable(false)->change();
            $table->unsignedBigInteger('work_type_id')->nullable(false)->change();
            $table->unsignedBigInteger('monthly_id')->nullable(false)->change();

        });
        Schema::enableForeignKeyConstraints();
    }
}
