<x-login-layout>
    <section class="auth-form auth-center auth-center--wide">
        <span class="eyebrow">Create account</span>
        <h1 class="auth-title">Begin with a bloom.</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="field-grid">

                <div class="field field--full">
                    <label for="name">Full name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                    @error('name') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
                    @error('email') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="phone">Phone</label>
                    <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required autocomplete="tel">
                    @error('phone') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field field--full">
                    <label for="address">Address</label>
                    <input id="address" type="text" name="address" value="{{ old('address') }}" required autocomplete="street-address">
                    @error('address') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password">
                    @error('password') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="password_confirmation">Confirm password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
                    @error('password_confirmation') <p class="field-error">{{ $message }}</p> @enderror
                </div>

            </div>

            <button type="submit" class="btn btn-primary btn-block">Create account</button>
        </form>

        <p class="auth-alt">Already with us? <a href="{{ route('login') }}">Sign in</a></p>
    </section>
</x-login-layout>