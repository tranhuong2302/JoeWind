@if(auth()->user()->checkPermissionAccess($permissions_list) == true)
<li class="nav-item">
    <a class="nav-link {{$active_list}}" href="{{$url_list}}"><i class="{{$class_list}}"></i> List {{$models}}</a>
</li>
@endif
@if(auth()->user()->checkPermissionAccess($permission_create) == true)
<li class="nav-item">
    <a class="nav-link {{$active_create}}" href="{{$url_create}}">
        <i style="font-size: 24px;" class="{{$class_create}}"></i>Create {{$model}}
    </a>
</li>
@endif
