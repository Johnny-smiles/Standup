<form
    method="post"
    action="{{ route('workday.search') }}"
    enctype="application/x-www-form-urlencoded"
>
    @csrf
    <div class="inline-flex">
        <div class="flex-1 px-2">
            <div>
                <input
                    type="date"
                    name="date"
                    required
                    pattern="/d{2}-/d{2}-/d{4}"
                >
            </div>
        </div>
        <div class="flex-1">
            <button type="submit">Submit</button>
        </div>
    </div>
</form>
