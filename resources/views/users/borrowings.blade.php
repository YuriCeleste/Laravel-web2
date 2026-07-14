@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Histórico de Empréstimos de {{ $user->name }}</h1>

    @if($borrowings->isEmpty())
        <p>Este usuário não possui empréstimos registrados.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Livro</th>
                    <th>Data de Empréstimo</th>
                    <th>Data de Devolução</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($borrowings as $book)
                    <tr>
                        <td>
                            <a href="{{ route('books.show', $book->id) }}">
                                {{ $book->title }}
                            </a>
                        </td>
                        <td>{{ $book->pivot->borrowed_at }}</td>
                        <td>{{ $book->pivot->returned_at ?? 'Em Aberto' }}</td>
                        <td>
                            @if(is_null($book->pivot->returned_at))
                                <form action="{{ route('borrowings.return', $book->pivot->id) }}" method="POST">
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

    <a href="{{ route('users.show', $user->id) }}" class="btn btn-secondary">Voltar</a>
</div>
@endsection

