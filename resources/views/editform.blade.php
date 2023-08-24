@extends('layouts.app')
@section('content')
    <!-- Add Expense Form -->
    <div class="card">
        <div class="card-body">
            <form method="POST"  action="{{ url('expenses/{id}/edit/store') }}">
                {{ csrf_field() }}
                <!-- for fetching the ID of the selected entry in the 'edit form' -->
                <input name="expenseID" hidden type="number" value= "{{$expenses->id}}" placeholder="Mention Expense ID" class="form-control" id="expenseID" readonly>
                
                <div class="mb-3">
                    <label for="editexpensetype" class="form-label">Expense Type:</label>
                    <input name="editexpensetype" type="text" value="{{$expenses->expense_name}}" placeholder="Mention Expense Type" class="form-control" id="editexpensetype">
                </div>
                <!-- <div class="mb-3">
                    <label for="currentAmount" class="form-label">Amount (PKR)</label>
                    <input name="currentAmount" type="number" value="{{$expenses->current_amount}}" class="form-control" id="currentAmount">
                </div> -->
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection