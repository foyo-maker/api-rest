<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalsTable extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */

     public function up()
     {
         Schema::create('hospitals', function (Blueprint $table) {
             $table->id();
             $table->string('hospital_name');
             $table->string('hospital_contact')->nullable();
             $table->string('hospital_address')->nullable();
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
        Schema::dropIfExists('hospitals');
    }
}
