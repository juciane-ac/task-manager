@extends('adminlte::page')

@section('content')
    <div class="container">
        <h1>Projetos</h1>
        <a href="{{ route('projects.create') }}" class="btn btn-primary mb-3">Criar Projeto</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Slug</th>
                    <th>Gestor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td>{{ $project->title }}</td>
                        <td>{{ $project->slug }}</td>
                        
                        <td>
                            {{ $project->gestor ? $project->gestor->name : 'Não atribuído' }}
                        </td>
                        <td>
                            <a href="{{ route('projects.edit', $project) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('projects.destroy', $project) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja deletar este projeto?')">Deletar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
