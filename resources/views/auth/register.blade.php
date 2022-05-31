@extends('auth.app')
@section('title', 'Register')
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
                        <div class="text-muted font-weight-bold">Register Account</div>
                    </div>
                    <form class="form" method="post" action="{{ url('register') }}" novalidate="novalidate" id="register-form">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-5">
                                    <input type="text" class="form-control h-auto form-control-solid py-4 px-8" name="first_name" placeholder="First Name" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control h-auto form-control-solid py-4 px-8" name="last_name" placeholder="Last Name" autocomplete="off">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-5">
                                    <div class="input-icon input-icon-right">
                                        <input class="form-control h-auto form-control-solid py-4 px-8" type="text" id="dob" placeholder="Date Of Birth" name="date_of_birth" autocomplete="off" />
                                        <span>
                                            <i class="fas fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-5">
                                    <select name="gender" id="gender" class="form-control h-auto form-control-solid py-4 px-8">
                                        <option value="">.: Choose Gender :.</option>
                                        <option value="M">Male</option>
                                        <option value="F">Female</option>
                                        <option value="N/A">N/A</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8" type="text" id="email" placeholder="Email" name="email" autocomplete="off" />
                        </div>
                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8" type="password" id="password" placeholder="Password" name="password" />
                        </div>
                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8" type="password"  placeholder="Re:type your password" name="password_confirmation" />
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
                                    <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" id="captcha" type="text" placeholder="Fill Captcha" name="captcha" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                        {{-- Captcha --}}
                        <button type="submit" id="btnLogin" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">
                            <span>Submit</span>
                        </button>
                        <a href="{{ route('login') }}" class="btn btn-warning font-weight-bold px-9 py-4 my-3 mx-4">
                            <span>Cancel</span>
                        </a>
                    </form>
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
    <script>
        $(document).ready(function() {
            $('#dob').datepicker({
                format: 'dd-mm-yyyy'
            })
            $('#register-form').submit(function(e) {
                e.preventDefault()
                $('#btnLogin').attr('disabled', true)
                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                    success: function(response) {
                        $('.reloadCaptcha').trigger('click');
                        if(response.status === 'success') {
                            Swal.fire({
                                title: response.msg,
                                text: 'You now can sign in to application',
                                icon: 'success',
                                confirmButtonText:'Ok'
                            })
                            .then(() => {
                                window.location.href = '{{ url("login") }}'
                            })
                        } else {
                            Swal.fire({
                                title: 'An Error Occured!',
                                text: response.error,
                                icon: 'error',
                                confirmButtonText:'Ok'
                            })
                        }
                    },
                    complete: function() {
                        $('#btnLogin').attr('disabled', false)
                    }
                })
            })

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