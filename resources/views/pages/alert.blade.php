@extends('layouts.app')

@section('page')
    <x-cards.card spacing="relative flex items-top min-h-screen sm:items-center py-4 sm:pt-0">
        <x-visuals.alert
            :alert="$alert"
            :action="$action"
        />
        <a
            href="{{ route('home') }}"
            class="btn btn-xs mx-auto my-2 rounded shadow-xl text-white block px-4 py-2 text-sm bg-background"
        >
            Return Home
        </a>
    </x-cards.card>
@endsection
