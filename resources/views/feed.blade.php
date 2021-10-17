@extends('layouts.master')

@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    @include('layouts.account_nav')
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->

    <!--section start-->
    <section class="login-page section-b-space">
        <div class="container dashboard-container">
            @if(Session::has('success'))
                <div class="alert alert-success">

                    {{ Session::get('success')}}
                </div>
            @endif
            <div class="row">
                <div class="col-lg-8">
                    <h3>Activity <span class="small brand">What's happening?</span></h3>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="">
                        <form class="post-form" method="POST" action="{{ url('add-post') }}"
                              enctype="multipart/form-data">
                            @csrf

                            <textarea class="form-control post-input" name="text"></textarea>
                            <div id="imgPreviewContainer">
                            </div>

                            <!-- Hide this from the users view with css display:none; -->
                            <input class="display-none" id="imgInp" type="file" accept="image/*" name="image"/>
                            <div class="post-btn-grp">
                                <button class="btn" id="browse-click"><i class="fas fa-image"></i></button>
                                <button type="submit" class="btn btn-pink">Post</button>
                            </div>
                        </form>
                    </div>

                    <div class="activities">
                        <hr>
                        @foreach($posts as $post)
                            <div class="row activity-item" id="activity-{{$post->id}}">
                                <div class="col-md-1 col-2 pr-1">
                                    <div class="row">
                                        <div class="user-circle col-lg-12 col-12 px-2 mb-2">
                                            <div class="img-square" >
                                                <a href="{{ url('profile/'.$post->user->username) }}">
                                                    <img class="shadow-sm img-fluid mb-3 main rounded-circle border"
                                                         src="{{$post->user->profile_image == null ? asset('assets/images/icon/user.png') : url('uploads/'.$post->user->profile_image)}}">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-11 col-10">
                                    <p class="mb-1"><a
                                            href="{{ url('profile/'.$post->user->username) }}">{{$post->user->username}}</a>

                                    @if($post->text != null && $post->text != '')
                                        <div class="message-left p-2 small expanding-text">
                                            {{$post->text}}
                                        </div>
                                    @endif
                                    @if($post->image != null && $post->image != '')
                                        <div class="row">
                                            <div class="col-md-3 col-5">
                                                <div class="img-square my-2">

                                                        <img
                                                            src="{{url('uploads/'.$post->image)}}"
                                                            class="img-thumbnail"/>

                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-3 col-5">
                                        </div>
                                    </div>
                                    <div class="mt-2 mb-0 ">
                                        <span class="show-activity-comments cursor-pointer"
                                              onclick="show_comments({{$post->id}})"><span
                                                class="comments-count">{{$post->comments->count()}}</span> <i
                                                class="far fa-comment"></i></span> <span
                                            class="small mx-1 text-light">|</span>
                                        @php
                                            $icn_class = "fas";
                                            if( App\Models\Like::where(['user_id' => auth()->user()->id, 'post_id' => $post->id])->count() == 0){
                                                $icn_class = "far";
                                            }
                                        @endphp

                                        <span class="like-activity cursor-pointer "
                                              onclick="like({{$post->id}})" id="like-{{$post->id}}"><i
                                                class="{{ $icn_class }} fa-heart like-btn"></i></span>
                                        <span class="likes-count mr-2">{{$post->likes->count()}}</span>


                                    </div>
                                    <div class="activity-comments hide display-none" id="comment-list-{{$post->id}}">
                                        <div class="bg-light py-3 px-2 mt-2 mb-1 border-bottom border-top row">
                                            <input class="form-control col-md-8" id='inputComment-{{$post->id}}'>
                                            <button type="submit" class="btn btn-pink col-md-2"
                                                    onclick="add_comment({{$post->id}})">Comment <i
                                                    class="fas fa-paper-plane"></i>
                                            </button>
                                        </div>
                                        <div class="comments-list">
                                            <div class="row px-3 comment_rows">
                                                @foreach($post->comments as $comment)
                                                    <div class="col-lg-1 col-2 px-2">
                                                        <div class="img-square">
                                                            <a href="{{ url('profile/'.$comment->user->username) }}">
                                                                <img
                                                                    class="rounded-circle object-fit-cover border img-fluid"
                                                                    src="{{$comment->user->profile_image == null ? asset('assets/images/icon/user.png') : url('uploads/'.$comment->user->profile_image)}}"
                                                                    alt="YJ">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-11 col-10 px-2 pt-1">
                                                        <a href="{{ url('profile/'.$comment->user->username) }}">{{$comment->user->username}}</a>
                                                        {{$comment->comment}}
                                                    </div>
                                                @endforeach

                                            </div>
                                            <hr class="my-1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4 ">

                </div>
            </div>
        </div>
    </section>
    <!--Section ends-->
@endsection
@section('after-scripts')

    @include('components.post_actions')
@endsection
