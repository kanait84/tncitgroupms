@extends('layouts.app')
<style>
    .dropdown-menu.dropdown-menu-right.show, a.dropdown-item {
        background: #2F323A!important;
    }
</style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add Employee') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Type') }}</label>
                            <div class="col-md-6">
                                <select id="type" type="text" class="form-control @error('type') is-invalid @enderror"
                                        name="type" value="{{ old('type') }}" required autocomplete="type" autofocus>
                                    <option> Select Account Type</option>
                                    <option value="admin">Administrator</option>
                                    <option value="topmanagement">Top Management</option>
                                    <option value="management">Management</option>
                                    <option value="submanagement">Sub Management</option>
                                    <option value="employee">Employee</option>
                                </select>


                                @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="department" class="col-md-4 col-form-label text-md-right">{{ __('Department') }}</label>

                            <div class="col-md-6">
                                <select id="d_id" type="text" class="form-control @error('department') is-invalid @enderror" name="d_id" value="{{ old('d_id') }}" required autocomplete="d_id" autofocus>
                                    <option disabled=""> Select Department</option>

                                    @forelse($departments as $department)
                                    <option value="{{$department->d_id}}">{{$department->d_title}}</option>
                                    @empty
                                    @endforelse

                                </select>


                                @error('department')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="subdepartment" class="col-md-4 col-form-label text-md-right">{{ __('Sub Department') }}</label>

                            <div class="col-md-6">
                                <select id="sd_id" type="text" class="form-control @error('subdepartment') is-invalid @enderror" name="sd_id" value="{{ old('sd_id') }}" required autocomplete="sd_id" autofocus>
                                    <option > Select Sub Department</option>


                                    @forelse($subdepartments as $subdepartment)
                                    <option value="{{$subdepartment->sd_id}}">{{$subdepartment->sd_title}}</option>
                                    @empty
                                    @endforelse

                                </select>


                                @error('sub_department')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="position" class="col-md-4 col-form-label text-md-right">{{ __('Position') }}</label>

                            <div class="col-md-6">
                                <input id="position" type="text" class="form-control @error('position') is-invalid @enderror" name="position" value="{{ old('position') }}" required autocomplete="position">

                                @error('position')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mobile" class="col-md-4 col-form-label text-md-right">{{ __('Mobile No.') }}</label>

                            <div class="col-md-6">
                                <input id="mobile" type="number" class="form-control @error('position') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile">

                                @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="emp_photo" class="col-md-4 col-form-label text-md-right">{{ __('Photo') }}</label>

                            <div class="col-md-6">
                                <input id="emp_photo" type="file" class="form-control @error('emp_photo') is-invalid @enderror" name="emp_photo" autocomplete="emp_photo">

                                @error('emp_photo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
