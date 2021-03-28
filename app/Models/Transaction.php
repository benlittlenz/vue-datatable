<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeContains($query, $column, $operator, $value) {
        $query->where($column, $operator, '%' . $value . '%');
    }

    public function scopeSearch($query, string $terms = null)
    {
        // Wrap the search term in a collection to perform operations on it
        // Splitting by a space and filter through each search item
        collect(explode(' ', $terms))->filter()->each(function ($term) use ($query) {
            $term = '%' . $term . '%'; // Wildcard symboil for partiall matching

            $query->where('category', 'like', $term)
                ->orWhere('payee', 'like', $term)
                ->orWhere('amount', 'like', $term)
                ->orWhere('notes', 'like', $term)
                ->orWhere('account', 'like', $term);
        });
    }
}
