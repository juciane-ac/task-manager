@extends('adminlte::page')

@section('content')
    <div class="container">
        <h1>Editar Projeto</h1>
        <form action="{{ route('projects.update', $project) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $project->title) }}" required>
            </div>

            <div class="form-group">
                <label for="manager">Gestor</label>
                <select name="manager" id="manager" class="form-control" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $project->gestor == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Atualizar</button>
        </form>
    </div>
@endsection
