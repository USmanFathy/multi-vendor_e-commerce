<div>
    <!-- Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less. - Marie Curie -->
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            @if($newCount)
            <span class="badge badge-warning navbar-badge">{{$newCount}}</span>
            @endif
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-header">{{$newCount}} Notifications</span>
            @foreach($notifications as $notification)
            <div class="dropdown-divider"></div>
            <a href="{{$notification->data['url']}}?notification_id= {{$notification->id}}" class="dropdown-item @if($notification->unread()) text-bold @endif">
                <i class="{{$notification->data['icon']}} mr-2"></i> {{$notification->data['message']}}
                <span class="float-right text-muted text-sm">{{$notification->created_at->diffForHumans()}}</span>
            </a>
            @endforeach

            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
    </li>

</div>
