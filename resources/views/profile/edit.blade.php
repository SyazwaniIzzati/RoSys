<x-florist-layout>
    <div class="profile-page">
        <h1 class="page-title">Profile</h1>
        <p class="page-lead">Manage your account details, password and security.</p>

        <div class="profile-stack">
            <section class="profile-card">
                @include('profile.partials.update-profile-information-form')
            </section>

            <section class="profile-card">
                @include('profile.partials.update-password-form')
            </section>

            <section class="profile-card">
                @include('profile.partials.delete-user-form')
            </section>
        </div>
    </div>
</x-florist-layout>