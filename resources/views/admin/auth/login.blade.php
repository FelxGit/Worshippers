@extends('admin.auth.layouts.app')
@include('assets.jquery')
@include('assets.mdb')
@include('assets.datepicker')

@section('content')
<form id="auth-form" method="POST" action="{{ route('admin.login') }}" class="form-block">
  <h3>{{ __('messages.SignIn') }}</h3>
  @method('POST')
  @csrf
  <div>
    <div class="form-outline">
      <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $remember ? $remember->email : '') }}" />
      <label class="form-label" for="email">Email</label>
    </div>
    @error('email')
        <span style="color: red;">{{ $message }}</span>
    @enderror
  </div>
  <div>
    <div class="form-outline">
      <input type="password" id="typePassword" name="password" class="form-control" value="{{ old('password', $remember ? $remember->password : '') }}"/>
      <label class="form-label" for="typePassword">Password input</label>
    </div>
    @error('password')
        <span style="color: red;">{{ $message }}</span>
    @enderror
  </div>
  <div>
    <div class="form-check">
      <input class="form-check-input" name="remember" type="checkbox" id="rememberMe" {{ old('remember', $remember ? $remember->password : '') ? 'checked' : '' }}/>
      <label class="form-check-label" for="rememberMe">Remember me</label>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
  @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
</form>
@endsection