@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h4>Your friends</h4>  
                    <form action="/home" method="POST">
                        {{ csrf_field() }}
                        @foreach ($following_users as $user)
                            <p>{{ $user->following->name }}</p>
                            <input type="radio" name="{{ $user->following->id }}" value="1"> 1
                            <input type="radio" name="{{ $user->following->id }}" value="2"> 2
                            <input type="radio" name="{{ $user->following->id }}" value="3"> 3
                            <input type="radio" name="{{ $user->following->id }}" value="4"> 4
                        @endforeach
                        <div><input type="submit" value="Submit"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
