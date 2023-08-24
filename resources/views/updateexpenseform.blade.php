@extends('layouts.app')
@section('content')
    <!-- Add Expense Form -->
    <div class="card">
        <div class="card-body">
            <form method="POST"  action="{{ url('updateexpense',$expense->id) }}">
                {{ csrf_field() }}
                <!-- for fetching the ID of the selected entry in the 'update expense form' -->
                <!-- <div class="mb-3">
                    <label for="expenseID" class="form-label">Expense ID:</label>
                    <input name="expenseID" type="number" value= "{{$expense->id }}" placeholder="Mention Expense ID" class="form-control" id="expenseID">
                </div> -->
                <div class="mb-3">
                    <label for="expenseType" class="form-label">Expense Type:</label>
                    <input name="expenseType" type="text" value="{{$expense->expense_name}}" placeholder="Mention Expense Type" class="form-control" id="expenseType">
                </div>
                <div class="mb-3">
                    <label for="currentAmount" class="form-label">Amount (PKR)</label>
                    <input disabled name="currentAmount" type="number" value="{{$expense->current_amount}}" class="form-control" id="currentAmount">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection