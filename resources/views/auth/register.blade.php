<x-guest-layout>

<x-slot name="title">
    Register | NEUST Ticketing
</x-slot>

<link rel="stylesheet" href="{{ asset('mistemplates/assets/css/login.css') }}">

<div class="auth">
    <div class="auth-card">

        <!-- Header -->
        <div class="auth-head">
            <div class="auth-logo">
                <img src="{{ asset('img/favicon.png') }}" alt="Logo">
            </div>

            <div class="auth-title">NEUST Ticketing System</div>
            <div class="auth-sub">Create your account</div>
        </div>


        <div class="auth-body">

            <!-- Registration Errors -->
        {{--     @if ($errors->any())
                <div class="notice show" id="registerNotice">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
 --}}

            <form method="POST"
                  action="{{ route('register') }}"
                  id="registerForm"
                  autocomplete="off">

                @csrf


                <!-- Name -->
                <div class="field">

                    <label for="name">Name</label>

                    <div class="input">
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Enter your full name"
                            required
                            autofocus
                            autocomplete="name"
                        >
                    </div>

                    <x-input-error
                        :messages="$errors->get('name')"
                        class="mt-2"
                    />

                </div>


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
                            autocomplete="username"
                        >
                    </div>

                    <x-input-error
                        :messages="$errors->get('email')"
                        class="mt-2"
                    />

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
                            autocomplete="new-password"
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


                <!-- Confirm Password -->
                <div class="field">

                    <label for="password_confirmation">
                        Confirm Password
                    </label>

                    <div class="input">

                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            placeholder="••••••••"
                            required
                            autocomplete="new-password"
                        >

                        <button
                            class="toggle-pass"
                            type="button"
                            id="toggleConfirmPass">
                            SHOW
                        </button>

                    </div>

                    <x-input-error
                        :messages="$errors->get('password_confirmation')"
                        class="mt-2"
                    />

                </div>


                <!-- Register Button -->
                <button class="btn-primary" type="submit">
                    Create Account
                </button>

            </form>

        </div>


        <!-- Login Link -->
        <div class="auth-footer">

            Already have an account?

            <a href="{{ route('login') }}">
                Sign In
            </a>

        </div>

    </div>
</div>


<script>
    // Password Toggle
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('password_confirmation');

    const togglePass = document.getElementById('togglePass');
    const toggleConfirmPass = document.getElementById('toggleConfirmPass');


    // Toggle Password
    togglePass.addEventListener('click', () => {

        const isHidden = password.type === 'password';

        password.type = isHidden ? 'text' : 'password';

        togglePass.textContent = isHidden ? 'HIDE' : 'SHOW';

    });


    // Toggle Confirm Password
    toggleConfirmPass.addEventListener('click', () => {

        const isHidden = confirmPassword.type === 'password';

        confirmPassword.type = isHidden ? 'text' : 'password';

        toggleConfirmPass.textContent = isHidden ? 'HIDE' : 'SHOW';

    });
</script>

</x-guest-layout>
