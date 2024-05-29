<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    // List tasks for the authenticated user
    public function index()
    {
        if(Auth::user()){
            $tasks = Task::where('user_id', Auth::user()->id)->get();
            if($tasks){
                return response()->json($tasks);
            }
            else{
                return response()->json(['message'=> 'Task not found'], 404);
            }
        }
        else{
            return response()->json(['message'=> 'User not found'], 404);
        }
    }

    // Create a new task
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in-progress,completed',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $task = new Task();
        $task->user_id = Auth::user()->id;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->status = $request->status;
        $task->save();

        return response()->json(['message'=>'Task added successfuly'], 200);
    }

    // Update an existing task
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in-progress,completed',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $task = Task::find($id);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->status = $request->status;
        $task->update();

        return response()->json(['message'=>'Task updated successfuly'], 200);
    }

    // Delete a task
    public function destroy($id)
    {
        $task = Task::find($id);
        if($task){
            $task->delete();
            return response()->json(['message' => 'Task deleted successfully.'], 200);
        }
        else{
            return response()->json(['message' => 'Task not found.'], 404);
        }
    }
}
