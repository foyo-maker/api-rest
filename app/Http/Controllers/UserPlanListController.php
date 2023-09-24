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
    public function destroy($id)
    {
         // Find UserPlanList(s) by userPlanId
        $userPlanLists = UserPlanList::find($id);

        if (!$userPlanLists) {
            return response()->json(['message' => 'User plan lists not found'], 404);
        }

        // Delete the found UserPlanList(s)
        $userPlanLists->each(function ($userPlanList) {
            $userPlanList->delete();
        });

        return response()->json(['message' => 'User plan lists deleted'], 200);
    }

    
}
