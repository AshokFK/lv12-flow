<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                    <flux:navlist.item icon="puzzle-piece" :href="route('list.header')" :current="request()->routeIs('list.header')" wire:navigate>{{ __('Flowchart') }}</flux:navlist.item>
                    <flux:navlist.item icon="puzzle-piece" :href="route('list.masalah')" :current="request()->routeIs('list.masalah')" wire:navigate>{{ __('Masalah') }}</flux:navlist.item>
                </flux:navlist.group>
                <flux:navlist.group :heading="__('Master data')" class="grid">
                    <flux:navlist.item icon="puzzle-piece" :href="route('list.komponen')" :current="request()->routeIs('list.komponen')" wire:navigate>{{ __('Komponen') }}</flux:navlist.item>
                    <flux:navlist.item icon="puzzle-piece" :href="route('list.proses')" :current="request()->routeIs('list.proses')" wire:navigate>{{ __('Proses') }}</flux:navlist.item>
                    <flux:navlist.item icon="puzzle-piece" :href="route('list.qc')" :current="request()->routeIs('list.qc')" wire:navigate>{{ __('QC') }}</flux:navlist.item>
                    <flux:navlist.item icon="puzzle-piece" :href="route('list.lokasi')" :current="request()->routeIs('list.lokasi')" wire:navigate>{{ __('Lokasi') }}</flux:navlist.item>
                </flux:navlist.group>
                <flux:navlist.group :heading="__('Access Managements')" class="grid">
                    <flux:navlist.item icon="puzzle-piece" :href="route('list.role.permission')" :current="request()->routeIs('list.role.permission')" wire:navigate>{{ __('Roles & Permissions') }}</flux:navlist.item>
                    <flux:navlist.item icon="puzzle-piece" :href="route('list.user')" :current="request()->routeIs('list.user')" wire:navigate>{{ __('Users') }}</flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <flux:navlist variant="outline">
                {{-- add button to toggle dark/light mode --}}
                <flux:navlist.item icon="moon" x-on:click="$flux.appearance = $flux.appearance === 'dark' ? 'light' : 'dark'" class="cursor-pointer">
                    <span x-text="$flux.appearance === 'dark' ? 'Light Mode' : 'Dark Mode'"></span>
                </flux:navlist.item>
                
                @if(auth()->user()->roles->count() > 0)
                <flux:menu.item icon="shield-check" title="login roles">
                    @foreach(auth()->user()->roles as $role)
                        <flux:badge class="mx-0.5 text-xs" size="sm" color="blue">
                            {{ $role->name }}
                        </flux:badge>
                    @endforeach
                </flux:menu.item>
                @endif
            </flux:navlist>

            <!-- Desktop User Menu -->
            <flux:dropdown position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                    @if(auth()->user()->roles)
                                    <span title="login roles">
                                        @foreach(auth()->user()->roles as $role)
                                            <flux:badge class="mx-0.5 text-xs" size="sm" color="blue">
                                                {{ $role->name }}
                                            </flux:badge>
                                        @endforeach
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        <x-swal-toast />
        
        @fluxScripts
    </body>
</html>
