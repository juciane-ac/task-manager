<?php

namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::select('id', 'name')->get();
        return view('list-tasks', compact('users'));
    }

    public function filterTasks(Request $request)
    {
        $users = User::select('id', 'name')->get();
        
        $tasks = Task::withoutGlobalScopes();

        if ($request->filled('task_number')) {
            $tasks->where('id', $request->task_number);
        }

        if ($request->filled('task_description')) {
            $tasks->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->task_description . '%')
                      ->orWhere('description', 'like', '%' . $request->task_description . '%');
            });
        }        

        if ($request->filled('responsible')) {
            $tasks->where('responsible', $request->responsible);
        }

        if ($request->filled('situation')) {
            $tasks->where('situation', $request->situation);
        }

        $tasks = $tasks->orderBy('created_at', 'desc')->paginate(20);

        return view('list-tasks', compact('tasks','users'));
    }
}
