<div class="my-2 p-2 rounded-lg border border-b-0 bg-gray-100">
    <div
        x-data="{editModal: false}"
        @click="editModal = true"
        class="flex justify-between"
    >
        <span class="flex-1 text-center py-2">{{$task->text}}</span>
        @isset($status)
            <span class="flex-1 text-center p-2">{{$status}}</span>
        @endisset
        @isset($time)
            <span class="flex-1 text-center p-2">Minutes: {{$time}}</span>
        @endisset
        <x-actions.edit-task
            class="task"
            :task="$task"
        />
    </div>
</div>
