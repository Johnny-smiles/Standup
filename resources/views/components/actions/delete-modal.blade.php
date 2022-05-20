<div
    x-data="{modal:false}"
    class="flex p-2"
>
    <button
        @click="modal=true"
        class="flex-grow p-2 text-sm text-white rounded shadow-xl bg-red-600"
        type="button"
    >
        Delete
    </button>
    <div
        x-show="modal"
        class="absolute inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50"
    >
        <div
            @click.away="modal = false"
            class="max-w-sm p-6 bg-white"
        >
            <div class="flex flex-col bg-gray-100 shadow-xl sm:rounded-lg p-4">
                <div class="mx-auto">
                    <h3 class="text-2xl capitalize">Delete {{$class}}</h3>
                </div>
                <div class="p-4">
                    <p class="mx-4 text-sm">
                        Are you sure you want to delete {{$class}}?
                    </p>
                </div>
                <button
                    @click="modal = false"
                    class="mx-auto my-2 rounded shadow-xl text-white block px-4 py-2 text-sm bg-blue-100"
                >
                    Cancel
                </button>
                <form
                    id="delete-form"
                    class="mx-auto"
                    action="{{ route($class.'.delete', [$class=>$model]) }}"
                    method="post"
                >
                    @csrf
                    <button
                        class="my-2 rounded shadow-xl text-gray-700 block px-4 py-2 text-sm bg-red-600"
                        type="submit"
                    >
                        {{ __('Delete') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
