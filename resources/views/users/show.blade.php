@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Detalhes do Usuário</h1>

    <div class="card">
        <div class="card-header">
            {{ $user->name }}
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $user->id }}</p>
            <p><strong>Nome:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Cadastrado em:</strong> {{ $user->created_at }}</p>
            <p><strong>Atualizado em:</strong> {{ $user->updated_at }}</p>
        </div>
    </div>

    <a href="{{ route('users.borrowings', $user->id) }}" class="btn btn-info mt-3">Ver Empréstimos</a>
    <a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">Voltar</a>
</div>
@endsection

