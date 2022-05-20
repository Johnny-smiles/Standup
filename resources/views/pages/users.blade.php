@extends('layouts.app')

@section('page')
    <div >
        @foreach($users as $user)
            <div class="rounded-lg border border-b-0 bg-gray-100 p-2 m-2">
                <p class="capitalize">Status: {{ $user['status'] }}</p>
                <p class="capitalize">Name: {{ $user['name'] }}</p>
                <p class="capitalize">Email: {{ $user['email'] }}</p>
            </div>
        @endforeach
    </div>
@endsection
