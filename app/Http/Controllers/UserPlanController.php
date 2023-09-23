<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPlan;
use App\Models\Users;

class UserPlanController extends Controller
{
    /**
     * Display a listing of user plans.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userPlans = UserPlan::all();

        return response()->json($userPlans);
    }

    /**
     * Display the specified user plan by user ID.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function show($userId)
    {
        // Find UserPlan(s) by userId
        $userPlans = UserPlan::where('user_id', $userId)->get();

        if ($userPlans->isEmpty()) {
            return response()->json(['message' => 'User plans not found'], 404);
        }

        return $userPlans;
    }

    /**
     * Store a newly created user plan in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userPlan = UserPlan::create($request->all());

        return $userPlan;
    }

    /**
     * Remove the specified user plan by user ID from storage.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function destroy($Id)
    {
        $userPlan = UserPlan::find($Id);

        if (!$userPlan) {
            return response()->json(['message' => 'User plan not found'], 404);
        }

        $userPlan->delete();

        return response()->json(['message' => 'User plan deleted'], 200);
    }

    /**
     * Create a new user plan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createUserPlan(Request $request)
    {
        $userPlan = UserPlan::create($request->all());

        return response()->json($userPlan, 201);
    }

    
    
}
