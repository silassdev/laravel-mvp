@extends('layouts.app')

@section('title','Choose a new password')

@section('content')
  <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Choose a new password</h2>

    @if($errors->any())
      <div class="mb-4 p-3 bg-red-50 text-red-700">
        <ul class="list-disc pl-5">
          @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
      @csrf

      <input type="hidden" name="token" value="{{ $token }}" />
      <div class="mb-3">
        <label class="block text-sm">Email</label>
        <input name="email" value="{{ old('email', $email) }}" required type="email" class="w-full border p-2 rounded" />
      </div>

      <div class="mb-3">
        <label class="block text-sm">New password</label>
        <input name="password" required type="password" class="w-full border p-2 rounded" />
      </div>

      <div class="mb-4">
        <label class="block text-sm">Confirm password</label>
        <input name="password_confirmation" required type="password" class="w-full border p-2 rounded" />
      </div>

      <div>
        <button type="submit" class="px-4 py-2 bg-slate-900 text-white rounded">Reset password</button>
      </div>
    </form>
  </div>
@endsection
