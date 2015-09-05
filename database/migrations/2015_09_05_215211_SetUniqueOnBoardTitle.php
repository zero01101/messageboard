<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetUniqueOnBoardTitle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messageboards', function (Blueprint $table) {
            $table->string('title', 50)->change();
            $table->unique('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messageboards', function (Blueprint $table) {
            $table->dropUnique('messageboards_title_unique');
        });
    }
}
