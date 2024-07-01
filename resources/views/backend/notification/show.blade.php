<div id="notifications">
    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw"></i>
        <!-- Counter - Alerts -->
        <span class="badge badge-danger badge-counter">
            @if(count(Auth::user()->unreadNotifications) >99 )<span data-count="99" class="count">99+</span>
            @else 
                <span class="count" data-count="{{count(Auth::user()->unreadNotifications)}}">{{count(Auth::user()->unreadNotifications)}}</span>
            @endif
        </span>
      </a>
      <!-- Dropdown - Alerts -->
      <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header">
         Notifikasi
        </h6>
        @foreach(Auth::user()->unreadNotifications as $notification)
    <a class="dropdown-item d-flex align-items-center"   href="{{route('admin.notification',$notification->id)}}">
                <div class="mr-3">
                    <div class="icon-circle bg-primary">
                    <i class="fas {{$notification->data['fas']}} text-white"></i>
                    </div>
                </div>
                <div>
                    <div class="small text-gray-500">{{$notification->created_at->setTimezone('Asia/Jakarta')->format('d-m-Y')}}, {{$notification->created_at->setTimezone('Asia/Jakarta')->format('H:i')}}</div>
                    <span class="@if($notification->unread()) font-weight-bold @else small text-gray-500 @endif">{{$notification->data['title']}}</span>
                </div>
            </a>
            @if($loop->index+1==5)
                @php 
                    break;
                @endphp
            @endif
        @endforeach

        <a class="dropdown-item text-center small text-gray-500" href="{{route('all.notification')}}">Lihat Semua Notifikasi</a>
      </div>
</div>