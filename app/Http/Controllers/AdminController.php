<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function show($id)
    {
        $user = User::find($id);
        if($user){
            return response()->json($user);
        }
        else{
            return response()->json(['message' => 'User not found.'], 404);
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if($user){
            $user->delete();
            return response()->json(['message' => 'User deleted successfully.'], 200);
        }
        else{
            return response()->json(['message' => 'User not found.'], 404);
        }
    }

    public function userTasks($id)
    {
        $user = User::findOrFail($id);


        if($user){
            $tasks = Task::where('user_id', $user->id)->get();
            if($tasks){
                return response()->json($tasks);
            }
            else{
                return response()->json(['message'=>'No task found'], 404);
            }

        }
        else{
            return response()->json(['message'=>'No user found'], 404);
        }

    }
}
