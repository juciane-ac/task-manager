@extends('adminlte::page')

@section('content')
    <div class="container">
        <h1>Tarefas</h1>

        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
        <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Criar Tarefa</a>
        @endif 

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Responsável</th>
                    <th>Prioridade</th>
                    <th>Prazo</th>
                    <th>Projeto</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        
                        <td>{{ $task->responsavel->name }}</td>
                        <td>{{ $task->priority }}</td>
                        <td>{{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y H:i') }}</td>
                        <td>{{ $task->project->title }}</td>
                        <td>
                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-sm">Editar</a>
                            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja deletar este projeto?')">Deletar</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
