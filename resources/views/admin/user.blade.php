@extends('admin.layouts.app')

@include('assets.jquery')
@include('assets.mdb')
@include('assets.page.userJS')

@section('path')
{{ __('messages.Admin') . ' / ' . __('messages.User')  }}
@endsection

@section('content')
<div class="header-action">
  <div class="leftbar">
    <h3 class="title-text">
      <i class="fa-regular fa-user"></i>
      <span>{{ __('messages.User') }}
    </h3>
    <div class="action-1">
      <a href="{{ route('admin.user.create') }}" type="button" class="btn btn-info disabled"><i class="fa-solid fa-plus"></i> Create</a>
      <a type="button" class="btn btn-danger" data-mdb-toggle="modal" data-mdb-target="#modal-confirm-bulkdelete"><i class="fa-solid fa-trash"></i> Bulk Delete</a>
      @include('admin.components.confirm', [
        'modalId' => 'modal-confirm-bulkdelete',
        'type' => 'confirm-danger',
        'title' => __('messages.ConfirmDeleteBulk'),
        'description' => __('messages.ConfirmDeleteBulkDescription', [ 'userIds' => '__USER_IDS__' ]),
        'onConfirm' => 'bulkDelete()'
      ])
    </div>
    <div class="action-2">
      {{--  --}}
    </div>
  </div>
</div>
<div class="table-wrapper">
  <table class="table">
    <thead>
      <tr>
        <th scope="col">
          <div class="form-check">
            <input id="user-checkboxes-select" onChange="selectAllFromPage()" class="form-check-input" type="checkbox" id="bulk-delete" />
          </div>
        </th>
        <th scope="col">{{ __('messages.RoleId') }}</th>
        <th scope="col">{{ __('messages.GoogleId') }}</th>
        <th scope="col">{{ __('messages.Email') }}</th>
        <th scope="col">{{ __('messages.Username') }}</th>
        <th scope="col">{{ __('messages.Name') }}</th>
        <th scope="col">{{ __('messages.Nickname') }}</th>
        <th scope="col">{{ __('messages.Avatar') }}</th>
        <th scope="col">{{ __('messages.Birthdate') }}</th>
        <th scope="col">{{ __('messages.Gender') }}</th>
        <th scope="col">{{ __('messages.ZipCode') }}</th>
        <th scope="col">{{ __('messages.Address') }}</th>
        <th scope="col">{{ __('messages.Telephone') }}</th>
        <th scope="col">{{ __('messages.EmailVerifiedAt') }}</th>
        <th scope="col">{{ __('messages.CreatedAt') }}</th>
        <th scope="col">{{ __('messages.UpdatedAt') }}</th>
        <th scope="col">{{ __('messages.DeletedAt') }}</th>
        <th scope="col">{{ __('messages.Action') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $index => $user)
      <tr>
        <td>
          <div class="form-check">
            <input class="user-checkbox form-check-input" onChange="addSelectedUsers(event)" value="{{ $user->getAttr('id') }}" data-user-id="{{ $user->getAttr('id') }}" type="checkbox" id="select-user" />
          </div>
        </td>
        <td>{{ $user->getAttr('role_id') }}</td>
        <td>{{ $user->getAttr('google_id') }}</td>
        <td>{{ $user->getAttr('email') }}</td>
        <td>{{ $user->getAttr('username') }}</td>
        <td>{{ $user->getAttr('name') }}</td>
        <td>{{ $user->getAttr('nick_name') }}</td>
        <td>{{ $user->getAttr('avatar') }}</td>
        <td>{{ $user->getAttr('birth_date') }}</td>
        <td>{{ $user->getAttr('gender') }}</td>
        <td>{{ $user->getAttr('zip_code') }}</td>
        <td>{{ $user->getAttr('address') }}</td>
        <td>{{ $user->getAttr('tel') }}</td>
        <td>{{ $user->getAttr('email_verified_at') }}</td>
        <td>{{ $user->getAttr('created_at') }}</td>
        <td>{{ $user->getAttr('updated_at') }}</td>
        <td>{{ $user->getAttr('deleted_at') }}</td>
        <td class="action">
          <a href="{{ route('admin.user.edit', [ 'user' => $user->getAttr('id') ]) }}" type="button" class="btn btn-info"><i class="fa-solid fa-pen-nib"></i></a> 
          <a type="button" class="btn btn-danger" data-mdb-toggle="modal" data-mdb-target="#modal-confirm-delete"><i class="fa-solid fa-trash"></i></a>
          @include('admin.components.confirm', [
            'modalId' => 'modal-confirm-delete',
            'type' => 'confirm-danger',
            'title' => __('messages.ConfirmDelete'),
            'description' => __('messages.ConfirmDeleteDescription'),
            'onConfirm' => "deleteUser($user->id)"
          ])
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  {{ $users->links() }}
</div>
@endsection


