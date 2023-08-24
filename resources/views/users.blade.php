@extends('layouts.app')
@section('content')
        <!-- Table Information Card -->
        <div class="card border-light text-center mb-3 text-bg-dark" style="max-width: 100%;">
            <div class="card-body">
                <p class="card-text">
                    The following table displays the credentials i.e name and email of the users that are using the <b>Expense Management System Portal</b>.
                </p>
            </div>
        </div>
        <br><br>

        <!-- Table Code -->
        <table class="table table-dark table-striped table-hover table-sm caption-top table-bordered text-center">
            <thead>
                <tr>
                    <th colspan="6">LIST OF USERS</th>
                </tr>
                <tr>
                    <th scope="col">Sr#</th>
                    <th scope="col">DB Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Actions</th>
                    <th scope="col">Status (Active/Inactive)</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
            <tbody>
                <!-- for displaying Sr#, DB_id, name, email, action & status -->
                @foreach ($users as $key => $user) <!--this for loop is for incremental serial numbers in expense table -->
                     <!--this for loop loops through the $users var that has all the data from $user model and shows it in the "user table" on page -->
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <th scope="row">{{ $user -> id }}</th>
                            <td><a href="expenseperuser/{{$user->id}}" style="text-decoration: none;">{{ $user->name }}</a></td>
                            <td>{{ $user->email}}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <a href="updateuserform/{{$user->id}}" class="btn btn-outline-primary" >Update</a>
                                </div>
                            </td>
                            <td>
                                <label class="switch">
                                    <input data-id="{{$user->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $user->status ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                        </tr>
                    @endforeach
                
            </tbody>
        </table>

        @endsection
<!-- Ajax CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
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