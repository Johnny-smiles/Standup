@extends('layouts.app')

@section('page')
    <div class="p-4 w-full min-w-min">
        <div
            class="flex flex-row rounded-md border border-b-0 bg-gray-100 px-10 py-6 "
            id="headingOne"
        >
            <h1 class="mx-auto self-center text-xl">
                {{$workday->created_at->translatedFormat('l j')}}
            </h1>
            <x-actions.delete-modal
                class="workday"
                :model="$workday"
            />
        </div>
        <div class="px-2 py-1">
            <div class="px-2 mb-4">
                @foreach($workday->tasks as $task)
                    <x-cards.taskCard
                        statusShow="show"
                        :task=$task
                    />
                @endforeach
            </div>
        </div>
    </div>
    @isset($alert)
        <x-visuals.alert
            :alert="$alert"
            :action="$action"
        />
    @endisset
@endsection
