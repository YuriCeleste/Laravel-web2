@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Lista de Livros</h1>

    <a href="{{ route('books.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus"></i> Adicionar Livro
    </a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Capa</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($books as $book)
                <tr>
                    <td>{{ $book->id }}</td>
                    <td>
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Capa" style="max-width: 50px; max-height: 70px;">
                        @else
                            <img src="{{ asset('images/default-cover.png') }}" alt="Capa padrão" style="max-width: 50px; max-height: 70px;">
                        @endif
                    </td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author->name ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-info btn-sm">Visualizar</a>
                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary btn-sm">Editar</a>
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Deseja excluir este livro?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Nenhum livro encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $books->links() }}
</div>
@endsection