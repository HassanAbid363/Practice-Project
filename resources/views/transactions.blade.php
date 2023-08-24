@extends('layouts.app')
@section('content')

{{$added_by}}
{{Auth::user()->id}}
@if ($added_by == Auth::user()->id)
<div >
    <input type="number" hidden name="transactionId" id="transactionId" value = "{{ $id }}">
    <!-- Selector -->
    <select class="form-select" id="followerselector" aria-label="Default select example" style="width: 11%; float: left;">
        <option selected>Add Followers</option>
        @foreach ($users as $key => $user)
        <option id= "tran_{{ $user -> id }}"  value="{{ $user -> id }}" data-name="{{ $user->name }}">{{ $user -> name }}</option>
        @endforeach
    </select>

    <!-- Add Follower Tag -->
    <div id="follower_tag">
        @foreach ($followersfortags as $key => $followerfortag)

        @if ($followerfortag->id == Auth::user()->id)
        @else
            <div class="badge bg-primary" style="width: 6rem; margin: 10px;" id="followers_tag_{{$followerfortag->id}}">
                {{$followerfortag->name}} <a href="javascript:void(0);" style="color: red;" onclick="myfunction({{$followerfortag->id}}, '{{$followerfortag->name}}')"> X   </a>
            </div>

            @endif
        @endforeach
    </div>
</div>
@else
@endif
<br><br>
<p class="text text-light">*The Followers selected would be able view & edit the tansactions related to this expense Category. Only the creator can delete the expense category or the transactions</p>
<br>
<div>
    <!-- Table Code -->
    <table class="table table-dark table-striped table-hover table-sm caption-top table-bordered text-center">
        <thead>
            <tr>
                <th colspan="5">LIST OF TRANSACTIONS</th>
            </tr>
            <tr>
                <th scope="col">Sr#</th>
                <th scope="col">Amount In</th>
                <th scope="col">Amount Out</th>
                <th scope="col">Current Amount</th>
                <th scope="col">Comment</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
        <tbody>
        <!-- for displaying Sr#, DB_id, name, status, amount, action & status -->
            @foreach ($transactions as $key => $transaction) <!--this for loop is for incremental serial numbers in expense table & to loop through the $transactions var that has all the data from $transaction model and shows it in the "transaction table" on page -->
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <th scope="row">{{ $transaction -> amount_in }}</th>
                    <td>{{ $transaction -> amount_out }}</td>
                    <td>{{ $transaction -> current_amount}}</td>
                    <td>{{ $transaction -> comment}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
<!-- Ajax CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    $(document).ready(function(){

        $('select').on('change', function() {
            // debugger
            var followerId = $(this).val();  
            var name = $(this).find(':selected').attr('data-name');
            var myname = "'"+name+"'";
            //alert(followerId);
            var transactionId = $('#transactionId').val();
            $.ajax({
                type: 'post',
                url: '/transactionfollowers',
                data: {
                    "_token": "{{ csrf_token() }}",
                    followerId: followerId,
                    transactionId: transactionId
                },
                success: function(response) {
                    var my_id = 'tran_'+followerId;
                    var test = $('#'+my_id).hide();
                    $('#follower_tag').append('<div class="badge bg-primary text-wrap" style="width: 6rem; margin: 10px;" id="followers_tag_'+followerId+'">'+name+' <a href="javascript:" style="color: red;" onclick=" return myfunction( '+ followerId +', '+ myname +' )"> X </a></div>')
                }
            })  
        })
    });

    function myfunction(id ,name){
        var followerId = id;
        var name = name;
        var transactionId = $('#transactionId').val();
        $.ajax({
            type: 'get',
            url: '/removetransactionfollowertag',
            data: {
                followerId: followerId,
                transactionId: transactionId
            },
            success: function(response) {
                debugger
                var id = '#followers_tag_' + followerId;
                $('#followers_tag_'+followerId).hide();
                $('#followerselector').append('<option id= "tran_'+followerId+'"  value="'+followerId+'" data-name="'+name+'">'+name+'</option>')
            }
        })
        // debugger
    }
</script>