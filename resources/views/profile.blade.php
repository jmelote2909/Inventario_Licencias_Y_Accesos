<x-app-layout>
    <x-slot name="header">
        {{ __('Ajustes de Perfil') }}
    </x-slot>

    <div class="space-y-8">
        <div class="p-8 sm:p-10 bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] ring-1 ring-slate-200/60 sm:rounded-3xl">
            <div class="max-w-xl">
                <livewire:profile.update-profile-information-form />
            </div>
        </div>

        <div class="p-8 sm:p-10 bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] ring-1 ring-slate-200/60 sm:rounded-3xl">
            <div class="max-w-xl">
                <livewire:profile.update-password-form />
            </div>
        </div>

        <div class="p-8 sm:p-10 bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] ring-1 ring-slate-200/60 sm:rounded-3xl border-l-4 border-rose-500">
            <div class="max-w-xl">
                <livewire:profile.delete-user-form />
            </div>
        </div>
    </div>
</x-app-layout>
