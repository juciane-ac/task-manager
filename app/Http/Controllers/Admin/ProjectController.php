<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $projects = Project::paginate(20);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $users = User::all(); 
        $projects = Project::all(); 
        
        return view('admin.projects.create', compact('users','projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'manager' => 'required|exists:users,id',
        ]);

        try {
            Project::create([
                'title' => $request->title,
                'manager' => $request->manager,
            ]);

            return redirect()->route('projects.index')->with('success', 'Projeto criado com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao criar o projeto: ' . $e->getMessage());
        }
    }

    public function edit(Project $project)
    {
        $users = User::all(); 
        $project->load('gestor');
        return view('admin.projects.edit', compact('project', 'users'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'manager' => 'required|exists:users,id',
        ]);

        $project->update([
            'title' => $request->title,
            'manager' => $request->manager,
        ]);

        return redirect()->route('projects.index')->with('success', 'Projeto atualizado com sucesso!');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Projeto deletado com sucesso!');
    }
}
