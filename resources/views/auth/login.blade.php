@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('login') }}"
          class="lg:w-1/2 w-3/4 mx-auto card py-12 px-16 rounded shadow"
    >
        @csrf

        <h1 class="text-2xl font-normal mb-10 text-center">Login</h1>

        <div class="field mb-6">
            <label class="label text-normal mb-2 block" for="email">Email Address</label>

            <div class="control">
                <input id="email"
                       type="email"
                       class="form-input bg-transparent border border-muted-light rounded p-2 text-xs w-full{{ $errors->has('email') ? ' is-invalid' : '' }}"
                       name="email"
                       placeholder="Enter your Email"
                       value="{{ old('email') }}"
                       required>
            </div>
        </div>

        <div class="field mb-6">
            <label class="label text-normal mb-2 block" for="password">Password</label>

            <div class="control">
                <input id="password"
                       type="password"
                       class="form-input bg-transparent border border-muted-light rounded p-2 text-xs w-full{{ $errors->has('password') ? ' is-invalid' : '' }}"
                       name="password"
                       placeholder="Enter your Password"
                       required>
            </div>
        </div>

        <div class="field mb-6">
            <div class="control">
                <input class="form-checkbox"
                       type="checkbox"
                       name="remember"
                       id="remember"
                        {{ old('remember') ? 'checked' : '' }}>

                <label class="text-normal" for="remember">
                    Remember Me
                </label>
            </div>
        </div>

        <div class="field mb-6">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="button-primary mr-2">
                    Login
                </button>

                @if (Route::has('password.request'))
                    <a class="text-default text-sm" href="{{ route('password.request') }}">
                        Forgot Your Password?
                    </a>
                @endif
            </div>
        </div>
    </form>
@endsection