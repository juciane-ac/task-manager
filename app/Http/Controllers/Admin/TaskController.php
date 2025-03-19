<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use App\Enums\TaskPriority;
use App\Models\Project;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class TaskController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $tasks = Task::all();
        return view('admin.tasks.index', compact('tasks'));
    }

    public function create()
    {
        $projects = Project::all();
        $users = User::all();  
        return view('admin.tasks.create', compact('projects','users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => ['required', Rule::in(array_map(fn($enum) => $enum->value, TaskPriority::cases()))],
            'deadline' => 'required|date',
            'project_id' => 'required|exists:projects,id',
            'responsible' => 'required|exists:users,id',  
        ]);


        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => TaskPriority::from($request->priority),
            'deadline' => $request->deadline,
            'project_id' => $request->project_id,
            'responsible' => $request->responsible,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tarefa criada com sucesso!');
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => ['required', Rule::in(array_map(fn($enum) => $enum->value, TaskPriority::cases()))],
            'deadline' => 'required|date',
            'project_id' => 'required|exists:projects,id',
            'responsible' => 'required|exists:users,id', 
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => TaskPriority::from($request->priority),
            'deadline' => $request->deadline,
            'project_id' => $request->project_id,
            'responsible' => $request->responsible,  
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tarefa atualizada com sucesso!');
    }

    public function edit(Task $task)
    {
        $projects = Project::all();
        $users = User::all();  
        return view('admin.tasks.edit', compact('task', 'projects','users'));
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tarefa deletada com sucesso!');
    }

    public function changeSituation(Task $task)
    {
        
        if (auth()->id() !== $task->responsible) {
            return redirect()->back()->with('error', 'Você não tem permissão para concluir esta tarefa.');
        }

        $task->situation = 'concluida'; 
        $task->save(); 
    
        if ($task->wasChanged()) {
            return redirect()->back()->with('success', 'Tarefa concluída com sucesso.');
        } else {
            return redirect()->back()->with('error', 'Não foi possível concluir a tarefa.');
        }
    }
}
