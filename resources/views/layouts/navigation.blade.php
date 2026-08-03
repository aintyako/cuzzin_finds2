<nav x-data="{ open: false }" class="bg-[#1e293b] border-b border-gray-800 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('shop.index') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-indigo-500" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    {{-- ADMIN ONLY: Show "Dashboard" and "Products" --}}
                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-300 hover:text-white border-indigo-500">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.products.create')" :active="request()->routeIs('admin.products.create')" class="text-gray-300 hover:text-white border-indigo-500">
                            {{ __('Products') }}
                        </x-nav-link>
                    @endauth

                    {{-- CUSTOMER VIEW --}}
                    <x-nav-link :href="route('shop.catalog')" :active="request()->routeIs('shop.catalog')" class="text-gray-300 hover:text-white border-indigo-500">
                        {{ __('Shop') }}
                    </x-nav-link>

                    <x-nav-link :href="route('product.clothes')" :active="request()->routeIs('product.clothes')" class="text-gray-300 hover:text-white border-indigo-500">
                        {{ __('Clothes') }}
                    </x-nav-link>

                    <x-nav-link :href="route('product.skincare')" :active="request()->routeIs('product.skincare')" class="text-gray-300 hover:text-white border-indigo-500">
                        {{ __('Skincare') }}
                    </x-nav-link>

                    {{-- Cart & Wishlist --}}
                    @if(!Auth::check() || Auth::user()->email !== 'admin@example.com')
                        <x-nav-link :href="route('wishlist.index')" :active="request()->routeIs('wishlist.index')" class="text-gray-300 hover:text-white border-indigo-500">
                            {{ __('Wishlist') }} ❤️
                            @if(session('wishlist') && count(session('wishlist')) > 0)
                                <span class="ms-1 px-2 py-0.5 text-[10px] bg-rose-600 text-white rounded-full font-black">
                                    {{ count(session('wishlist')) }}
                                </span>
                            @endif
                        </x-nav-link>

                        <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')" class="text-gray-300 hover:text-white border-indigo-500">
                            {{ __('Cart') }} 🛒
                            @if(session('cart') && count(session('cart')) > 0)
                                <span class="ms-1 px-2 py-0.5 text-[10px] bg-indigo-600 text-white rounded-full font-black">
                                    {{ count(session('cart')) }}
                                </span>
                            @endif
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-bold rounded-xl text-gray-300 bg-[#0f172a] hover:text-white hover:bg-gray-800 focus:outline-none transition ease-in-out duration-150 border border-gray-700">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="bg-[#1e293b] border border-gray-700 rounded-lg shadow-xl overflow-hidden">
                                <x-dropdown-link :href="route('profile.edit')" class="text-gray-300 hover:bg-indigo-600 hover:text-white">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('orders.index')" class="text-gray-300 hover:bg-indigo-600 hover:text-white">
                                    {{ __('My Orders') }}
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            class="text-gray-300 hover:bg-rose-600 hover:text-white"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-xs font-black uppercase tracking-widest text-gray-400 hover:text-white transition">Log in</a>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-800 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#0f172a] border-t border-gray-800">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.index')" class="text-gray-300">
                {{ __('Home') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('shop.catalog')" :active="request()->routeIs('shop.catalog')" class="text-gray-300">
                {{ __('Shop') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('product.clothes')" :active="request()->routeIs('product.clothes')" class="text-gray-300">
                {{ __('Clothes') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('product.skincare')" :active="request()->routeIs('product.skincare')" class="text-gray-300">
                {{ __('Skincare') }}
            </x-responsive-nav-link>

            @if(!Auth::check() || Auth::user()->email !== 'admin@example.com')
                <x-responsive-nav-link :href="route('wishlist.index')" :active="request()->routeIs('wishlist.index')" class="text-gray-300">
                    {{ __('Wishlist') }} ❤️
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')" class="text-gray-300">
                    {{ __('Cart') }} 🛒
                </x-responsive-nav-link>
            @endif
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-gray-800">
                <div class="px-4">
                    <div class="font-bold text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-400">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('orders.index')" class="text-gray-400">
                        {{ __('My Orders') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" class="text-rose-400"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-gray-800">
                <x-responsive-nav-link :href="route('login')" class="text-gray-300">
                    {{ __('Log in') }}
                </x-responsive-nav-link>
            </div>
        @endauth
    </div>
</nav>