<div
    x-show="editModal"
    class="absolute inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50"
>
    <div
        @click.away="editModal = false"
        class="max-w-sm p-6 bg-white"
    >
        <div class="bg-gray-100 shadow-xl sm:rounded-lg p-4 flex flex-col">
            <div class="flex">
                <h3 class="mx-auto text-2xl capitalize">Edit Task</h3>
            </div>
            <div class="mt-4">
                <form
                    method="post"
                    action="{{ route('task.update', [$task]) }}"
                    enctype="application/x-www-form-urlencoded"
                >
                    @csrf
                    <fieldset class="flex flex-col">
                        <div class="flex flex-row">
                            <div class="mx-2 px-2">Task:</div>
                            <div>
                                <div>
                                    <input
                                        name="text"
                                        type="text"
                                        class="form-control"
                                        id="taskId"
                                        value="{{$task->text}}"
                                    >
                                </div>
                                @error('text')
                                <div class="alert alert-danger">{{ $task }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mx-auto p-2">
                            <select
                                name="status"
                                id="status"
                            >
                                <option
                                    value=""
                                    disabled selected
                                >
                                    Status
                                </option>
                                <option value="completed">Completed</option>
                                <option value="blocked">Blocked</option>
                                <option value="in_progress">In Progress</option>
                                <option value="delete">Deleted</option>
                            </select>
                        </div>
                        <div class="flex p-2">
                            <button
                                class="mx-auto flex-grow px-6 py-2 text-sm text-white rounded shadow-xl bg-background"
                                type="submit"
                            >
                                Submit
                            </button>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div
                @click="editModal = false"
                class="flex p-2"
            >
                <button class="flex-grow px-6 py-2 text-sm text-white rounded shadow-xl bg-blue-100">Cancel</button>
            </div>
            <x-actions.delete-modal
                class="task"
                :model="$task"
            />
        </div>
    </div>
</div>
