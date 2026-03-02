@extends('admin.layouts.app')
@include('assets.jquery')
@include('assets.mdb')
@include('assets.datepicker')
@include('assets.page.userJS')

@section('path')
{{ __('messages.Admin') . ' / ' . __('messages.User') . ' / ' . $formType }}
@endsection

@section('content')
  <div class="leftbar">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="title">
      <i class="fa-regular fa-user"></i>
      <h4 class="title-text">{{ $title }}</h4>
    </div>
    <div class="header-action">
      <div class="action-1"></div>
      <div class="action-2">
        <a onClick="clearFormData()" type="button" class="btn btn-default">
          {{ __('messages.Revert') }}
        </a>
        <a onClick="submitForm()"  type="button" class="btn btn-primary">
          {{ __('messages.Submit') }}</span>
        </a>
      </div>
    </div>
  </div>
  <form id="form" method="POST" action="{{ $routeURL }}" class="form-block">
    @csrf
    <div class="input-block">
      <div class="form-outline">
      <input type="text" value="{{ old('firstname', !empty($user) ? $user->getAttr('firstname', '') : '') }}" id="firstname" name="firstname" class="form-control" />
        <label class="form-label" for="firstname">{{ __('messages.FirstName')}}</label>
      </div>
      <div class="form-outline">
        <input type="text" value="{{ old('middlename', !empty($user) ? $user->getAttr('middlename', '') : '') }}" id="middlename" name="middlename" class="form-control" />
        <label class="form-label" for="middlename">{{ __('messages.MiddleName') }}</label>
      </div>
      <div class="form-outline">
        <input type="text" value="{{ old('lastname', !empty($user) ? $user->getAttr('lastname', '') : '') }}" id="lastname" name="lastname" class="form-control" />
        <label class="form-label" for="lastname">{{ __('messages.LastName') }}</label>
      </div>
    </div>
    <div class="input-inline">
      <div class="form-outline">
        <input type="text" value="{{ old('username', !empty($user) ? $user->getAttr('username', '') : '') }}" id="username" name="username" class="form-control" />
        <label class="form-label" for="username">{{ __('messages.Username') }}</label>
      </div>
      <div class="form-outline">
        <input type="text" value="{{ old('nick_name', !empty($user) ? $user->getAttr('nick_name', '') : '') }}" id="nickname" name="nick_name" class="form-control" />
        <label class="form-label" for="nickname">{{ __('messages.Nickname') }}</label>
      </div>
    </div>
    <div class="input-inline">
      <select name="gender" class="form-select">
        <option selected disabled>{{ __('messages.SelectGender') }}</option>
        <option value="{{ Globals::mUser()::FEMALE }}" {{ $user->getAttr('gender') == Globals::mUser()::FEMALE ? 'selected' : '' }}>{{ __('messages.Male') }}</option>
        <option value="{{ Globals::mUser()::MALE }}" {{ $user->getAttr('gender') == Globals::mUser()::MALE ? 'selected' : '' }}>{{ __('messages.Female') }}</option>
      </select>
    </div>
    <div class="input-inline">
      <div>
        <input onChange="storeTmp(event)" type="file" name="avatarImg" class="form-control-file" fileType="image"/>
        <input type="hidden" id="avatar" name="avatar" value="{{ $user->getAttr('avatar') }}" />
        <span>
          <i id="avatar-remove-btn" onClick="deleteAvatar()" role="button">
            <span class="fa fa-times text-danger" aria-hidden="true"></span>
          </i>
          <br/>
          <a id="avatar-view-link" class="avatar-view-link" href="{{ $user->getAttr('avatar') }}" class="text-ellipsis text-danger" target="_blank">
            {{ $user->getAttr('avatar') }}
          </a>
        </span>
      </div>
      <div class="d-flex">
        <input type="text" id="birthdate" class="form-control" name="birth_date" value="{{ $user->getAttr('birth_date') }}"/>
        <label id="birthdate-btn" role="button" class="input-group-text datepicker-icon"><i class="fas fa-calendar-alt"></i></label>
      </div>
    </div>
    <div class="input-inline">
      <div class="form-outline">
        <input type="tel" id="tel" class="form-control" name="tel" value="{{ old('tel', !empty($user) ? $user->getAttr('tel', '') : '') }}" />
        <label class="form-label" for="tel">{{ __('messages.Telephone') }}</label>
      </div>
      <div class="form-outline">
        <input type="text" id="ZipCode" name="zip_code" class="form-control" value="{{ old('zip_code', !empty($user) ? $user->getAttr('zip_code', '') : '') }}"/>
        <label class="form-label" for="nickname">{{ __('messages.ZipCode') }}</label>
      </div>
    </div>
    <div class="input-block">
      <div class="form-outline">
        <input type="text" id="address" name="address" class="form-control" value="{{ old('address', !empty($user) ? $user->getAttr('address', '') : '') }}" />
        <label class="form-label" for="address">{{ __('messages.Address') }}</label>
      </div>
    @if($formType != __('messages.Edit'))
    <div class="input-block">
      <div class="form-outline">
        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', !empty($user) ? $user->getAttr('email', '') : '') }}" />
        <label class="form-label" for="email">{{ __('messages.Email') }}</label>
      </div>
    </div>
    @endif
    {{-- <div class="input-block">
      <div class="form-outline">
        <input type="password" id="password" name="password" class="form-control" value="{{ old('email', !empty($user) ? $user->getAttr('email', '') : '') }}" />
        <label class="form-label" for="password">{{ __('messages.Password') }}</label>
      </div>
    </div> --}}
    {{-- <div class="input-block">
      <div class="form-outline">
        <input type="password" id="confirm-password" name="confirmPassword" class="form-control" />
        <label class="form-label" for="confirm-password">{{ __('messages.ConfirmPassword') }}</label>
      </div>
    </div> --}}
  </form>
@endsection

