<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPlanListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_plan_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_plan_id');
            $table->unsignedBigInteger('workout_id');
            $table->string('name');
            $table->string('gifimage')->nullable();
            // Add other columns as needed

            $table->timestamps();
        });

        Schema::table('user_plan_lists', function (Blueprint $table) {
            $table->foreign('user_plan_id')->references('id')->on('user_plans')->onDelete('cascade');
            $table->foreign('workout_id')->references('id')->on('workouts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_plan_lists');
    }
}
