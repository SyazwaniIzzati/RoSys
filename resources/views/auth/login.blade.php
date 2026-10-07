<x-login-layout>
    <div class="auth-login">

        {{-- Photo card --}}
        <div class="auth-visual">
            <img src="{{ asset('images/homepagephoto.jpg') }}" alt="Hand-tied peony bouquet">
            <div class="auth-visual-caption">
                <span>RoSys</span>
                <strong>Welcome back.</strong>
            </div>
        </div>

        {{-- Form --}}
        <section class="auth-form">
            <span class="eyebrow">Sign in</span>
            <h1 class="auth-title">Your atelier account.</h1>

            @if (session('status'))
                <p class="auth-status">{{ session('status') }}</p>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                    @error('email') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password">
                    @error('password') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="auth-row">
                    <label class="check">
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary btn-block">Sign in</button>
            </form>

            @if (Route::has('register'))
                <p class="auth-alt">New to RoSys? <a href="{{ route('register') }}">Create an account</a></p>
            @endif
        </section>
    </div>
</x-login-layout>