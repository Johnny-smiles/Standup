<div
    x-data={show:false}
    class="p-2 md:w-1/2 lg:w-1/4"
>
    <div
        @click="show=!show"
        class="flex rounded-lg border border-b-0 bg-gray-100 p-2"
        id="headingOne"
    >
        <h1 class="py-2 mx-auto">
            {{$status}}
        </h1>
    </div>
    <div
        x-show="show"
        class="px-2 py-1"
    >
        <div class="flex flex-col flex-shrink-0 w-full px-2 mb-4">
            @isset($tasks)
                @foreach($tasks as $task)
                    <x-cards.taskCard
                        statusShow="hide"
                        :task=$task
                    />
                @endforeach
            @endisset
        </div>
    </div>
</div>
