<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGroupIdAndForeignKeyToPracticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('practices', function (Blueprint $table) {
           $table->unsignedBigInteger('group_id')->after('id')->nullable();

            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');

            $table->index('group_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('practices', function (Blueprint $table) {
             $table->dropForeign('practices_group_id_foreign');
            $table->dropColumn('group_id');
        });
    }
}
