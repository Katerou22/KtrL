@section('nav-main')
    <nav class="nav-main">
        <ul class="mt-0">
            <li class="nav-dashboard {{ request()->is('cp') ? 'visible active' : '' }}">
                <a href="/" title="Here">
                    <span class="title">Here</span>
                </a>
            </li>
            {{--@foreach ($nav->children() as $item)--}}
                {{--<li class="section">{{ $item->title() }}</li>--}}
                {{--@include('partials.nav-main-items', ['items' => $item->children()])--}}
            {{--@endforeach--}}
        </ul>
    </nav>
@stop

@yield('nav-main')
