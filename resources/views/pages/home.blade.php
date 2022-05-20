@extends('layouts.app')

@section('page')
    <div class="flex flex-shrink-0 w-full">
        <x-cards.statusCard
            status="Completed"
            :tasks=$completedTasks
        />
        <x-cards.statusCard
            status="Blocked"
            :tasks=$blockedTasks
        />
        <x-cards.statusCard
            status="In Progress"
            :tasks=$inProgressTasks
        />
        <x-cards.statusCard
            status="Deleted"
            :tasks=$deletedTasks
        />
    </div>
    @isset($alert)
        <x-visuals.alert
            :alert="$alert"
            :action="$action"
        />
    @endisset
@endsection
