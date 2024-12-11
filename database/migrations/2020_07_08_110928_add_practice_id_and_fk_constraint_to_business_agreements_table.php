<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPracticeIdAndFkConstraintToBusinessAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_agreements', function (Blueprint $table) {
            $table->integer('practice_id')->after('id')->nullable();

            $table->foreign('practice_id')->references('id')->on('practices')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_agreements', function (Blueprint $table) {
            $table->dropForeign('business_agreements_practice_id_foreign');
            $table->dropColumn('practice_id');
        });
    }
}
