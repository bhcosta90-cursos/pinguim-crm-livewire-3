<div class="relative" x-data="{show: false}" @click.away="show = false">
    <button @click="show = !show" type="button" class="-m-1.5 flex items-center p-1.5" id="user-menu-button" aria-expanded="false"
            aria-haspopup="true">
        <span class="sr-only">Open user menu</span>
        <img class="size-8 rounded-full bg-gray-50"
             src="{{ auth()->user()->photo }}"
             alt="">
        <span class="hidden lg:flex lg:items-center">
        <span class="ml-4 text-sm/6 font-semibold text-gray-900" aria-hidden="true">{{ auth()->user()->name }}</span>
        <svg class="ml-2 size-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
             data-slot="icon">
          <path fill-rule="evenodd"
                d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                clip-rule="evenodd"/>
        </svg>
      </span>
    </button>

    <div x-cloak x-show="show"
         class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none"
         role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
        <a href="#" class="block px-3 py-1 text-sm/6 text-gray-900" role="menuitem" tabindex="-1" id="user-menu-item-0">Your
            profile</a>
        <form method="post" action="{{ route('logout') }}">
            @csrf
            <button class="block px-3 py-1 text-sm/6 text-gray-900" role="menuitem" tabindex="-1" id="user-menu-item-1">
                @lang('Sign out')
            </button>
        </form>
    </div>
</div>
