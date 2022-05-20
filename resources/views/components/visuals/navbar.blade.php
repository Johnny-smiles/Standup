<div>
    <nav class="bg-background">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex-shrink-0 flex items-center">
                        <img
                            class="lg:block h-8 w-auto"
                            src="/images/zaengle.gif"
                            alt="Workflow"
                        >
                    </div>
                    <div class="sm:block sm:ml-6">
                        <div class="flex space-x-4">
                            <a
                                href="{{ route('home') }}"
                                class="text-gray-500 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-md font-medium"
                            >
                                Standups
                            </a>
                            <a
                                href="{{ route('users') }}"
                                class="text-gray-500 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-md font-medium"
                            >
                                Users
                            </a>
                        </div>
                    </div>
                </div>
                <div class="hidden sm:block sm:ml-6">
                    <x-actions.search-tasks/>
                </div>
                <div class="hidden sm:block sm:ml-6">
                    <x-actions.search-date/>
                </div>
                <div class="flex sm:ml-6">
                    <div
                        x-data="{dropdownProfile: false}"
                        @click.outside="dropdownProfile = false"
                    >
                        <button
                            @click="dropdownProfile = ! dropdownProfile"
                            class="flex text-sm rounded-full"
                        >
                            <span class="sr-only">Open user menu</span>
                            <img
                                class="h-10 w-10 rounded-full border-transparent border-2 hover:border-slate-300"
                                src="{{auth()->user()->avatar}}" alt=""
                            >
                        </button>
                        <div
                            x-show="dropdownProfile"
                            class="absolute right-0 py-2 mt-2 bg-gray-100 rounded-md shadow-xl w-44 z-10"
                        >
                            @if(!auth()->user()->github_username)
                                <x-actions.submenuLink
                                    route="{{config('services.github.base_auth_route')}}?client_id={{config('services.github.client_id')}}&scope=read:user&redirect_uri={{config('services.github.redirect')}}"
                                    linkText="Link with GitHub"
                                />
                            @else
                                <x-actions.submenuLink
                                    route="{{config('services.github.base_auth_route')}}?client_id={{config('services.github.client_id')}}&scope=read:user&redirect_uri={{config('services.github.redirect')}}"
                                    linkText="Update Link with GitHub"
                                />
                                <x-actions.submenuLink
                                    route="/oauth/github/deleted"
                                    linkText="Unlink GitHub"
                                />
                            @endif
                            <div>
                                <form
                                    id="logout-form"
                                    action="{{ route('logout') }}"
                                    method="POST"
                                >
                                    @csrf
                                    <button
                                        class="text-gray-500 hover:text-black px-4 py-2 text-sm"
                                        type="submit"
                                    >
                                        {{ __('Logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>
