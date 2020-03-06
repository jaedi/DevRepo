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


                <form method="POST" action='{{ url("login/$url") }}' aria-label="{{ __('Login') }}">

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


<style>
    body,
html {
	margin: 0;
	padding: 0;
	height: 100%;
}
.user_card {
	height: 400px;
	width: 350px;
	margin-top: auto;
	margin-bottom: auto;
	background: #90caf9;
	position: relative;
	display: flex;
	justify-content: center;
	flex-direction: column;
	padding: 10px;
	box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
	-webkit-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
	-moz-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
	border-radius: 5px;

}
.brand_logo_container {
	position: absolute;
	height: 170px;
	width: 170px;
	top: -75px;
	border-radius: 50%;
	background: #60a3bc;
	padding: 10px;
	text-align: center;
}
.brand_logo {
	height: 150px;
	width: 150px;
	border-radius: 50%;
	border: 2px solid white;
}
.form_container {
	margin-top: 100px;
}
.login_btn {
	width: 100%;
	background: #1565c0 !important;
	color: white !important;
}
.login_btn:focus {
	box-shadow: none !important;
	outline: 0px !important;
}
.login_container {
	padding: 0 2rem;
}
.input-group-text {
	background: #1565c0 !important;
	color: white !important;
	border: 0 !important;
	border-radius: 0.25rem 0 0 0.25rem !important;
}
.input_user,
.input_pass:focus {
	box-shadow: none !important;
	outline: 0px !important;
}
.custom-checkbox .custom-control-input:checked~.custom-control-label::before {
	background-color: #1565c0 !important;
}
</style>
@endsection

