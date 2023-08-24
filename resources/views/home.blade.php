@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <!DOCTYPE html>
                    <html lang="en">
                        <head>
                            <meta charset="UTF-8">
                            <meta http-equiv="X-UA-Compatible" content="IE=edge">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <title>Expense Management System</title>
                            <style>
                                body{
                                    background-color: black;
                                }
                            </style>
                        </head>
                        <body>
                            <?php 
                                $username = Auth::user()->name;
                            ?>

                            <!-- SAMPLE CARD 03 -->
                            <div class="card border-light text-center mb-3 text-bg-dark" style="max-width: 100%;">
                                <div class="card-header">
                                    Expense Management System
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Hello, {{ $username }}!</h5>
                                    <p class="card-text">You have successfully logged in to the <b>Expense Management System Portal</b>.</p>
                                    <a href="#" class="btn btn-primary">Click to see profile</a> <!-- upon clicking displays logged in person's profile right below--> 
                                </div>
                            </div>
                        </body>
                    </html>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection