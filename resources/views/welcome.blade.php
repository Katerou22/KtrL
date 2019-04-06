<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width">
    <meta id="csrf-token" value="{{ csrf_token() }}"/>
    <meta name="robots" content="noindex,nofollow">
    <title>{{ 'Salam' or '' }} | Statamic</title>
    <link href="/dashboard/css/cp.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Noto+Serif:400,400i,700,700i" rel="stylesheet">


</head>

<body id="statamic" class="nav-visible">


<nav class="nav-mobile">
    <a href="/" class="logo">
        Hey
    </a>
    <a @click.prevent="toggleNav" class="toggle">
        <span class="icon icon-menu"></span>
    </a>
</nav>

<div class="sneak-peek-wrapper">
    <div class="sneak-peek-viewport">
        <i class="icon icon-circular-graph animation-spin"></i>
        <div class="sneak-peek-resizer" @mousedown="sneakPeekResizeStart"></div>
        <div class="sneak-peek-iframe-wrap" id="sneak-peek"></div>
    </div>
</div>

{{--@include('partials.shortcuts')--}}
{{--@include('partials.alerts')--}}
@include('partials.global-header')

<div class="application-grid @yield('content-class')">
    @include('partials.nav-main')

    <div class="content">
        <div class="page-wrapper">
            <div class="sneak-peek-header flexy">
                <h1 class="fill">{{ trans('cp.sneak_peeking') }}</h1>
                <button class="btn btn-primary" @click="stopPreviewing">{{ trans('cp.done') }}</button>
            </div>
            @yield('content')
        </div>
    </div>


    <vue-toast v-ref:toast></vue-toast>
</div>


@include('partials.scripts')
@yield('scripts')
</body>
</html>
