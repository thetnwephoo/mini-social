@extends('layouts.template')
@section('content')
<form action="{{ route('register') }}" method="POST">
    @csrf
    <div class="col-md-8 offset-md-2">
    
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" value="{{ old('name') }}" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" 
                    id="name" name="name" required>
                @if($errors->has('name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="email" value="{{ old('email') }}" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                    id="email" required>
                    @if($errors->has('email'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
                <input type="password" value="{{ old('password') }}" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" 
                    id="password" required>
                @if($errors->has('password'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="confirm_password" class="col-sm-2 col-form-label">Confirm Password</label>
            <div class="col-sm-10">
                <input type="password" value="{{ old('password_confirmation') }}" name="password_confirmation" class="form-control" id="confirm_password" required>
            </div>
        </div>

        <input type="submit" class="btn btn-primary btn-block" value="Register">

    </div>

</form>
@endsection