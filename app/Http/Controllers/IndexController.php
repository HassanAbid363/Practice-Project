<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ExpenseType;
use App\Models\Transaction;

class IndexController extends Controller
{
    public function index() {
        $users = User::all();
        $expenseTypes = ExpenseType::all();
        $transactions = Transaction::all();

        return ($users);
    }
}
