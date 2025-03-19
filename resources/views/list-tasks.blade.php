@extends('layouts.app')

@section('content')
<div class="container mb-3">
    <form action="{{ route('tasks.filter') }}" method="GET">
        <div class="row">
            <div class="col-6">
                <div class="d-flex align-items-center">
                    <span class="me-2" id="task-number-label">Número</span>
                    <input type="number" class="form-control" placeholder="" aria-label="Número" aria-describedby="task-number-label" name="task_number" value="{{ old('task_number') }}">
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="d-flex align-items-center">
                    <span class="me-2" id="task-description-label">Título/Descrição</span>
                    <input type="text" class="form-control" placeholder="" aria-label="Título/Descrição" aria-describedby="task-description-label" name="task_description" value="{{ old('task_description') }}">
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-6">
                <div class="d-flex align-items-center">
                    <span class="me-2" id="task-responsible-label">Responsável</span>
                    <select class="form-select" aria-label="Responsável" aria-describedby="task-responsible-label" name="responsible" id="responsible">
                        <option value="">Selecione...</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('responsible') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-6">
                <div class="d-flex align-items-center">
                    <span class="me-2" id="task-status-label">Situação</span>
                    <select class="form-select" aria-label="Situação" aria-describedby="task-status-label" name="situation" id="situation">
                        <option value="">Selecione...</option>
                        <option value="em_andamento" {{ old('situation') == 'em_andamento' ? 'selected' : '' }}>Em andamento</option>
                        <option value="concluida" {{ old('situation') == 'concluida' ? 'selected' : '' }}>Concluída</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary ">Buscar tarefas</button>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif


    @isset($tasks)
        @if($tasks->isNotEmpty())
            <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Número</th>
                            <th>Título</th>
                            <th>Responsável</th>
                            <th>Situação</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->responsible->name ?? 'Sem responsável' }}</td>
                            <td>{{ $task->situation }}</td>
                            <td>
                                <div class="d-flex justify-content-end">
                                @auth
                                    @if(auth()->user()->hasAnyRole(['admin', 'manager']) || auth()->id() === $task->responsible) 
                                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-primary m-2">Editar</a>
                                    @endif

                                    @if(auth()->user()->hasAnyRole(['admin', 'manager']))
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger m-2"  onclick="return confirm('Tem certeza que deseja excluir esta tarefa?')">Excluir</button>
                                    </form>
                                    @endif

                                    @if(auth()->id() === $task->responsible)
                                        <form action="{{ route('task.ChangeSituation', $task->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success m-2" onclick="return confirm('Tem certeza que deseja concluir esta tarefa?')">Concluir</button>
                                        </form>
                                    @endif

                                 
                                @endauth
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        
                    
                    </tbody>
                </table>
            </div>
        @endif
    @endisset


</div>
@endsection