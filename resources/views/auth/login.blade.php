<x-guest-layout >

    <x-slot name="title">
        Login | Neust Ticketing
    </x-slot>



<link rel="stylesheet" href="{{ asset('mistemplates/assets/css/login.css') }}">

<div class="auth">
    <div class="auth-card">

        <div class="auth-head">
         <div class="auth-logo">
            <img src="{{ asset('img/favicon.png') }}" alt="Logo">
        </div>
            <div class="auth-title">NEUST Ticketing System</div>
        </div>

        <div class="auth-body">

            <!-- Session Status -->
            <x-auth-session-status
                class="notice show"
                :status="session('status')"
            />

            <!-- Login Errors -->
            @if ($errors->any())
                <div class="notice show" id="loginNotice">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif

            <form method="POST"
                  action="{{ route('login') }}"
                  id="loginForm"
                  autocomplete="off">

                @csrf

                <!-- Email -->
                <div class="field">
                    <label for="email">Email</label>

                    <div class="input">
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="you@example.com"
                            required
                            autofocus
                            autocomplete="username"
                        >
                    </div>

                </div>

                <!-- Password -->
                <div class="field">
                    <label for="password">Password</label>

                    <div class="input">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            required
                            autocomplete="current-password"
                        >

                        <button
                            class="toggle-pass"
                            type="button"
                            id="togglePass">
                            SHOW
                        </button>
                    </div>

                    <x-input-error
                        :messages="$errors->get('password')"
                        class="mt-2"
                    />
                </div>

                <!-- Remember / Forgot Password -->
                <div class="row">

                    <label class="check">
                        <input
                            type="checkbox"
                            id="remember"
                            name="remember"
                        >
                        Remember me
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            Forgot password?
                        </a>
                    @endif

                </div>

                <!-- Submit -->
                <button class="btn-primary" type="submit">
                    Sign In
                </button>

            </form>

        </div>

        <div class="auth-footer">

            @if (Route::has('register'))
                Don't have an account?

                <a href="{{ route('register') }}">
                    Create one
                </a>
            @endif

        </div>

    </div>
</div>


<script>
    // Show / Hide Password
    const pass = document.getElementById('password');
    const btn = document.getElementById('togglePass');

    btn.addEventListener('click', () => {

        const isHidden = pass.type === 'password';

        pass.type = isHidden ? 'text' : 'password';

        btn.textContent = isHidden ? 'HIDE' : 'SHOW';

    });
</script>

</x-guest-layout>
