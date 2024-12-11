<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->bigIncrements('id');
             $table->string('group_name',20);
             $table->string('owner_first_name');
             $table->string('owner_last_name');
              $table->string('email',40);
             $table->string('owner_phone_number',15);
             $table->string('owner_address',200);
             $table->string('owner_city',30);
             $table->string('zip',10);
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
        Schema::dropIfExists('groups');
    }
}
