<x-visuals.navbar/>
<div class="p-4">
    <div class="grid grid-cols-6 gap-4">
        <div class="col-start-1 col-end-2">
            <x-visuals.recentWorkdays :workdays="$previousWorkdays"/>
        </div>
        <div class="col-start-2 col-end-6">
            @yield('page')
        </div>
        <div class="col-end-7 col-span-1">
            <x-visuals.recentWorkdays :workdays="$currentWorkdays"/>
        </div>
    </div>
</div>
