@extends('layouts.app')
@section('content')
    <!-- Add Expense Form -->
    <div class="card">
        <div class="card-body">
            <form method="post" action="{{url('expenses/create/store')}}">
            {{ csrf_field() }}
                <div class="mb-3">
                    <label for="expense_name" class="form-label">Expense Category:</label>
                    <input name="expense_name" type="text" placeholder="Mention Expense Category" class="form-control" id="expense_name">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection