<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPlanList;
use App\Models\UserPlan;
use App\Models\Workout;

class UserPlanListController extends Controller
{
    /**
     * Display a listing of the user plan lists.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userPlanLists = UserPlanList::all();

        return response()->json($userPlanLists);
    }

    /**
     * Display the specified user plan list by ID.
     *
     * @param  int  $userPlanId
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userPlanList = UserPlanList::where('user_plan_id', $id)->get();

        if ($userPlanList->isEmpty()) {
            return response()->json(['message' => 'User plan list not found'], 404);
        }

        return response()->json($userPlanList);
        }

    /**
     * Store a newly created user plan list in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userPlanList = UserPlanList::create($request->all());

        return response()->json($userPlanList, 201);
    }

    /**
     * Remove the specified user plan list by ID from storage.
     *
     * @param  int  $userPlanId
     * @return \Illuminate\Http\Response
     */
    public function destroy($userPlanId)
    {
         // Find UserPlanList(s) by userPlanId
        $userPlanLists = UserPlanList::where('user_plan_id', $userPlanId)->get();

        if ($userPlanLists->isEmpty()) {
            return response()->json(['message' => 'User plan lists not found'], 404);
        }

        // Delete the found UserPlanList(s)
        $userPlanLists->each(function ($userPlanList) {
            $userPlanList->delete();
        });

        return response()->json(['message' => 'User plan lists deleted'], 200);
    }

    /**
     * Remove the specified user plan list by workout ID and user plan ID from storage.
     *
     * @param  int  $userPlanId
     * @param  int  $workoutId
     * @return \Illuminate\Http\Response
     */
    public function destroyByWorkoutAndUserPlan($userPlanId, $workoutId)
    {
        // Find the UserPlanList by userPlanId and workoutId
        $userPlanList = UserPlanList::where('user_plan_id', $userPlanId)
        ->where('workout_id', $workoutId)
        ->first();

        if (!$userPlanList) {
            return response()->json(['message' => 'UserPlanList not found'], 404);
        }

        // Delete the found UserPlanList
        $userPlanList->delete();

        return response()->json(['message' => 'UserPlanList deleted'], 200);
    }
}
