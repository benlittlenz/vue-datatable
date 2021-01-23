<?php

namespace App\Http\Controllers;

use App\Events\TransactionCreated;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Resources\TransactionResource;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $pageLimit = $request->limit;
        return TransactionResource::collection(Transaction::latest()->paginate($pageLimit))->response();
    }

    public function store() {
        $data = request()->validate([
            'date' => 'required|date',
            'category' => 'required|max:255',
            'payee' => '',
            'amount' => 'required',
            'notes' => '',
            'account' => 'required|max:255',
        ]);

        $transaction = Transaction::create($data);

        broadcast(new TransactionCreated($transaction))->toOthers();

        return $transaction;
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

    public function destroy($transactions)
    {
        Transaction::whereIn('id', explode(',', $transactions))->delete();
    }
}
