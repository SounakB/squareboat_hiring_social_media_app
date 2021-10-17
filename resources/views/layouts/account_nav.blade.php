<ul class="account-nav">
    <li>
        <a href="{{url('feed')}}" class="btn btn-custom btn-secondary btn-round"> <i class="fas fa-newspaper"></i>
            Feed</a>
    </li>
    <li>
        <a href="{{url('settings')}}" class="btn btn-custom btn-secondary btn-round"> <i class="fas fa-cog"></i>
            Settings</a>
    </li>
    <li>
        <a href="{{url('profile/'.auth()->user()->username)}}" class="btn btn-custom btn-secondary btn-round"> <i
                class="fas fa-user"></i> Profile</a>
    </li>

    <li>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();" class="btn btn-custom btn-secondary btn-round"> <i class="fas fa-sign-out-alt"></i> Logout</a>
        </form>

    </li>

</ul>
