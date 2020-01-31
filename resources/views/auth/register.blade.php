@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('register') }}"
          class="lg:w-1/2 lg:mx-auto card py-12 px-16 rounded shadow"
    >
        @csrf

        <h1 class="text-2xl font-normal mb-10 text-center">Register</h1>

        <div class="field mb-6">
            <label class="label text-sm mb-2 block" for="name">Name</label>

            <div class="control">
                <input id="name"
                       type="text"
                       class="form-input bg-transparent border border-muted-light rounded p-2 text-xs w-full{{ $errors->has('name') ? ' is-invalid' : '' }}"
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="Enter Your name"
                       required
                       autofocus>
            </div>
        </div>

        <div class="field mb-6">
            <label class="label text-sm mb-2 block" for="email">Email Address</label>

            <div class="control">
                <input id="email"
                       type="email"
                       class="form-input bg-transparent border border-muted-light rounded p-2 text-xs w-full{{ $errors->has('email') ? ' is-invalid' : '' }}"
                       name="email"
                       placeholder="Enter your email"
                       value="{{ old('email') }}"
                       required>
            </div>
        </div>

        <div class="field mb-6">
            <label class="label text-sm mb-2 block" for="password">Password</label>

            <div class="control">
                <input id="password"
                       type="password"
                       class="form-input bg-transparent border border-muted-light rounded p-2 text-xs w-full{{ $errors->has('password') ? ' is-invalid' : '' }}"
                       name="password"
                       placeholder="Enter your password"
                       required>
            </div>
        </div>

        <div class="field mb-6">
            <label class="label text-sm mb-2 block" for="password-confirmation">Confirm Password</label>

            <div class="control">
                <input id="password-confirmation"
                       type="password"
                       class="form-input bg-transparent border border-muted-light rounded p-2 text-xs w-full"
                       name="password_confirmation"
                       placeholder="password confirmation"
                       required>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button type="submit" class="button-primary">Register</button>
            </div>
        </div>
    </form>
@endsection