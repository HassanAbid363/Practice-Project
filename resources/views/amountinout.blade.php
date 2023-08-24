@extends('layouts.app')
@section('content')
    <!-- Add Expense Form -->
    <div class="card">
        <div class="card-body">
            <form method="POST" @if($method == 'in') action="{{ url('expenses/in') }}" @else action="{{ url('expenses/out') }}" @endif>
                {{ csrf_field() }}
                <input name="expense_id"  type="text" value="{{$expense_id}}" readonly class="form-control" id="expense_name">
                <br>
                <div class="mb-3">
                    <label for="expense_name" class="form-label">Expense Category:</label>
                    <input name="expense_name"  type="text" value="{{$expense_name}}" readonly class="form-control" id="expense_name">
                    <br>
                    <label for="amount" class="form-label">Amount:</label>
                    <input name="amount" type="text" value=""  class="form-control" id="amount">
                    <br>
                    <label for="comment" class="form-label">Comment</label>
                    <input name="comment" type="text" value="" class="form-control" id="comment">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection