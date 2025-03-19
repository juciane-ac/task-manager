@extends('adminlte::page')

@section('title', 'Criar Tarefa')

@section('content_header')
<h1>Criar Nova Tarefa</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('tasks.store') }}">
            @csrf
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
            </div>

            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" id="description" class="form-control" required>{{ old('description') }}</textarea>
            </div>

            
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="responsible">Responsável</label>
                        <select name="responsible" id="responsible" class="form-control" required>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('responsible') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label for="priority">Prioridade</label>
                        <select name="priority" class="form-control" required id="priority">
                            <option value="">Selecione...</option>
                            <option value="{{ \App\Enums\TaskPriority::low->value }}" {{ old('priority') == \App\Enums\TaskPriority::low->value ? 'selected' : '' }}>Baixa</option>
                            <option value="{{ \App\Enums\TaskPriority::medium->value }}" {{ old('priority') == \App\Enums\TaskPriority::medium->value ? 'selected' : '' }}>Média</option>
                            <option value="{{ \App\Enums\TaskPriority::high->value }}" {{ old('priority') == \App\Enums\TaskPriority::high->value ? 'selected' : '' }}>Alta</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="deadline">Deadline</label>
                <input type="datetime-local" name="deadline" id="deadline" class="form-control" value="{{ old('deadline') }}" required>
            </div>
           
            <div class="form-group">
                <label for="project_id">Projeto</label>
                <select name="project_id" id="project_id" class="form-control" required>
                    @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>{{ $project->title }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</div>
@stop