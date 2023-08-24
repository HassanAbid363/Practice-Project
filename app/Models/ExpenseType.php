<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseType extends Model
{
    use HasFactory;

    //Relation: ExpenseType hasMany Transaction
    public function transactions() {
        return $this->hasMany(Transaction::class ,'expense_id');
    }

    //Relation: ExpenseType belongsTo User
    public function users() {
        return $this -> belongsTo(User::class);
    }
}
