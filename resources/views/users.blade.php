@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Following</div>

                <div class="card-body">
                    <ul>
                    @foreach ($following_users as $user)
                        <li><a href="/users/{{ $user->following->id }}">{{ $user->following->name }}</a></li>
                    @endforeach
                    </ul>
                </div>
            </div>
            <hr>
            <div class="card">
                <div class="card-header">All users</div>

                <div class="card-body">
                    <ul>
                    @foreach ($users as $user)
                        <li><a href="users/{{ $user->id }}"><img src="https://graph.facebook.com/v2.10/{{ $user->socialAccount->provider_user_id }}/picture?type=large"><p>{{ $user->name }}</p></a></li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
