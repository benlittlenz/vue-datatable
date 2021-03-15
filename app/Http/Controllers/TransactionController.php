<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Events\TransactionCreated;
use App\Http\Resources\TransactionResource;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $filters = json_decode($request->filters);
        //dd($filters);
        $pageLimit = $request->limit;
        //dd($filters);

        if($filters) {
            $query = Transaction::query();

            foreach ($filters as $filter) {
                if ($filter->column == 'date') {
                    $query->whereBetween('date', [Carbon::parse($filter->fromDate)->format('Y-m-d'), Carbon::parse($filter->toDate)->format('Y-m-d')]);
                } else {
                    if($filter->operator === 'equals') {
                        $query->where($filter->column, '=', $filter->value);
                    } else if($filter->operator === 'contains') {
                        $query->where($filter->column, 'LIKE', '%' . $filter->value . '%');
                    } else if($filter->operator === 'does not contain') {
                        $query->where($filter->column, 'NOT LIKE', '%' . $filter->value . '%');
                    }
                }
            }
            return TransactionResource::collection($query->paginate($pageLimit));
        }
        return TransactionResource::collection(Transaction::latest()->paginate($pageLimit))->response();
    }

    public function store()
    {
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

    public function getSearchValue($operator, $value)
    {
        return $operator === 'LIKE' || $operator === 'NOT LIKE'
            ?  '%' . $value . '%'
            : $value;
    }
}
