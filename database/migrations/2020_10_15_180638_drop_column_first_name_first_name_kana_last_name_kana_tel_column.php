<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnFirstNameFirstNameKanaLastNameKanaTelColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('first_name');
            $table->dropColumn('first_name_kana');
            $table->dropColumn('last_name_kana');
            $table->dropColumn('tel');
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
            $table->boolean('first_name')->default(false);
            $table->boolean('first_name_kana')->default(false);
            $table->boolean('last_name_kana')->default(false);
            $table->boolean('tel')->default(false);
        });
    }
}
