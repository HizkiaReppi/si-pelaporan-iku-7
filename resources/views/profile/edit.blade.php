<x-dashboard-layout title="Profil Saya">
    <x-slot name="header">
        Profil Saya
    </x-slot>

    @include('profile.partials.update-profile-information-form-admin')

    @include('profile.partials.update-password-form')

    @include('profile.partials.delete-user-form')

</x-dashboard-layout>
