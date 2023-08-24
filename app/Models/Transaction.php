<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function expenseType() {
        return $this->belongsTo(ExpenseType::class ,'expense_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
