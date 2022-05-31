<style>
    .swal2-container {
        z-index: 99999
    }
</style>
<div class="container py-5 max-w-700px">
    <form action="{{ route('roles.update', $id) }}" class="form" id="roles-form" method="PUT">
        @csrf
        {{-- <div class="container"> --}}
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h3 class="card-title">
                        <span class="card-icon">
                            <span class="svg-icon svg-icon-success svg-icon-3x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Design/Edit.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>
                                    <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>
                                </g>
                            </svg><!--end::Svg Icon--></span>
                        </span>
                        <b>Edit Role</b>
                    </h3>
                </div>
                <div class="card-body">
                        <div class="form-group row">
                            <label class="col-form-label text-right col-lg-3 col-sm-12">Nama Role:</label>
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                <input type="text" class="form-control" name="nama_role" id="role" placeholder="Nama Role" value="{{ $role->roles }}">
                            </div>
                        </div>
                </div>
                <div class="card-footer">
                    <div style="float: right">
                        <button type="submit" class="btn btn-success btnSubmit" id="btnSubmit">
                            <i class="fas fa-save"></i> Save
                        </button>
                        <button type="button" class="btn btn-warning" onclick="$.fancybox.close()">
                            <i class="fas fa-arrow-alt-circle-left"></i> Cancel
                        </button>
                    </div>
                </div>
            </div>
        {{-- </div> --}}
    </form>
</div>
<script>
    $(document).ready(function() {
        $('#roles-form').submit(function(e) {
            e.preventDefault()
            var $this = $(this)
            confirmAlert(
                'Yakin simpan data?',
                '',
                'warning',
                'Yakin',
                'Tidak'
            )
            .then((result) => {
                if(result.value) {
                    $.ajax({
                        url: $this.attr('action'),
                        type: $this.attr('method'),
                        data: $this.serialize(),
                        success: function(response) {
                            if(response.status == 'success') {
                                timerAlert(
                                    'Sukses',
                                    response.msg,
                                    'success',
                                    2000
                                )
                                .then(() => {
                                    $.fancybox.close()
                                    window.location.reload()
                                })
                            }

                            if(response.status == 'failed') {
                                basicAlert(
                                    'Gagal Menyimpan!',
                                    'Terjadi Kesalahan! ' + response.error,
                                    'error',
                                    'Ok'
                                )
                            }
                        }
                    })
                }
            })
        })
    })
</script>