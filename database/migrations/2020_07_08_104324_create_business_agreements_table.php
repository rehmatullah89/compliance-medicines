<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_agreements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('practice_id');
            $table->foreign('practice_id')->refrences('id')->on('practices')->onDelete('cascade');
            $table->tinyInteger('accepted_terms')->nullable();
            $table->timestamp('accepted_terms_dt');
            $table->string('accepted_terms_user', 30);
            $table->string('accepted_terms_role', 30);
            $table->integer('accepted_terms_user_id');
            $table->string('accepted_terms_signature', 300);


            $table->tinyInteger('rp_accepted_terms')->nullable();
            $table->timestamp('rp_accepted_terms_dt');
            $table->string('rp_accepted_terms_user', 30);
            $table->string('rp_accepted_terms_role', 30);
            $table->integer('rp_accepted_terms_user_id');
            $table->string('rp_accepted_terms_signature', 300);



            $table->tinyInteger('cr_accepted_terms')->nullable();

            $table->timestamp('cr_accepted_terms_dt');
            $table->string('cr_accepted_terms_user', 30);
            $table->string('cr_accepted_terms_role', 30);
            $table->integer('cr_accepted_terms_user_id');
            $table->string('cr_accepted_terms_signature', 300);


            $table->tinyInteger('crb_accepted_terms')->nullable();

        $table->timestamp('crb_accepted_terms_dt');
        $table->string('crb_accepted_terms_user', 30);
        $table->string('crb_accepted_terms_role', 30);
        $table->integer('crb_accepted_terms_user_id');
        $table->string('crb_accepted_terms_signature', 300);
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
        Schema::dropIfExists('business_agreements');
    }
}
