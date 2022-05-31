<style>
    .swal2-container {
        z-index: 10000000;
    }
</style>
<div class="container py-5 max-w-700px">
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">
                Edit User
            </h3>
        </div>
        <form action="{{ route('users.edit.action') }}" method="POST" class="form" id="formSubmit">
            @csrf
            <input type="hidden" name="id" value="{{ $data->id }}">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-lg-4 col-4 col-form-label">
                        Username <span class="text-danger">*</span>
                    </label>
                    <div class="col-lg-8 col-8">
                        <input type="text" name="username" class="form-control" placeholder="Masukkan username" value="{{ $data->username }}" id="username" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-4 col-form-label">
                        Password <span class="text-danger">*</span>
                    </label>
                    <div class="col-lg-8 col-8">
                        <input type="text" name="password" class="form-control" placeholder="Masukkan password" id="password">
                        <div class="mt-3">
                            <small>Jika tidak ingin mengganti password silahkan kosongi field password</small>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-4 col-form-label">
                        Roles <span class="text-danger">*</span>
                    </label>
                    <div class="col-lg-8 col-8">
                        <div class="checkbox-list">
                            @foreach($data->roles as $role)
                                <?php $rol = $role->role_id ?>
                            @endforeach
                            @foreach($roles as $role)
                            <label class="checkbox">
                                <input id="{{ $role->roles.$role->id }}" type="checkbox" name="role[]" value="{{ $role->id }}" {{ ($rol == $role->id)?'checked':'' }}>
                                <span></span>{{ $role->roles }}
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right ">
                <button type="submit" id="btnSubmit" class="btn btn-primary mr-2">Simpan</button>
                <button type="button" onclick="$.fancybox.close()" class="btn btn-danger">Batal</button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        
        $('#formSubmit').submit(function(e) {
            e.preventDefault();
            $('#btnSubmit').prop('disabled', true);
            Swal.fire({
                icon: 'warning',
                title: 'Yakin Akan Menyimpan Data?',
                showConfirmButton: true,
                confirmButtonText: 'Yakin',
                showCancelButton: true,
                cancelButtonText: 'Batal'
            }).then((result) => {
                if(result.value) {
                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            // console.log(response);
                            $('#btnSubmit').prop('disabled', true);
                            if(response.status == 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Data Berhasil Disimpan',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = "{{ route('users.index') }}";
                                })
                            } else {
                                $('#btnSubmit').prop('disabled', false);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal Menyimpan Data!',
                                    text: response.msg,
                                    timer: 2000,
                                    showConfirmButton: false
                                })
                            }
                        }
                    })
                } else {
                    $('#btnSubmit').prop('disabled', false);
                }
            })
        })
    })
</script>