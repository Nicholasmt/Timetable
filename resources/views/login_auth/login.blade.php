@extends('layouts.app')

@section('body')
 <div id="app">
        <nav class="navbar navbar-expand-md   shadow-sm">
            <div class="container navbar_col">
                <a class="navbar-brand" href="#">
                  </a>
			   <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
             <span class="navbar-toggler-icon"></span>
         </button>
     </div>
  </nav>
  <main class="py-4">
  <div class="container">
    <div class="row justify-content-center">
	   @include('layouts.error')
	  <div class="col-md-6 fix-center fix-size" >
          <div class="card logo_side ">
              <div class="logo">
				  <h1><img src="{{ asset('assets/image/main_logo.png')}}" class="responsive"></h1>
                 <strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</strong>
				 </div>
            </div>
         </div>

        <div class="col-md-6 fix-size" >
            <div class="card form_side">
                <div class="card-header"> Login</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('auth')}}">
                        @csrf
                         <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                         <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                     <label class="form-check-label" for="remember">
                                        Remember Me 
                                    </label>
                                </div>
                                <input type="submit" class="links" value="login">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
 </div>
        <div class="pull- text-center">
            <strong class="text-center">Copyright &copy; <script type="text/javascript"> document.write( new Date().getFullYear() );</script>.
            <a target="_blank" href="#" class="link-hover">Babcock University</a>.
            </strong> All rights reserved
        </div>
  </main>
</div>

  	
<script src="{{ asset('assets/js/js/app.js') }}"></script>
 
@endsection
