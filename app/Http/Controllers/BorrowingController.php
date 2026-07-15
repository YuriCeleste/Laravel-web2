<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    public function store(Request $request, Book $book)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // ========================================
        // ATIVIDADE 08: Verificar se o livro já está emprestado
        // ========================================
        $existingBorrowing = Borrowing::where('book_id', $book->id)
            ->whereNull('returned_at')
            ->first();

        if ($existingBorrowing) {
            return redirect()->route('books.show', $book)
                ->with('error', 'Este livro já está emprestado. Aguarde a devolução.');
        }

        // ========================================
        // ATIVIDADE 09: Verificar limite de 5 livros por usuário
        // ========================================
        $activeBorrowings = Borrowing::where('user_id', $request->user_id)
            ->whereNull('returned_at')
            ->count();

        if ($activeBorrowings >= 5) {
            return redirect()->route('books.show', $book)
                ->with('error', 'Este usuário já possui 5 livros emprestados (limite máximo).');
        }

        // ========================================
        // ATIVIDADE 10: Verificar se o usuário tem débitos
        // ========================================
        $user = User::findOrFail($request->user_id);
        if ($user->debit > 0) {
            return redirect()->route('books.show', $book)
                ->with('error', 'Este usuário possui débitos pendentes de R$ ' . number_format($user->debit, 2, ',', '.') . '. Não pode fazer novos empréstimos.');
        }

        // Registrar o empréstimo
        Borrowing::create([
            'user_id' => $request->user_id,
            'book_id' => $book->id,
            'borrowed_at' => now(),
        ]);

        return redirect()->route('books.show', $book)
            ->with('success', 'Empréstimo registrado com sucesso.');
    }

    public function returnBook(Borrowing $borrowing)
    {
        $borrowedAt = Carbon::parse($borrowing->borrowed_at);
        $returnedAt = now();
        $daysLate = $returnedAt->diffInDays($borrowedAt) - 15;

        $user = $borrowing->user;
        $fine = 0;

        // ========================================
        // ATIVIDADE 10: Calcular multa por atraso
        // ========================================
        if ($daysLate > 0) {
            $fine = $daysLate * 0.50;
            $user->debit += $fine;
            $user->save();
        }

        $borrowing->update([
            'returned_at' => $returnedAt,
        ]);

        $message = 'Devolução registrada com sucesso.';
        if ($fine > 0) {
            $message .= " Multa de R$ " . number_format($fine, 2, ',', '.') . " aplicada por $daysLate dias de atraso.";
        }

        return redirect()->route('books.show', $borrowing->book_id)
            ->with('success', $message);
    }

    public function userBorrowings(User $user)
    {
        $borrowings = $user->books()->withPivot('id', 'borrowed_at', 'returned_at')->get();
        return view('users.borrowings', compact('user', 'borrowings'));
    }
}