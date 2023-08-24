@extends('layouts.app')
@section('content')
    <!-- Buttons for Adding & Updating Expense -->
    <div class="d-grid gap-2 d-md-flex justify-content-md-end" style="width:97%">
        <a href="{{ url('expenses/create') }}" class="btn btn-primary" style="color: white;width:20%">Add Expense Category</a>
    </div>
    <br>

    <!-- Table Code -->
    <table class="table table-dark table-striped table-hover table-sm caption-top table-bordered text-center">
        <thead>
            <tr>
                <th colspan="9">LIST OF EXPENSES</th>
            </tr>
            <tr>
                <th scope="col">Sr#</th>
                <th scope="col">DB Id</th>
                <th scope="col">Name</th>
                <th scope="col">Amount (PKR)</th>
                <th scope="col">Actions</th>
                <th scope="col">Active / Inactive</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
        <tbody>
            @foreach ($expenses as $key => $expense)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <th scope="row">{{ $expense -> id }}</th>
                    <td>{{ $expense -> expense_name }}</td>
                    <td>{{ $expense -> current_amount}}</td>
                    <td>
                        <a href="viewtransactions/{{$expense->expense_name}}/{{$expense -> id}}" class="btn btn-primary btn-sm">View</a>
                        <a href="expenses/{{$expense -> id}}/edit" class="btn btn-danger btn-sm" >Edit</a>
                        <a href="expensein/{{ $expense->expense_name }}" class="btn btn-outline-primary btn-sm" >+</a>
                        <a href="expenseout/{{ $expense->expense_name }}" class="btn btn-outline-danger btn-sm" >-</a>
                    </td>
                    @if( $expense -> added_by == Auth::user()->id)
                    <td>
                        <label class="switch">
                            <input data-id="{{$expense->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $expense->status ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </td>
                    @else
                    <td>
                        Follower
                    </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
<!-- Ajax CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script type="text/javascript">
  $(function() {
    $('.toggle-class').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0; 
        var id = $(this).data('id'); 
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/changeStatus',
            data: {'status': status, 'id': id},
            success: function(data) {
              console.log(data.success)
            }
        });
    })
});
</script>

@endsection