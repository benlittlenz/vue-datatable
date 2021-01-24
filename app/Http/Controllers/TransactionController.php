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

        $query = Transaction::query();

        foreach ($filters as $filter) {
            if ($filter->column == 'date') {
                $query->whereBetween('date', [Carbon::parse($filter->fromDate)->format('Y-m-d'), Carbon::parse($filter->toDate)->format('Y-m-d')]);
            } else {
                $query->where($filter->column, $filter->operator ?? '=', $filter->value);
            }
        }

        return TransactionResource::collection($query->paginate($pageLimit));
        // if ($filters) {
        // return TransactionResource::collection(
        //     Transaction::query()
        //         ->when($filters->column !== 'date', function ($query) use ($filters) {
        //             $query->where($filters->column, $filters->value);
        //         })
        //         ->when($filters->column === 'date', function ($query) use ($filters) {
        //             $query->whereBetween('date', [Carbon::parse($filters->fromDate)->format('Y-m-d'), Carbon::parse($filters->toDate)->format('Y-m-d')]);
        //         })
        //         ->when($filters->operator === 'is not blank', function ($query) use ($filters) {
        //             $query->whereNotNull($filters->column);
        //         })
        //         ->when($filters->operator === 'is blank', function ($query) use ($filters) {
        //             $query->whereNull($filters->column);

        //         })
        //         ->paginate($pageLimit)
        // )->response();


        // }
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
