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
                    @if(Auth::user()->id != $user->id)
                        @if ($following === 1)
                            <form action="/users/{{ $user->id }}" method="POST">
                                    {{ csrf_field() }}
                                    @method('DELETE')
                                    <input type="number" name="following_user" value="{{ $user->id }}" hidden>
                                    <button type="submit" class="btn btn-primary">Unfollow</button>
                            </form> 
                        @else
                            <form action="/users" method="POST">
                                    {{ csrf_field() }}
                                    <input type="number" name="following_user" value="{{ $user->id }}" hidden>
                                    <button type="submit" class="btn btn-primary">Following</button>
                            </form> 
                        @endif
                    @endif
                    <h4>Introduction</h4>
                    @if(Auth::user()->id === $user->id)
                        <form action="/users/{{ $user->id }}" method="POST">
                            {{ csrf_field() }}
                            @method('PUT')
                            <input type="text" name="introduction" value="@if(!empty($user->profile->introduction)){{ $user->profile->introduction }} @endif">
                            <div><button type="submit" class="btn btn-primary">Update</button></div>
                        </form>
                    @else
                        @if(!empty($user->profile->introduction)){{ $user->profile->introduction }} @endif
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
