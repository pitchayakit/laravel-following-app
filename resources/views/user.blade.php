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
                    <h1>{{ $user->name }}</h1>
                    @if ($following === 1)
                    <form action="/follow/{{ $user->id }}" method="post">
                            {{ csrf_field() }}
                             @method('DELETE')
                            <input type="text" name="following_user" value="{{ $user->id }}" hidden>
                            <button type="submit" class="btn btn-primary">Unfollow</button>
                        </form> 
                    @else
                    <form action="/follow/create" method="get">
                            {{ csrf_field() }}
                            <input type="text" name="following_user" value="{{ $user->id }}" hidden>
                            <button type="submit" class="btn btn-primary">Following</button>
                        </form> 
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
