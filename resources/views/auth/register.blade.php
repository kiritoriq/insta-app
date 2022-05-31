@extends('auth.app')
@section('title', 'Register')
@section('content')
<div class="d-flex flex-column flex-root">
    <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
        <div class="login-aside d-flex flex-column flex-row-auto" style="background-color: #E8F4FF;">
            <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
                <a href="#" class="text-center mb-10">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Laravel.svg/1200px-Laravel.svg.png" class="max-h-70px" alt="" />
                </a>
                <h3 class="font-weight-bolder text-center font-size-h4 font-size-h1-lg" style="color: #ff2a1b;">
					Welcome to<br>Metronic Laravel 7 Framework
				</h3>
            </div>
            <div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center" style="background-image: url(https://preview.keenthemes.com/metronic/theme/html/demo1/dist/assets/media/svg/illustrations/login-visual-1.svg)"></div>
        </div>
        <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
            <div class="d-flex flex-column-fluid flex-center">
                <div class="login-form login-signin">
                    <form class="form" method="post" action="{{ route('register.action') }}" novalidate="novalidate" id="form_register">
                        @csrf
                        <div class="pb-13 pt-lg-0">
                            <span class="font-weight-bolder text-dark font-size-h1 align-middle">Register</span>
                        </div>

                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">Email</label>
                            <input class="form-control h-auto py-5 px-6 rounded-lg" type="email" id="email" placeholder="example@local.com" name="email" />
                        </div>
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">Username</label>
                            <input class="form-control h-auto py-5 px-6 rounded-lg" type="text" id="username" placeholder="Unique Username that only you know" name="username" />
                        </div>
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">Name</label>
                            <input class="form-control h-auto py-5 px-6 rounded-lg" type="text" id="name" placeholder="Your Name" name="name" />
                        </div>
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">Password</label>
                            <div class="input-group">
                                <input class="form-control h-auto py-5 px-6" type="password" id="password" placeholder="Type Your new Password" name="password" />
                                {{-- <input class="form-control h-auto py-7 px-6" id="password_confirmation" type="password" placeholder="Konfirmasi password" name="password_confirmation" autocomplete="off" /> --}}
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-eye icon-lg" id="show-password"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">Re-type Password</label>
                            <div class="input-group">
                                <input class="form-control h-auto py-5 px-6" type="password" id="password_confirmation" placeholder="Re-type Password" name="password_confirmation" />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-eye icon-lg" id="show-password2"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="pb-lg-0 pb-5 row">
                            <div class="col-lg-5 col-6">
                                <button type="submit" id="btnRegister" class="btn btn-primary btn-lg btn-block font-weight-bolder font-size-h5">
                                    Register &nbsp;
                                    <span class="svg-icon svg-icon-secondary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-02-01-052524/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Arrow-right.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"/>
                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000) " x="11" y="5" width="2" height="14" rx="1"/>
                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997) "/>
                                        </g>
                                    </svg><!--end::Svg Icon--></span>
                                </button>
                             </div>
                            <div class="col-lg-5 col-6">
                                 <a href="{{ route('login') }}" class="btn btn-link font-weight-bolder font-size-h4 text-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
    
    {{-- Styles Section --}}
    @section('styles')
        <link href="{{ asset('css/pages/login/login-1.css?v=7.0.6') }}" rel="stylesheet" type="text/css"/>
    @endsection
    
    {{-- Scripts Section --}}
    @section('scripts')
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous"></script> -->
        {{-- page scripts --}}
        <script type="text/javascript">
            let base_url = $(location).attr('pathname');
            base_url.indexOf(1);
            base_url.toLowerCase();
            base_url = (window.location.origin === "http://103.9.227.61/" ? "" : base_url.split("/")[0]);
            let site_url = window.location.origin + "/" + base_url;

            var Register = function () {
                var _login;
                // var _reloadCaptcha = function _reloadCaptcha() {
                //     var captcha = $("#captchaCode");
                //     $.ajax({
                //         type: "GET",
                //         url: site_url + 'reload-captcha',
                //     }).done(function (msg) {
                //         console.log(msg);
                //         captcha.attr('src', msg);
                //     });
                // };

                var _handleRegisterForm = function _handleRegisterForm() {
                    var validation;

                    validation = FormValidation.formValidation(KTUtil.getById('form_register'), {
                        fields: {
                            email: {
                                validators: {
                                    notEmpty: {
                                        message: 'Email cannot be empty'
                                    }
                                }
                            },
                            username: {
                                validators: {
                                    notEmpty: {
                                        message: 'Username cannot be empty'
                                    }
                                }
                            },
                            name: {
                                validators: {
                                    notEmpty: {
                                        message: 'Nama cannot be empty'
                                    }
                                }
                            },
                            password: {
                                validators: {
                                    notEmpty: {
                                        message: 'Password cannot be empty'
                                    }
                                }
                            },
                            password_confirmation: {
                                validators: {
                                    notEmpty: {
                                        message: 'Password Confirmation cannot be empty'
                                    }
                                }
                            },
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            bootstrap: new FormValidation.plugins.Bootstrap()
                        }
                    });

                    $('#form_register').on('submit', function (e) {
                        e.preventDefault();
                        validation.validate().then(function (status) {
                            $("#btnRegister").prop("disabled", true);
                            if (status == 'Valid') {
                                let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                                let email = $('#email').val();
                                let username = $('#username').val();
                                let name = $('#name').val();
                                let password = $('#password').val();
                                // console.log(tgskpns);
                                $("#btnRegister").prop("disabled", true);
                                $.ajax({
                                    url: '{{ route("register.action") }}',
                                    type: 'POST',
                                    dataType: "JSON",
                                    timeout: 10000,
                                    data: {
                                        _token: CSRF_TOKEN,
                                        email: email,
                                        username: username,
                                        name: name,
                                        password: password,
                                        password_confirmation: $('input[name="password_confirmation"]').val()
                                    },
                                    beforeSend: function () {

                                    },
                                    success: function (data) {
                                        // console.log(data);
                                        if (data.status == "failed") {
                                            // toastr.error("Ops, " + data.msg);
                                            Swal.fire({
                                                title: 'Register Failed!',
                                                text: data.msg,
                                                icon: 'error',
                                            })
                                            $("#btnRegister").prop("disabled", false);
                                        } else {
                                            Swal.fire({
                                                title: 'Register Success!',
                                                text: data.msg,
                                                icon: 'success',
                                                showConfirmButton: false,
                                                showCancelButton: false,
                                                timer: 2000
                                            }).then(() => {
                                                window.location.href = "{{ route('login') }}"
                                            })
                                        }
                                    },
                                    error: function (x, t, m) {

                                    }
                                });

                            } else {
                                $("#btnRegister").prop("disabled", false);
                                swal.fire({
                                    title: "Register cannot be complete!",
                                    text: "Please fill out all the forms.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Close",
                                    customClass: {
                                        confirmButton: "btn font-weight-bold btn-light-primary"
                                    }
                                }).then(function () {
                                    $("#btnRegister").prop("disabled", false);
                                    KTUtil.scrollTop();
                                });
                            }
                        });
                    });

                };


                return {
                    // public functions
                    init: function init() {
                        _handleRegisterForm();
                    }
                };
            }();

            $(document).ready(function () {
                let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                Register.init()

                $('#show-password').on("click", function () {
                    $(this).toggleClass("la-eye-slash");
                    var input = $("#password");
                    if (input.attr("type") === "password") {
                        input.attr("type", "text");
                    } else {
                        input.attr("type", "password");
                    }
                })

                $('#show-password2').on("click", function () {
                    $(this).toggleClass("la-eye-slash");
                    var input = $("#password_confirmation");
                    if (input.attr("type") === "password") {
                        input.attr("type", "text");
                    } else {
                        input.attr("type", "password");
                    }
                })

            });
        </script>
    @endsection