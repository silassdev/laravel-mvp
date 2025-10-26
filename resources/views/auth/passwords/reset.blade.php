@extends('layouts.app')
@section('title','Choose a new password')
@section('content')
  <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Choose a new password</h2>

    @if($errors->any())
      <div class="mb-4 text-red-600">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}" />
      <label class="block text-sm mb-1">Email</label>
      <input name="email" value="{{ old('email', $email) }}" required type="email" placeholder="you@example.com" class="w-full border p-2 rounded mb-3" />

      <label class="block text-sm mb-1">New password</label>
      <input name="password" required type="password" placeholder="At least 6 characters" class="w-full border p-2 rounded mb-3" />

      <label class="block text-sm mb-1">Confirm password</label>
      <input name="password_confirmation" required type="password" placeholder="Repeat password" class="w-full border p-2 rounded mb-4" />

      <button type="submit" class="px-4 py-2 bg-slate-900 text-white rounded">Reset password</button>
    </form>
  </div>
@endsection
