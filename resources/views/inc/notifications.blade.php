{{-- System Notifications --}}
@can('other_systemNotifications')
<li class="dropdown align-self-center">
    <a href="#" class="nav-link" data-toggle="dropdown" aria-expanded="false"><i class="icon-reload h4"></i>

        @php
        $systemNotificationCount = App\Models\SystemNotifications::where('has_read', false)->count();

        $systemNotifications = [];
        if($systemNotificationCount >= 1 ) {
            $systemNotifications = App\Models\SystemNotifications::where('has_read', false)->orderBy('created_at', 'desc')->limit(20)->get();
        }
        @endphp

        @if ($systemNotificationCount >= 1)
        <span class="badge badge-default"> <span class="ring">
            </span><span class="ring-point">
            </span> </span>
        @endif

    </a>
    <ul class="dropdown-menu dropdown-menu-right border  py-0">

        @foreach ($systemNotifications as $notification)
        <li>
            <a class="dropdown-item px-2 py-2 border border-top-0 border-left-0 border-right-0" href="#">
                <div class="media">
                    {{-- <img src="{{asset('dist/images/author.jpg')}}" alt="" class="d-flex mr-3 img-fluid rounded-circle"> --}}
                    <div class="media-body">
                        <p class="mb-0"><strong>{{$notification['title']}}</strong></p>
                        <span>{{substr($notification['body'], 0, 50);}}...</span>
                    </div>
                </div>
            </a>
        </li>

        @endforeach



        <li><a class="dropdown-item text-center py-2" href="{{route('system.notifications')}}"> See All Notifications <i
                    class="icon-arrow-right pl-2 small"></i></a></li>
    </ul>

</li>
@endcan



{{-- User Notifications --}}
<li class="dropdown align-self-center d-inline-block">
    <a href="#" class="nav-link" data-toggle="dropdown" aria-expanded="false"><i class="icon-bell h4"></i>

        @php
        $userNotificationCount = Auth::user()->notifications()->where('has_read', false)->count();

        $userNotifications = [];
        if($userNotificationCount >= 1 ) {
            $userNotifications = Auth::user()->notifications()->where('has_read', false)->orderBy('created_at', 'desc')->limit(20)->get();
        }
        @endphp

        @if ($userNotificationCount >= 1)
        <span class="badge badge-default"> <span class="ring">
            </span><span class="ring-point">
            </span> </span>
        @endif

    </a>
    <ul class="dropdown-menu dropdown-menu-right border   py-0">

        @foreach ($userNotifications as $notification)
        <li>
            <a class="dropdown-item px-2 py-2 border border-top-0 border-left-0 border-right-0" href="#">
                <div class="media">
                    {{-- <img src="{{asset('dist/images/author.jpg')}}" alt="" class="d-flex mr-3 img-fluid rounded-circle"> --}}
                    <div class="media-body">
                        <p class="mb-0"><strong>{{$notification['title']}}</strong></p>
                        <span>{{substr($notification['body'], 0, 50);}}...</span>
                    </div>
                </div>
            </a>
        </li>

        @endforeach
        <li><a class="dropdown-item text-center py-2" href="{{route('user.notifications')}}"> Read All Message <i
                    class="icon-arrow-right pl-2 small"></i></a></li>
    </ul>
</li>
