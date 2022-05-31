@extends('layout.default')
@section('title', 'User')
@section('content')
<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title">
                            <span class="card-icon">
                                <span class="svg-icon svg-icon-primary svg-icon-3x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2020-07-07-181510/theme/html/demo1/dist/../src/media/svg/icons/Communication/Group.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                        <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                        <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                    </g>
                                </svg><!--end::Svg Icon--></span>
                            </span>
                            <h3 class="card-label mt-2 display-4">Data User
                            <small>Kelola User</small></h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>Filter Data User</p>
                        <div class="form-group row fv-plugins-icon-container">
                            <div class="col-lg-6">
                                <input type="text" id="cari-nama" name="nama" class="form-control" placeholder="Nama">
                            </div>
                            <div class="col-lg-2">
                                <select class="form-control" name="jenis" id="role">
                                    <option value="">Semua Role</option>
                                    <option value="1">Admin</option>
                                    <option value="2">Call Center</option>
                                </select>
                            </div>
                            <div class="col-lg-4 text-right">
                                <div class="btn-group btn-group-xs" role="group" aria-label="Large button group">
                                    <button class="btn btn-danger btn-sm text-white py-3" type="button" data-toggle="tooltip" data-theme="dark" title="Clear Form">
                                        <span class="svg-icon svg-icon-white"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2020-07-07-181510/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Close.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                                    <rect x="0" y="7" width="16" height="2" rx="1"/>
                                                    <rect opacity="0.3" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000) " x="0" y="7" width="16" height="2" rx="1"/>
                                                </g>
                                            </g>
                                        </svg><!--end::Svg Icon--></span>
                                    </button>
                                    <button class="btn btn-success btn-sm py-3" type="button" data-toggle="tooltip" data-theme="dark" title="Filter Data">
                                        <span class="svg-icon svg-icon-white"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2020-07-07-181510/theme/html/demo1/dist/../src/media/svg/icons/General/Search.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"/>
                                            </g>
                                        </svg><!--end::Svg Icon--></span> Cari
                                    </button>
                                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm py-3" title="Tambah User">
                                        <span class="svg-icon svg-icon-white"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2020-07-07-181510/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Plus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
                                                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/>
                                            </g>
                                        </svg><!--end::Svg Icon--></span> Tambah
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover datatable-init" id="table-user">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Username / Nama</th>
                                        <th>Role</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Username / Nama</th>
                                        <th>Role</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach($users as $key => $user)
                                    <tr>
                                        <td class="text-center">{{ ++$key }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td class="text-center align-middle">
                                            @foreach($user->roles as $role) 
                                                <span class="label label-lg font-weight-bold label-light-primary label-inline mr-3">{{ $role->role->roles }}</span>
                                            @endforeach
                                            {{-- <span class="label label-lg font-weight-bold label-light-primary label-inline">{{ $user->privilege }}</span> --}}
                                        </td>
                                        <td class="text-center" width="20%">
                                            <button type="button" class="btn btn-sm btn-clean btn-icon" data-fancybox data-type="ajax" data-src="{{ route('users.edit', $user->id) }}" data-toggle="tooltip" data-theme="dark" title="Edit User">
                                                <span class="la la-2x la-edit text-primary"></span>
                                            </button>
                                            <a href="#" class="btn btn-sm btn-clean btn-icon hapus-user" data-user="{{ $user->id }}" data-toggle="tooltip" data-theme="dark" title="Hapus User">
                                                <span class="la la-2x la-trash text-danger"></span>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    <script src="{{ asset('js/pages/User.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $('#table-user .hapus-user').click(function(e) {
                e.preventDefault();
                var id = $(this).attr('data-user')
                Swal.fire({
                    icon: 'warning',
                    title: 'Apakah anda yakin akan menghapus data ini?',
                    text: 'Setelah dihapus, data tidak dapat dikembalikan',
                    showConfirmButton: true,
                    confirmButtonText: 'Yakin',
                    showCancelButton: true,
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if(result.value) {
                        $.ajax({
                            url: '{{ route("users.delete") }}',
                            type: 'POST',
                            data: { id: id, _token: $('meta[name="csrf-token"]').attr('content') },
                            success: function(response) {
                                if(response.status == 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: 'Data Berhasil dihapus',
                                        timer: 2000,
                                        showConfirmButton: false
                                    }).then(() => {
                                        window.location.href = "{{ route('users.index') }}";
                                    })
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Terjadi Kesalahan!',
                                        text: response.msg,
                                        timer: 2000,
                                        showConfirmButton: false
                                    })
                                }
                            }
                        })
                    } else {

                    }
                })
            })
        })
    </script>
@endsection
