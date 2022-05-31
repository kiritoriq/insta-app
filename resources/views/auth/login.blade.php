@extends('auth.app')
@section('title', 'Login')
@section('content')
<div class="d-flex flex-column flex-root">
    <div class="login login-2 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
        {{-- <div class="login-aside d-flex flex-column flex-row-auto" style="background-image: url({{ asset('media/bg/banner_1.jpg') }});"> --}}
        <div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat" style="background-image: url({{ asset('media/bg/bg-3.jpg') }});">
            <div class="login-form text-center p-7 position-relative overflow-hidden">
                <!--begin::Login Header-->
				<div class="d-flex flex-center mb-15">
					<a href="#">
						<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Laravel.svg/1200px-Laravel.svg.png" class="max-h-75px" alt="" />
					</a>
				</div>
                <div class="login-signin">
                    <div class="mb-20">
                        <h3>Insta App</h3>
                        <div class="text-muted font-weight-bold">Type your email and password to sign in!</div>
                    </div>
                    <form class="form" method="post" action="{{ route('login') }}" novalidate="novalidate" id="kt_login_signin_form">
                        @csrf
                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8" type="text" id="username" placeholder="Email" name="username" autocomplete="off" />
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8" type="password" id="password" placeholder="Password" name="password" />
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        {{-- Captcha (if u wanna use just un-comment it) --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-7 col-7">
                                    <img src="{{ captcha_src('default') }}" id="captchaCode" alt="" class="captcha img-responsive img-fluid">
                                    <div>
                                        <a href="javascript:void(0)" class="reloadCaptcha">
                                            Reload Captcha
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-5 col-5">
                                    <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" id="captcha" type="text" placeholder="" name="captcha" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                        {{-- Captcha --}}
                        <button type="submit" id="btnLogin" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">
                            <span>Sign in</span>
                            <span class="svg-icon svg-icon-white svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Angle-double-right.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                    <path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>
                                    <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
                                </g>
                                </svg><!--end::Svg Icon-->
                            </span>
                        </button>
                    </form>
                    <div class="mt-10">
                        <span class="opacity-70 mr-4">Don't have an account yet?</span>
                        <a href="{{ route('register') }}" id="kt_login_signup" class="text-muted text-hover-primary font-weight-bold">Sign Up!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Styles Section --}}
@section('styles')
    <link href="{{ asset('css/pages/login/login-4.css?v=7.0.6') }}" rel="stylesheet" type="text/css"/>
@endsection

{{-- Scripts Section --}}
@section('scripts')
    {{-- page scripts --}}
    <script src="{{ asset('js/pages/custom/login/login-general.js?v=7.0.6') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $('.reloadCaptcha').click(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('login.recaptcha') }}",
                    type: 'get',
                    success: function(response) {
                        $('#captchaCode').attr('src', response);
                    } 
                })
            })
        })
    </script>
@endsection