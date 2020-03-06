@extends('layouts.app')

@section('content')

<div class="container h-100">
    <div class="d-flex justify-content-center h-100">
        <div class="user_card">
            <div class="d-flex justify-content-center">
                <div class="brand_logo_container">
                    <img src="https://i.pinimg.com/originals/0e/e5/89/0ee58946f8b3832204d39c0b429d8d9a.gif" class="brand_logo" alt="Logo" width="250 px">

                <!-- <video id="video"   playsinline="" muted="" autoplay="" loop="" data-silent="true" src="https://cdn.dribbble.com/users/418188/screenshots/3102257/rocket_animation_tubik_studio.gif?vid=1"></video> -->
                </div>

            </div>
            <div class="d-flex justify-content-center form_container">


                <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">

                @csrf
                    <div class="" style="text-align: center;">
                        <h1>Team Rocket</h1>
                    </div>
                    <Br>
                    <div class="input-group mb-3">
                        <div class="input-group-append" >
                            <span class="input-group-text" style="background-color: #42b6f5; color:white"><i class="fas fa-user"></i></span>
                        </div>
                        <input id="login" type="text"
                                class="input_user form-control{{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}"
                                name="login" value="{{ old('username') ?: old('email') }}"
                                placeholder="Email" required autofocus>

                        @if ($errors->has('username') || $errors->has('email'))
                        <span class="invalid-feedback">
                        <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>
                         </span>
                        @endif

                        <!-- <input type="text"
                        id="username"
                        placeholder="Enter username"
                        ng-model="data.loginUsername"
                        class="form-control input_user"
                        placeholder="username"> -->
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-append">
                            <span class="input-group-text" style="background-color: #42b6f5; color:white"><i class="fas fa-key"></i></span>
                        </div>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" required autocomplete="current-password"
                                placeholder="Password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <!-- <input type="password" name="" class="form-control input_pass"
                        id="login-password"
                        placeholder="Enter password"
                        ng-model="data.loginPassword"
                        placeholder="password"> -->
                    </div>

                        <div class="d-flex justify-content-center mt-3 login_container">

                <button type="submit" name="button" class="btn login_btn" style="width: 100%">Login</button>

               </div>
                </form>
            </div>


        </div>
    </div>
</div>

@endsection

