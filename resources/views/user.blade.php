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
                    {{$user->name}}
                    <form action="/following" method="post">
                    {{ csrf_field() }}
                    <input type="text" name="following_user" value="{{$user->id}}" hidden>
                        <button type="submit" class="btn btn-primary">Following</button>
                    </form> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
