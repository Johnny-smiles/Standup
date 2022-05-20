<div
    x-data="{ show: true }"
    x-show="show"
    x-init="setTimeout(() => show = false, 3000)"
    x-transition.duration.500ms
>
    <div
        class="border-l-4 p-4"
        role="alert">
        <p class="font-bold">{{$alert}} {{$action}}</p>
        <p>Your {{$alert}} was just {{$action}}.</p>
    </div>
</div>
