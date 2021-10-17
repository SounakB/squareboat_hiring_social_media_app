@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row pt-5">
            <div class="col-lg-4">
                <div class="border bg-light px-4 py-3">
                    <div class="row">
                        <div class="offset-3 col-6">
                            <div class="img-square image-single mb-lg-4 mb-2">
                                <a class="image-single">
                                    <img src="{{$user->profile_image == null ? asset('assets/images/icon/user.png') : url('uploads/'.$user->profile_image)}}"
                                        class="rounded-circle border">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="subtitle brand small">
                        <h2 class="mb-1" style="text-wrap: normal">{{$user->username}}</h2>
                        <p class="mb-2 small">{{$user->name}}</p>
                        @if($user->id != auth()->user()->id)

                        <div class="btn-group">
                            @if($following)
                                <button class="btn btn-primary mb-2 px-4" id="follow-btn" onclick="follow({{$user->id}})">
                                    <i class="fas fa-user-minus"></i> Unfollow
                                </button>
                            @else
                                <button class="btn btn-primary mb-2 px-4" id="follow-btn" onclick="follow({{$user->id}})">
                                    <i class="fas fa-user-plus"></i> Follow
                                </button>
                            @endif
                        </div>
                        @endif
                    </div>
                    <hr>

                </div>
                @if($user->bio !== null)
                <div class="border p-4 my-4">
                    <h3>About {{$user->username}}</h3>
                    <div class="expanding-text font-size-16 expanding-text-shadow"
                         style="height: 160px; position: relative; overflow: hidden;">
                        {{$user->bio}}
                    </div>
                </div>
                @endif
            </div>
            <div class="col-lg-8">
                @if(count($posts))
                <div class="activities">
                    Recent Updates
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
                @else
                    <div class="activities">
                    <h4>No recent updates from this user</h4>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('after-scripts')
    @include('components.post_actions')
    <script>
        function follow(id) {

            $.ajax({
                url: "{{url('follow')}}/" + id,
                method: "GET",
                success: function (data) {
                    console.log(data)
                    if (data.hasOwnProperty('followed')) {
                        //var btn_id = '#like-' + id + ' > .like-btn'
                        if (data.followed == 1) {
                            var html = `<i class="fas fa-user-minus"></i> Unfollow`
                            $('#follow-btn').html(html)
                        } else {
                            var html = `<i class="fas fa-user-plus"></i> Follow`
                            $('#follow-btn').html(html)
                        }
                    }
                }
            })
            /*.done(function( msg ) {
            console.log( "Data Saved: " + msg );
        });*/
        }
    </script>
@endsection
