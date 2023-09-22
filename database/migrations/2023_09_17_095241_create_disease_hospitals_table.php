<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiseaseHospitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disease_hospitals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('disease_id');
            $table->unsignedBigInteger('hospital_id');
            $table->timestamps();
            
            $table->foreign('disease_id')
                ->references('id')
                ->on('diseases')
                ->onDelete('cascade');
            $table->foreign('hospital_id')
                ->references('id')
                ->on('hospitals')
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
        Schema::dropIfExists('disease_hospitals');
    }
}
