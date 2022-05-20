<form
    method="post"
    action="{{ route('task.search') }}"
    enctype="application/x-www-form-urlencoded"
>
    @csrf
    <div class="inline-flex">
        <div class="flex-1 px-2">
            <div>
                <input
                    name="text"
                    type="text"
                    class="form-control"
                    id="searchid"
                    placeholder="Search Tasks"
                >
            </div>
            @error('text')
            <div class="alert alert-danger">{{$message}}</div>
            @enderror
        </div>
        <div class="flex-1">
            <button type="submit">Submit</button>
        </div>
    </div>
</form>
