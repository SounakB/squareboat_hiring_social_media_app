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
        <div class="container">
            @if(Session::has('success'))
                <div class="alert alert-success">

                    {{ Session::get('success')}}

                </div>
            @endif
            <div class="row">
                <div class="col-lg-8">
                    <h3>Update your account</h3>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="theme-card">
                        <form class="theme-form" method="POST" action="{{ url('update-profile') }}"
                              enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input id="name" type="name" class="form-control @error('name') is-invalid @enderror"
                                       name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Username</label>
                                <input id="username" class="form-control @error('username') is-invalid @enderror"
                                       name="username" value="{{ $user->username }}" required autocomplete="username">

                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group image-input-group">
                                <div class="row ">
                                    <div class="col-md-8">
                                        <label for="profile_image">Profile Picture</label>
                                        <input id="profile_image" type="file" accept="image/"
                                               class="form-control @error('profile_image') is-invalid @enderror"
                                               name="profile_image">

                                        @error('profile_image')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <img class="current-profile-pic"
                                            src="{{$user->profile_image == null ? asset('assets/images/icon/user.png') : url('uploads/'.$user->profile_image)}}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="bio">Bio</label>
                                <textarea id="bio" type="email" class="form-control @error('bio') is-invalid @enderror"
                                          name="bio">{{ $user->bio }}</textarea>

                                @error('bio')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ $user->email }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror" name="password"
                                       autocomplete="off"
                                       placeholder="Please leave blank if you do not want to change your password. Use minimum 8 characters">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">UPDATE SETTINGS</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 right-login">

                </div>
            </div>
        </div>
    </section>
    <!--Section ends-->
@endsection
