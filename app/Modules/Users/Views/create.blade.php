@extends('layout.default')
@section('title', 'Tambah User')
@section('content')
<div class="container">
    <div class="card card-custom gutter-b">
        <div class="card-header">
            <h3 class="card-title">
                Tambah User
            </h3>
        </div>
        <form class="form" id="form_user" method="POST" action="{{ route('users.create.action') }}">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-lg-4 col-4 col-form-label">Username <span class="text-danger">*</span></label>
                    <div class="col-lg-8 col-8">
                        <input type="text" class="form-control border-primary" id="username" placeholder="Masukkan username"  name="username">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-4 col-form-label">Password <span class="text-danger">*</span></label>
                    <div class="col-lg-8 col-8">
                        <input id="password" type="password" class="form-control border-primary" name="password" placeholder="Masukkan Password" required autocomplete="new-password">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-4 col-form-label">Ulangi Password <span class="text-danger">*</span></label>
                    <div class="col-lg-8 col-8">
                        <input id="password-confirm" type="password" class="form-control border-primary" name="password_confirmation" required placeholder="Ulangi Password" autocomplete="new-password">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-4 col-form-label">Role <span class="text-danger">*</span></label>
                    <div class="col-lg-8 col-8 col-form-label">
                        <div class="checkbox-list">
                            @foreach($roles as $role)
                            <label class="checkbox">
                                <input id="{{ $role->roles.$role->id }}" type="checkbox" name="role[]" value="{{ $role->id }}">
                                <span></span>{{ $role->roles }}
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right ">
                <button type="submit" id="btnSubmit" class="btn btn-primary mr-2">Simpan</button>
                {{-- <button type="button" class="btn btn-danger">Batal</button> --}}
                <a href="{{ route('users.index') }}" class="btn btn-warning">Batal</a>
            </div>
        </form>
        <!--end::Form-->
    </div>
</div>
@endsection

{{-- Styles Section --}}
@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

{{-- Scripts Section --}}
@section('scripts')
    {{-- vendors --}}
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
{{-- page scripts --}}
<script type="text/javascript">

    jQuery(document).ready(function () {
        CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#form_user').on('submit', function (e) {
            e.preventDefault();
            $("#btnSubmit").prop("disabled", true);
            let username = $('#username').val();
            let password = $('#password').val();
            let password_confirmation = $('#password-confirm').val();
            let role = $('input[name="role[]"]:checked').val();
            $.ajax({
                url: $(this).attr("action"),
                type: 'POST',
                dataType: "JSON",
                timeout: 10000,
                data: {
                    _token: CSRF_TOKEN,
                    username: username,
                    password: password,
                    password_confirmation: password_confirmation,
                    role: role,
                },
                beforeSend: function () {
                    
                },
                success: function (data) {
                    if (data.status == "failed") {
                        toastr.error("Ops, " + data.msg);
                        $("#btnSubmit").prop("disabled", false);
                    } else {
                        Swal.fire({
                            title: 'Berhasil Tersimpan',
                            text: data.msg,
                            icon: 'success',
                            showConfirmButton: true,
                            confirmButtonText: 'Ok'
                        }).then(() => {
                            window.location.href = "{{ route('users.index') }}";
                        })
                    }
                },
                error: function (x, t, m) {
                    $("#btnSubmit").prop("disabled", false);
                }
            });
        });
    });
</script>
@endsection