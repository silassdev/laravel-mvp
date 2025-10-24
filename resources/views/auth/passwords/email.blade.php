@extends('layouts.app')

@section('title','Reset password')

@section('content')
  <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Reset your password</h2>

    @if(session('status'))
      <div class="mb-4 p-3 bg-green-50 text-green-700">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
      @csrf

      <div class="mb-3">
        <label class="block text-sm">Email</label>
        <input name="email" value="{{ old('email') }}" required type="email" class="w-full border p-2 rounded" />
        @error('email') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
      </div>

      <div>
        <button type="submit" class="px-4 py-2 bg-slate-900 text-white rounded">Send reset link</button>
      </div>
    </form>
  </div>
@endsection
