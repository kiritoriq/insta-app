@extends('layout.default')
@section('title', 'Profile Page ' . $user->first_name)
@section('content')
<div class="d-flex flex-column-fluid">
    <div class="container">
        {{-- Profile Section --}}
        <div class="card card-custom gutter-b">
            <div class="card-body">
                <div class="d-flex mb-9">
                    {{-- Begin Pic --}}
                    <div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
                        <div class="symbol symbol-50 symbol-lg-120">
                            @if($user->profile_image != NULL)
                                <img src="{{ asset('media/users/300_1.jpg') }}" alt="image">
                            @else
                                <span class="symbol-label font-size-h1">{{ substr($user->first_name,0,1) }}</span>
                            @endif
                        </div>
                        <div class="symbol symbol-50 symbol-lg-120 symbol-primary d-none">
                            <span class="font-size-h3 symbol-label font-weight-boldest">{{ substr($user->first_name,0,1) }}{{ substr($user->last_name,0,1) }}</span>
                        </div>
                    </div>
                    {{-- End of Pic --}}
                    {{-- Begin info --}}
                    <div class="flex-grow-1">
                        <!--begin::Title-->
                        <div class="d-flex justify-content-between flex-wrap mt-1">
                            <div class="d-flex mr-3">
                                <a href="{{ route('profile.index') }}" class="text-dark-75 text-hover-primary font-size-h5 font-weight-bold mr-3">{{ $user->first_name }} {{ $user->last_name }}</a>
                                <a href="#">
                                    <i class="flaticon2-correct text-success font-size-h5"></i>
                                </a>
                            </div>
                            <div class="my-lg-0 my-3">
                                <a href="{{ route('profile.follow', encrypt($user->id)) }}" class="btn btn-sm btn-light-primary font-weight-bolder text-uppercase mr-3">Follow</a>
                            </div>
                        </div>
                        <!--end::Title-->
                        <!--begin::Content-->
                        <div class="d-flex flex-wrap justify-content-between mt-1">
                            <div class="d-flex flex-column flex-grow-1 pr-8">
                                <div class="d-flex flex-wrap mb-4">
                                    <a href="#" class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                    <i class="flaticon2-new-email mr-2 font-size-lg"></i>{{ $user->email }}</a>
                                </div>
                                <span class="font-weight-bold text-dark-50">
                                    @if(! empty($user->bio))
                                        {{ $user->bio }}
                                    @else
                                        Their Bio
                                    @endif
                                </span>
                            </div>
                            
                            
                            <div class="d-flex align-items-center w-25 flex-lg-fill float-right mt-lg-12 mt-8">
                                <div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
                                    <span class="mr-4">
                                        <i class="flaticon-edit display-4 text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-75">
                                        <span class="font-weight-bolder font-size-sm">Posts</span>
                                        <span class="font-weight-bolder font-size-h5">{{ count($user->posts) }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
                                    <span class="mr-4">
                                        <i class="flaticon-users display-4 text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-75">
                                        <span class="font-weight-bolder font-size-sm">Connection</span>
                                        <span class="font-weight-bolder font-size-h5">{{ count($user->connections) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Content-->
                    </div>
                    {{-- End of info --}}
                </div>
            </div>
        </div>
        {{-- End Of Profile Section --}}
        <div class="row">
            {{-- Post Section --}}
            <div class="col-8">
                <div class="card card-custom gutter-b">
                    <form method="POST" action="{{ route('post.store') }}" id="create-post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group">
                                <textarea class="form-control" name="post_caption" id="caption" cols="30" rows="5" placeholder="Say hi?"></textarea>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6">
                                    <input type="file" name="images" id="images" accept="image/*">
                                </div>
                                <div class="col-4">
        
                                </div>
                                <div class="col-2">
                                    <button style="float: right" type="submit" class="btn btn-sm btn-primary btnSubmit">Post</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="d-flex flex-column mt-4 mb-4">
                    @if(count($posts) == 0)
                        They didn't post anything yet
                    @else
                        @foreach($posts as $index => $post)
                            <div class="card">
                                <div class="card-header align-items-center flex-wrap justify-content-between border-0 py-6 h-auto">
                                    <!--begin::Left-->
                                    <div class="d-flex align-items-center my-2">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-35 mr-3">
                                                @if($user->profile_picture != NULL)
                                                    <div class="symbol-label" style="background-image: url('media/users/{{ $user->profile_picture }}')"></div>
                                                @else
                                                    <div class="symbol-label font-size-h3">{{ substr($user->first_name,0,1) }}</div>
                                                @endif
                                            </div>
                                            <a href="#" class="text-dark-75 font-size-lg text-hover-primary font-weight-bolder">{{ $user->first_name }} {{ $user->last_name }}</a>
                                            <span class="ml-3 text-muted">{{ Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <!--end::Left-->
                                </div>
                                <div class="card-body pt-0 pl-5 pr-0 pb-0">
                                    <div style="text-align: start; font-size: 1.25rem">
                                        {{ $post->caption }}
                                    </div>
                                    @if(count($post->postImages) > 0)
                                        <div class="embed-responsive embed-responsive-1by1">
                                            <img class="embed-responsive-item" src="{{ asset($post->postImages[0]->images) }}" />
                                        </div>
                                    @endif
                                    <hr>
                                    <div class="d-flex flex-row justify-content-between pl-4 pr-3 pt-3 pb-1 mb-5">
                                        <ul class="list-inline d-flex flex-row align-items-center m-0">
                                            <li class="list-inline-item">
                                                <button class="btn p-0" title="Like this post">
                                                    <i class="flaticon-like"></i>
                                                </button>
                                                {{ (count($post->postLikes) > 0 ? count($post->postLikes) : '') }}
                                            </li>
                                        </ul>
                                        
                                    </div>
            
                                    <div class="pl-3 pr-3 pb-2">
                                        <strong class="d-block">Comments <i class="flaticon2-down text-dark icon-xs"></i></strong>
                                        <div>
                                            @foreach($post->postComments as $key => $comment)
                                                <div class="d-flex align-items-start card-spacer-x py-4">
                                                    <!--begin::User Photo-->
                                                    <span class="symbol symbol-35 mr-3 mt-1">
                                                        @if($comment->user->profile_picture != NULL)
                                                            <div class="symbol-label" style="background-image: url('media/users/{{ $comment->user->profile_picture }}')"></div>
                                                        @else
                                                            <div class="symbol-label font-size-h3">{{ substr($comment->user->first_name,0,1) }}</div>
                                                        @endif
                                                    </span>
                                                    <!--end::User Photo-->
                                                    <!--begin::User Details-->
                                                    <div class="d-flex flex-column flex-grow-1 flex-wrap mr-2">
                                                        <div class="d-flex">
                                                            <a href="#" class="font-size-lg font-weight-bolder text-dark-75 text-hover-primary mr-2">{{ $comment->user->first_name }} {{ $comment->user->last_name }}</a>
                                                            <div class="font-weight-bold text-muted">
                                                            {{ Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</div>
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            <div class="text-muted font-weight-bold toggle-on-item" data-inbox="toggle">{{ $comment->comment }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="font-weight-bold text-muted mr-2">{{ date('g:i A', strtotime($comment->created_at)) }}</div>
                                                    </div>
                                                    <!--end::User Details-->
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
            
                                    <div class="position-relative comment-box">
                                        <form action="{{ route('post.comment', $post->id) }}" method="POST" class="post-comments">
                                            @csrf
                                            <div class="d-flex align-items-start card-spacer-x py-4">
                                                <!--begin::User Photo-->
                                                <span class="symbol symbol-35 mr-3 mt-1">
                                                    @if($user->profile_picture != NULL)
                                                        <div class="symbol-label" style="background-image: url('media/users/{{ $user->profile_picture }}')"></div>
                                                    @else
                                                        <div class="symbol-label font-size-h3">{{ substr($user->first_name,0,1) }}</div>
                                                    @endif
                                                </span>
                                                <!--end::User Photo-->
                                                <!--begin::User Details-->
                                                <div class="d-flex flex-column flex-grow-1 flex-wrap mr-2">
                                                    <input class="w-100 border-0 p-3 input-post" name="comment_caption" placeholder="Add a comment...">
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <button type="submit" class="btn btn-primary btn-comment">Post</button>
                                                </div>
                                                <!--end::User Details-->
                                            </div>
                                            
                                        </form>
                                    </div>
            
            
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
            <div class="col-4">
                {{-- <div class="card card-custom gutter-b">
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
                                    <button class="btn btn-sm btn-primary my-2 btnFollow" style="float: right">Follow</button>
                                </div>
                            </div>
                            
                        @endforeach
                    </div>
                </div> --}}
            </div>
            {{-- End of Post Section --}}
        </div>
    </div>
</div>
@endsection
{{-- Styles Section --}}
@section('styles')
    <!-- the fileinput plugin styling CSS file -->
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.2/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
@endsection

{{-- Scripts Section --}}
@section('scripts')
    <!-- piexif.min.js is needed for auto orienting image files OR when restoring exif data in resized images and when you
    wish to resize images before upload. This must be loaded before fileinput.min.js -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.2/js/plugins/piexif.min.js" type="text/javascript"></script>
    <!-- the main fileinput plugin script JS file -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.2/js/fileinput.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#images').fileinput({
                showCaption: false,
                dropZoneEnabled: false,
                maxFileSize: 2000
            })

            $('#create-post').submit(function(e) {
                e.preventDefault()
                let $this = $(this)
                let formData = new FormData(this)
                $.ajax({
                    url: $this.attr('action'),
                    type: $this.attr('method'),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
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
                                    window.location.href = '{{ route("profile.index") }}';
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

            $('.post-comments').submit(function(e) {
                e.preventDefault()
                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
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
                                    window.location.href = '{{ route("profile.index") }}';
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
@endsection
