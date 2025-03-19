@extends('adminlte::page')

@section('title', 'Editar Tarefa')

@section('content_header')
<h1>Editar Tarefa</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('tasks.update', $task) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $task->title) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" id="description" class="form-control" required>{{ old('description', $task->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="priority">Prioridade</label>
                <select name="priority" id="priority" class="form-control" required>
                    <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Baixa</option>
                    <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Média</option>
                    <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>Alta</option>
                </select>
            </div>

            <div class="form-group">
                <label for="deadline">Prazo</label>
                <input type="datetime-local" name="deadline" id="deadline" class="form-control" value="{{ old('deadline', $task->deadline) }}" required>
            </div>

            <div class="form-group">
                <label for="project_id">Projeto</label>
                <select name="project_id" id="project_id" class="form-control" required>
                    @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ $task->project_id == $project->id ? 'selected' : '' }}>{{ $project->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="responsavel">Responsável</label>
                <select name="responsavel" id="responsavel" class="form-control" required>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $task->responsavel->id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>


            <button type="submit" class="btn btn-primary">Atualizar</button>
        </form>
    </div>
</div>
@stop