@extends('layouts.main')
@section('content')

<!-- ... -->

<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <form action="{{ route('admin.users.update', $user[0]->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- <div class="form-group">
                    <label for="name">{{ __('users.Name') }}</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $user[0]->name) }}" required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> --}}

                <div class="form-group">
                    <label for="username">{{ __('users.Username') }}</label>
                    <input type="text" id="username" name="username"
                        class="form-control @error('username') is-invalid @enderror"
                        value="{{ old('username', $user[0]->username) }}" unique>
                    @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- <div class="form-group">
                    <label for="user_code">{{ __('users.UserCode') }}</label>
                    <input type="text" id="user_code" name="user_code"
                        class="form-control @error('user_code') is-invalid @enderror"
                        value="{{ old('user_code', $user[0]->user_code) }}" unique>
                    @error('user_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> -->

                <div class="form-group">
                    <label for="email">{{ __('users.Email') }}</label>
                    <input type="email" id="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $user[0]->email) }}" required>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="first_name">{{ __('users.FirstName') }}</label>
                    <input type="text" id="first_name" name="first_name" class="form-control"
                        value="{{ old('first_name', $user[0]->first_name) }}">
                </div>

                <div class="form-group">
                    <label for="last_name">{{ __('users.LastName') }}</label>
                    <input type="text" id="last_name" name="last_name" class="form-control"
                        value="{{ old('last_name', $user[0]->last_name) }}">
                </div>

                <div class="form-group">
                    <label for="role">{{ __('users.Level') }}</label>
                    <select id="role" name="role" class="form-control select2" data-toggle="select2">
                        <option value="admin" {{ old('role', $user[0]->role) == 'admin' ? 'selected' : '' }}>
                            {{ __('users.Admin') }}</option>
                        <option value="operator" {{ old('role', $user[0]->role) == 'operator' ? 'selected' : '' }}>
                            {{ __('users.Operator') }}</option>
                        <option value="borrower" {{ old('role', $user[0]->role) == 'borrower' ? 'selected' : '' }}>
                            {{ __('users.Borrower') }}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="gender">{{ __('users.Gender') }}</label>
                    <select id="gender" name="gender" class="form-control select2" data-toggle="select2">
                        <option value="laki-laki" {{ old('gender', $user[0]->gender) == 'laki-laki' ? 'selected' : '' }}>
                            {{ __('users.Male') }}</option>
                        <option value="perempuan" {{ old('gender', $user[0]->gender) == 'perempuan' ? 'selected' : '' }}>
                            {{ __('users.Female') }}</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">{{ __('users.Save') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection
