@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Detalhes do Livro</h1>

    <div class="card">
        <div class="card-header">
            <strong>{{ $book->title }}</strong>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    @if($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Capa do livro" class="img-fluid">
                    @else
                        <img src="{{ asset('images/default-cover.png') }}" alt="Capa padrão" class="img-fluid">
                    @endif
                </div>
                <div class="col-md-8">
                    <p><strong>ID:</strong> {{ $book->id }}</p>
                    <p><strong>Título:</strong> {{ $book->title }}</p>
                    <p><strong>Páginas:</strong> {{ $book->pages }}</p>
                    <p><strong>Ano de Publicação:</strong> {{ $book->published_year ?? 'N/A' }}</p>
                    <p><strong>Autor:</strong> {{ $book->author->name ?? 'N/A' }}</p>
                    <p><strong>Categoria:</strong> {{ $book->category->name ?? 'N/A' }}</p>
                    <p><strong>Editora:</strong> {{ $book->publisher->name ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulário para Empréstimo -->
    <div class="card mt-4">
        <div class="card-header">Registrar Empréstimo</div>
        <div class="card-body">
            <form action="{{ route('books.borrow', $book) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="user_id" class="form-label">Usuário</label>
                    <select class="form-select" id="user_id" name="user_id" required>
                        <option value="">Selecione um usuário</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Registrar Empréstimo</button>
            </form>
        </div>
    </div>

    <!-- Histórico de Empréstimos -->
    <div class="card mt-4">
        <div class="card-header">Histórico de Empréstimos</div>
        <div class="card-body">
            @if($book->users->isEmpty())
                <p>Nenhum empréstimo registrado.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Usuário</th>
                            <th>Data de Empréstimo</th>
                            <th>Data de Devolução</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($book->users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->pivot->borrowed_at }}</td>
                                <td>{{ $user->pivot->returned_at ?? 'Em Aberto' }}</td>
                                <td>
                                    @if(is_null($user->pivot->returned_at))
                                        <form action="{{ route('borrowings.return', $user->pivot->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-warning btn-sm">Devolver</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <a href="{{ route('books.index') }}" class="btn btn-secondary mt-3">Voltar</a>
</div>
@endsection