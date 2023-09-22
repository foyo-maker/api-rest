<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

     public function up()
     {
         Schema::create('recipes', function (Blueprint $table) {
             $table->id();
             $table->string('recipe_name');
             $table->string('recipe_image')->nullable();
             $table->string('recipe_description')->nullable();
             $table->integer('recipe_servings');
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
        Schema::dropIfExists('recipes');
    }
}
