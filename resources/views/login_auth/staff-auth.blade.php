@extends('home.app_login')

@section('content')

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('all_assets/css/app.css') }}" rel="stylesheet">

<div class="container">
    <div class="row justify-content-center">

        @include('layouts.error')
	
    <div class="col-md-6 fix-center" >
            <div class="card logo_side ">
               <div class="logo">
                    <h1><img src="{{ asset('image/main_logo.png')}}" class="responsive"></h1>

                  <strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</strong>
			</div>
        </div>
    </div>

        <div class="col-md-6">
            <div class="card form_side">
                <div class="card-header">{{ __('Complete Registration') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('authenticate')}}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Choose Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('email') is-invalid @enderror" name="password" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="confirm_password" type="password" class="form-control @error('password') is-invalid @enderror" name="confirm_password" required autocomplete="current-password">

                                @error('confirm_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> -->

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
			.form_side{
				background: #125b9e;
				color: aliceblue;
				 height: 420px
			}

			.fix-center{
				text-align: center;
                
                
			}

			.logo_side{
				 height: 420px;
				background: #d99b3c;
				color: white;


			}

            .btn-primary{
                background: aliceblue;
				color: #125b9e;
            }
			.btn-primary:hover{
                background: #d99b3c;
				color: white;
            }
			.responsive{

				 padding: 20px;
				margin-left: -8%;
			}
			.btn-link{
				color: aliceblue;
				text-decoration-line: none;
			}

			.btn-link:hover{
				color: #d99b3c;
				text-decoration-line: none;
			}
			.card-body{
				margin-top: 10%;
			}

			.logo{
				margin-top: 13%;
			}



		</style>

@endsection
