<div class="card card-custom gutter-b">
    <div class="card-header">
        <h4 class="card-title font-weight-bold">Suggestions</h4>
    </div>
    <div class="card-body">
        @foreach($suggestions as $suggest)
            <div class="row">
                <div class="col-6">
                    <!--begin::Left-->
                    <div class="d-flex align-items-center my-2">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-35 mr-3">
                                @if($suggest->profile_picture != NULL)
                                    <div class="symbol-label" style="background-image: url('media/users/{{ $suggest->profile_picture }}')"></div>
                                @else
                                    <div class="symbol-label font-size-h3">{{ substr($suggest->first_name,0,1) }}{{ substr($suggest->last_name,0,1) }}</div>
                                @endif
                            </div>
                            <a href="{{ route('profile.show', encrypt($suggest->id)) }}" class="text-dark-75 font-size-lg text-hover-primary font-weight-bolder">{{ $suggest->first_name }} {{ $suggest->last_name }}</a>
                        </div>
                    </div>
                    <!--end::Left-->
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-sm btn-primary my-2 btnFollow" data-href="{{ route('profile.follow', encrypt($suggest->id)) }}" style="float: right">Follow</button>
                </div>
            </div>
            
        @endforeach
    </div>
</div>
{{-- Scripts Section --}}
@stack('scripts')
    <script>
        $(document).ready(function() {
            $('.btnFollow').click(function(e) {
                e.preventDefault()
                $.ajax({
                    url: $(this).attr('data-href'),
                    type: 'POST',
                    success: function(response) {
                        if(response.status === 'success') {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    icon: 'success',
                                    title: response.msg,
                                    timer: 1500
                                })
                                    .then(() => {
                                        window.location.reload();
                                    })
                            } else {
                                basicAlert(
                                    'An Error Occured!',
                                    response.error,
                                    'error',
                                    'Ok'
                                )
                            }
                    }
                })
            })
        })
    </script>
@endstack