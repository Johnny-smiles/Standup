<div class="flex flex-col flex-shrink-0 w-full">
    @foreach($workdays as $workday)
        <div class="mx-auto my-2 p-2 sm:px-2 lg:px-3 rounded-lg border border-b-0 bg-gray-100">
            <a href="{{ route('workday.show', [$workday]) }}">
                <h3 class="py-2">{{$workday->created_at->translatedFormat('l j')}}</h3>
                <div>
                    @foreach( $workday->tasks as $task)
                        <div class="py-1 px-2">{{$task->text}}</div>
                    @endforeach
                </div>
            </a>
        </div>
    @endforeach
</div>
