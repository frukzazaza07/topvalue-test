@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow rounded">
                <div class="card-body">
                    <h3>Login form</h3>
                    <form action="/authen/login" method="POST">

                        @csrf

                        <div class="form-group">
                            <label class="font-weight-bold">Username</label>
                            <input type="text" class="form-control" name="username">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Password</label>
                            <input type="text" class="form-control" name="password">
                        </div>
                        <button type="submit" class="btn btn-md btn-primary">Login</button>
                        @include('errorMessage.index')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection