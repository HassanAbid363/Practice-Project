<?php

namespace App\Http\Controllers;
use App\Models\ExpenseType;
use App\Models\Transaction;
use App\Models\User;
use App\Models\TransactionFollower;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index(){
        $followers = TransactionFollower::where('followers_id', '=', Auth::user()->id) -> get();
        
        $follower_of_expenses = array(); 

        foreach($followers as $follower_of_expense){
            $follower_of_expenses[] = $follower_of_expense->transactions_id;
        }

        $expenses = ExpenseType::whereIn('id', $follower_of_expenses)->get();
    
        return view('newexpense', compact('expenses'));
    }

    public function create(){
        return view('addexpenseform');
    }
   
    public function store(Request $request) {
        $check =ExpenseType::where('expense_name', '=', $request->expense_name) -> first();
        // dd($check);
        if ($check) {
            return "This Expense Category Already Exists";
        } 
        else {
            $expense = new ExpenseType;
            $expense->expense_name = $request -> expense_name;
            $expense->added_by = Auth::user()->id;
            $expense->save();
            

            $newFollower = new TransactionFollower;
            $newFollower->followers_id = Auth::user()->id;
            $newFollower->transactions_id = $expense->id;
            $newFollower->save();
            return redirect('expenses');
        }   
    }

    public function edit($id){
        $expenses = ExpenseType::find($id);
        return view('editform', compact('expenses'));
    }

    public function storeEdit(Request $request){
        
        $check = ExpenseType::where('expense_name', '=', $request->editexpensetype)->first();
       
        if($check){
            return "This Expense Type Already Exists";
        }
        else {
            $expenses = ExpenseType::find($request->expenseID);
            $expenses -> expense_name = $request->editexpensetype;
            $expenses->save();
            return redirect('expenses');
        }
    }

    public function amountIn($expense_name) {
        $expense_name = $expense_name;

        $expense = ExpenseType::where('expense_name', '=', $expense_name) ->first();
        $expense_id= $expense->id;
        $method = 'in';
        return view('amountinout',compact('expense_id','expense_name','method'));
    }

    public function storeAmountIn(Request $request){
        $check = Transaction::where('expense_id', '=',$request->expense_id) -> first();
        
        if($check) {
            $transaction = Transaction::where('expense_id', '=', $request->expense_id)->orderby('created_at', 'desc')->first();
            $currentamount = $transaction->current_amount;

            $addtransaction = new Transaction;
            $addtransaction->added_by =Auth::user()->id;
            $addtransaction->expense_id = $request->expense_id;
            $addtransaction->amount_in = $request->amount;
            $addtransaction->current_amount = $currentamount + $request->amount;
            $addtransaction->comment = $request->comment;
            $addtransaction->save();

            $expensetype = ExpenseType::find($request->expense_id);
            $expensetype->current_amount =$currentamount + $request->amount;
            $expensetype->save();

            return redirect('expenses');
        }
        else{
           $firstTransaction = new Transaction;
           $firstTransaction->added_by =Auth::user()->id;
           $firstTransaction->expense_id = $request->expense_id;
           $firstTransaction->amount_in = $request->amount;
           $firstTransaction->current_amount = $request->amount;
           $firstTransaction->comment = $request->comment;
           $firstTransaction->save();
           
           $expensetype = ExpenseType::find($request->expense_id);
           $expensetype->current_amount = $request->amount;
           $expensetype->save();

           return redirect('expenses');
        }
    }
    
    //Function for Subtracting Amount from Current Amount
    public function amountOut($expense_name) {
        $expense_name = $expense_name;

        $expense = ExpenseType::where('expense_name', $expense_name) ->first();
        $expense_id= $expense->id;
        $method = 'out';
        return view('amountinout',compact('expense_id','expense_name','method'));
    }

    public function storeAmountOut(Request $request){
        $check = Transaction::where('expense_id', '=',$request->expense_id) -> first();
        
        if($check) {
            $transaction = Transaction::where('expense_id', '=', $request->expense_id)->orderby('created_at', 'desc')->first();
            $currentamount = $transaction->current_amount;

            $addtransaction = new Transaction;
            $addtransaction->added_by =Auth::user()->id;
            $addtransaction->expense_id = $request->expense_id;
            $addtransaction->amount_out = $request->amount;
            $addtransaction->current_amount = $currentamount - $request->amount;
            $addtransaction->comment = $request->comment;
            $addtransaction->save();
            
            $expensetype = ExpenseType::find($request->expense_id);
            $expensetype->current_amount =$currentamount - $request->amount;
            $expensetype->save();

            return redirect('expenses');
        }
        else{
           $firstTransaction = new Transaction;
           $firstTransaction->added_by =Auth::user()->id;
           $firstTransaction->expense_id = $request->expense_id;
           $firstTransaction->amount_out = $request->amount;
           $firstTransaction->current_amount = $request->amount;
           $firstTransaction->comment = $request->comment;
           $firstTransaction->save();
           
           $expensetype = ExpenseType::find($request->expense_id);
           $expensetype->current_amount = $request->amount;
           $expensetype->save();
           
           return redirect('expenses');
        }
        //dd($request->Expense_id);
    }
        
    //Function for showing expenses as per user that has been clicked on
    public function expensePerUser($id) {
        // dd($id);
        $expenses = ExpenseType::where('added_by','=',$id) -> get();
        return view('newexpense', compact('expenses'));
    }
    
    //Function for 'Add Expense Form'
    public function addexpenseform() {
        return view('addexpenseform');
    }
    
    public function viewTransactions($name, $id) {

        $transactions = Transaction::where('expense_id', '=', $id) -> get();
        $followers = TransactionFollower::where('transactions_id', '=', $id) -> get();
        $added_by = ExpenseType::where('id','=',$id)->pluck('added_by') -> first();
        
        // dd($added_by);

        $user_id = array(); 

        foreach($followers as $follower){
            $user_id[] = $follower->followers_id;
        }

        $users = User::whereNotIn('id', $user_id)->get();
        $followersfortags = User::whereIn('id', $user_id)->get();

        return view('transactions', compact('transactions', 'users', 'id', 'followersfortags', 'added_by'));
    }
    
    //Function for storing the followers of an expense category at the 'transactions' page
    public function storeTransactionFollowers(Request $request) {
        $newFollower = new TransactionFollower;
        $newFollower->transactions_id = $request->transactionId;
        $newFollower->followers_id = $request->followerId;
        $newFollower->save();
    }
    
    public function removeFollowerTag(Request $request) {
        $Followers = TransactionFollower::where('transactions_id', '=', $request->transactionId)->where('followers_id', '=', $request->followerId)->first();
        $Followers->delete();
    }
}
