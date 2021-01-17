<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Resources\TransactionResource;

class TransactionController extends Controller
{
    public function index()
    {
        return TransactionResource::collection(Transaction::paginate(25))->response();
    }

    public function store() {
        $transaction = request()->validate([
            'date' => 'required|date',
            'category' => 'required|max:255',
            'payee' => '',
            'amount' => 'required',
            'notes' => '',
            'account' => 'required|max:255',
        ]);

        return Transaction::create($transaction);
    }

    public function update(Transaction $transaction)
    {
        return $transaction->update([
            'date' => request('date'),
            'category' => request('category'),
            'payee' => request('payee'),
            'amount' => request('amount'),
            'notes' => request('notes'),
            'account' => request('account'),
        ]);
    }
}
