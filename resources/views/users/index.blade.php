@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Lista de Usuários</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm">Visualizar</a>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">Editar</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Nenhum usuário encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $users->links() }}
</div>
@endsection

