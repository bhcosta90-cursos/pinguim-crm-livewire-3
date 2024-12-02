<x-layouts.app>
    <div class="mx-auto space-y-6">
        <x-card title="Profile Information" subtitle="Update your account's profile information and email address.">
            <livewire:profile.update-profile-information-form />
        </x-card>

        <x-card title="Update Password" subtitle="Ensure your account is using a long, random password to stay secure.">
            <livewire:profile.update-password-form />
        </x-card>

        <x-card title="Delete Account" subtitle="Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.">
            <livewire:profile.delete-user-form />
        </x-card>
    </div>
</x-layouts.app>
