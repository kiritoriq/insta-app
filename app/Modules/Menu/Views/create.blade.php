@extends('layout.default')
@section('title', 'Create Menu')
@section('content')
    <form action="{{ route('menu.store') }}" class="form" id="menu_form" method="POST">
        @csrf
        <div class="container">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">
                        <span class="card-icon">
                            <span class="svg-icon svg-icon-primary svg-icon-3x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Text/Menu.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <rect fill="#000000" x="4" y="5" width="16" height="3" rx="1.5"/>
                                    <path d="M5.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 Z M5.5,10 L18.5,10 C19.3284271,10 20,10.6715729 20,11.5 C20,12.3284271 19.3284271,13 18.5,13 L5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z" fill="#000000" opacity="0.3"/>
                                </g>
                            </svg><!--end::Svg Icon--></span>
                        </span>
                        <b>Create New Menu</b>
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row gutter-b">
                        <div class="col-lg-6"> 
                            <div class="form-group">
                                <label class="col-form-label">Menu Title</label>
                                <input type="text" name="title" class="form-control title" id="title" placeholder="Menu Title" required>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Bullet</label>
                                <div class="radio-inline mb-5">
                                    <label class="radio">
                                        <input type="radio" name="bullet" value="dot">
                                        <span></span> Dot
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="bullet" value="line">
                                        <span></span> Line
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="bullet" value="">
                                        <span></span> <i style="font-size: 1rem; color: black">Null</i>
                                    </label>
                                </div>
                                <span>
                                    <i style="font-size: 1rem">if u wanna show icon in submenu, just check null</i>
                                </span>
                                {{-- <input type="text" name="title" class="form-control title" id="title" placeholder="Menu Title" required> --}}
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Is Section</label>
                                <div class="checkbox-inline">
                                    <label class="checkbox">
                                        <input type="checkbox" name="is_section" value="true">
                                        <span></span> <i style="font-size: 1rem">is Section?</i>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Is Root Menu</label>
                                <div class="checkbox-inline">
                                    <label class="checkbox">
                                        <input type="checkbox" name="is_root" value="true" checked="checked">
                                        <span></span> <i style="font-size: 1rem">is Root?</i>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group" id="input_parent_id">
                                <label class="col-form-label">Parent Menu</label>
                                {!! getListMenu("") !!}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">Icon</label>
                                <input type="text" name="icon" id="icon" class="form-control" placeholder="Icon">
                                <span class="mt-5">
                                    <i style="font-size: 1rem">If you want to use SVG Icons place the URL, but if you won't, just write the class name</i>
                                </span>
                                <br>
                                <span>
                                    <i style="font-size: 1rem">SVG URL ex: media/svg/icons/Design/Layers.svg</i>
                                </span>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Route Destination</label>
                                <input type="text" class="form-control page" id="page" placeholder="Page Destination (Route)" name="page">
                                <span class="mt-5">
                                    <i style="font-size: 1rem">Fill it same as the title (Case Sensitive). If the title more than 1 syllable, Use <b>CamelCase</b>.</i>
                                </span>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Order</label>
                                <div class="col-4" style="margin-left: -12px">
                                    <input type="number" id="order" name="order" class="form-control order" placeholder="List Order">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Is Active</label>
                                <div class="checkbox-inline">
                                    <label class="checkbox">
                                        <input type="checkbox" name="is_active" value="true" checked="checked">
                                        <span></span> <i style="font-size: 1rem">is Active?</i>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <hr>
                            <div class="form-group">
                                <label class="col-form-label">Role</label>
                                <div class="checkbox-inline">
                                    @foreach($roles as $role)
                                        <label class="checkbox">
                                            <input type="checkbox" name="roles[]" value="{{ $role->id }}">
                                            <span></span> {{ $role->roles }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Action</label>
                                <div class="checkbox-inline">
                                    <label class="checkbox">
                                        <input type="checkbox" name="action[]" value="create">
                                        <span></span> Create
                                    </label>
                                    <label class="checkbox">
                                        <input type="checkbox" name="action[]" value="edit">
                                        <span></span> Edit
                                    </label>
                                    <label class="checkbox">
                                        <input type="checkbox" name="action[]" value="delete">
                                        <span></span> Delete
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div style="float: right">
                        <button type="submit" class="btn btn-success btnSubmit" id="btnSubmit">
                            <i class="fas fa-save"></i> Save
                        </button>
                        <a href="{{ route('menu.index') }}" class="btn btn-warning">
                            <i class="fas fa-arrow-alt-circle-left"></i> Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
{{-- Scripts Section --}}
@section('scripts')

    {{-- page scripts --}}
    <script>
        $(document).ready(function() {
            $('#input_parent_id').hide();
            $('input[type="checkbox"][name="is_root"]').change(function(e) {
                let root = $('input[type="checkbox"][name="is_root"]:checked')
                // console.log(root)
                if(root.length <= 0) {
                    $('#input_parent_id').fadeIn('slow')
                    $('select').select2()
                } else {
                    $('#input_parent_id').fadeOut('slow')
                }
            })

            $('#menu_form').submit(function(e) {
                e.preventDefault()
                let $this = $(this)
                Swal.fire({
                    title: 'Are you sure want to save it?',
                    icon: 'warning',
                    showConfirmButton: true,
                    showCancelButton: true
                }).then((result) => {
                    if(result.value) {
                        $.ajax({
                            url: $this.attr('action'),
                            type: $this.attr('method'),
                            data: $this.serialize(),
                            success: function(response) {
                                if(response.status == 'success') {
                                    Swal.fire({
                                        title: 'Sukses!',
                                        text: response.msg,
                                        icon: 'success',
                                        showConfirmButton: false,
                                        showCancelButton: false,
                                        timer: 2500
                                    }).then(() => {
                                        window.location.href = '{{ route("menu.index") }}'
                                    })
                                } else {
                                    Swal.fire({
                                        title: 'Data Gagal Disimpan!',
                                        text: response.msg,
                                        icon: 'error',
                                        confirmButtonText: 'Tutup'
                                    })
                                }
                            }
                        })
                    }
                })
            })
        })
    </script>
@endsection