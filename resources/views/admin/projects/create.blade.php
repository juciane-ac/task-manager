@extends('adminlte::page')

@section('content')
    <div class="container">
        <h1>Criar Projeto</h1>
        <form action="{{ route('projects.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
            </div>

            <div class="form-group">
                <label for="manager">Gestor</label>
                <select name="manager" id="manager" class="form-control" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('manager') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
@endsection
