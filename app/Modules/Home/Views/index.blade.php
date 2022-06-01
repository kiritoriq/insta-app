@extends('layout.default')
@section('title', 'Dashboard')
@section('content')
<div class="d-flex flex-column-fluid">
    <div class="container">
        {{-- End Of Profile Section --}}
        <div class="row">
            {{-- Post Section --}}
            <div class="col-8">
                <div class="card card-custom gutter-b">
                    <form method="POST" action="{{ route('post.store') }}" id="create-post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <textarea class="form-control" name="post_caption" id="caption" cols="30" rows="5" placeholder="What's your thought?"></textarea>
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
                        You didn't post anything yet
                    @else
                        @foreach($posts as $index => $post)
                            <div class="card">
                                <div class="card-header align-items-center flex-wrap justify-content-between border-0 py-6 h-auto">
                                    <!--begin::Left-->
                                    <div class="d-flex align-items-center my-2">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-35 mr-3">
                                                @if(Auth::user()->profile_picture != NULL)
                                                    <div class="symbol-label" style="background-image: url('media/users/{{ Auth::user()->profile_picture }}')"></div>
                                                @else
                                                    <div class="symbol-label font-size-h3">{{ substr(Auth::user()->first_name,0,1) }}</div>
                                                @endif
                                            </div>
                                            <a href="#" class="text-dark-75 font-size-lg text-hover-primary font-weight-bolder">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a>
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
                                                <button type="button" class="btn p-0 btn-likes" title="Like this post" data-post-id="{{ $post->id }}">
                                                    @if(in_array(Auth::user()->id, array_column($post->postLikes->toArray(), 'user_id')))
                                                        <i class="flaticon-like" style="color: #0f7aff"></i>
                                                    @else
                                                        <i class="flaticon-like"></i>
                                                    @endif
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
                                                    @if(Auth::user()->profile_picture != NULL)
                                                        <div class="symbol-label" style="background-image: url('media/users/{{ Auth::user()->profile_picture }}')"></div>
                                                    @else
                                                        <div class="symbol-label font-size-h3">{{ substr(Auth::user()->first_name,0,1) }}</div>
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
                @include('Profile::suggestions')
            </div>
            {{-- End of Post Section --}}
    </div>
</div>
@endsection
{{-- Styles Section --}}
@section('styles')
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.2/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
@endsection

{{-- Scripts Section --}}
@section('scripts')
    <!-- piexif.min.js is needed for auto orienting image files OR when restoring exif data in resized images and when you
    wish to resize images before upload. This must be loaded before fileinput.min.js -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.2/js/plugins/piexif.min.js" type="text/javascript"></script>
    <!-- the main fileinput plugin script JS file -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.2/js/fileinput.min.js"></script>

    {{-- page scripts --}}
    <script type="text/javascript">

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
                                    window.location.href = '{{ route("dashboard.index") }}';
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
                                    window.location.href = '{{ route("dashboard.index") }}';
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

            $('.btn-likes').click(function(e) {
                e.preventDefault()
                let postId = $(this).attr('data-post-id')
                let url = '{{ url("post/like") }}/' + postId
                $.ajax({
                    url: url,
                    type: 'POST',
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
                                    window.location.href = '{{ route("dashboard.index") }}';
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
