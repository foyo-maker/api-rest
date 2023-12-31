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
            $table->unsignedBigInteger('user_id');
            $table->text('description')->nullable();
            $table->string('gifimage')->nullable();
            $table->double('calorie')->nullable();
            $table->string('link')->nullable();
            $table->string('bmi_status')->nullable();
            // Add other columns as needed

            $table->timestamps();
        });

        Schema::table('user_plan_lists', function (Blueprint $table) {
            $table->foreign('user_plan_id')->references('id')->on('user_plans')->onDelete('cascade');
            $table->foreign('workout_id')->references('id')->on('workouts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
