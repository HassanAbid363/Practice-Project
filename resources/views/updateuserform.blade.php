@extends("layouts.app")
@section('content')
    <!-- Add Expense Form -->
    <div class="card">
        <div class="card-body">
            <form method="POST"  action="{{ url('updateuser',$users->id) }}">
                {{ csrf_field() }}

                <div class="mb-3">
                    <label for="userName" class="form-label">User Name:</label>
                    <input name="userName" type="text" value="{{$users->name}}" class="form-control" id="userName">
                </div>
                <div class="mb-3">
                    <label for="userEmail" class="form-label">Email:</label>
                    <input name="userEmail" type="email" value="{{$users->email}}" class="form-control" id="userEmail">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection