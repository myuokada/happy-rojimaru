<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | @yield('title')</title>
    {{-- remove , laravel,change to  | @yield('title') --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- fontawesome cdn これも追加した -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- CSSと繋げるのに追加した,publicに入ってるのはassetを使う --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    {{-- ↓ カラー追加 --}}
    @auth
        @php
            $colors = auth()->user()->profile_colors ?? ['#667eea', '#764ba2'];
            $c1 = $colors[0];
            $c2 = $colors[1] ?? $colors[0];
            $c3 = $colors[2] ?? ($colors[1] ?? $colors[0]);
        @endphp

        <style>
            body {
                background: linear-gradient(180deg, {{ $c1 }}, {{ $c2 }}, {{ $c3 }});
                background-attachment: fixed;
                min-height: 100vh;
            }
        </style>

        <script>
            window.addEventListener('scroll', () => {
                // 角度は固定、色の位置だけスクロールに応じてずらす
                const p = window.scrollY / (document.body.scrollHeight - window.innerHeight);
                const stop2 = Math.round(30 + p * 40); // 中間色の位置が動く
                document.body.style.background =
                    `linear-gradient(180deg, {{ $c1 }} 0%, {{ $c2 }} ${stop2}%, {{ $c3 }} 100%)`;
                document.body.style.backgroundAttachment = 'fixed';
            });
        </script>
    @endauth
    {{-- ↑ カラー背景ここまで --}}
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <h1 class="h5 mb-0">{{ config('app.name') }}</h1>
                    {{-- <h1 class="h5 mb-0">ここ追加した --}}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    {{-- [SOON] Search bar here. --}}
                    @auth
                        {{-- search is only available for logged in users --}}
                        @if (!request()->is('admin/*'))
                            {{-- This wil. not show up in the admin pages --}}
                            {{-- -------------------------<ul class="navbar-nav ms-auto">
                                <form action="{{ route('search')}}" style="width: 300px">
                                    <input type="search" name="search" class="form-control form-control-sm" placeholder="Search...">
                                </form>
                            </ul> -------------------------------- --}}
                        @endif
                    @endauth

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @auth
                            {{-- ログイン中のユーザーにだけ検索を表示 --}}

                            {{-- 検索フォーム（最初は非表示 → 虫眼鏡ボタンで左に出てくる） --}}
                            {{-- collapse → Bootstrapが自動で表示/非表示を切り替えてくれる --}}
                            <div class="collapse w-100" id="searchForm">
                                <form action="{{ route('search') }}" class="d-flex justify-content-end py-1">
                                    <input type="search" name="search" class="form-control form-control-sm"
                                        style="width: 300px" placeholder="Search users, posts...">
                                </form>
                            </div>

                            <ul class="navbar-nav ms-auto me-1">
                                <li class="nav-item">
                                    <button class="btn shadow-none nav-link" data-bs-toggle="collapse"
                                        data-bs-target="#searchForm" title="Search">
                                        {{-- data-bs-toggle="collapse" → Bootstrapの折りたたみ機能を使う --}}
                                        {{-- data-bs-target="#searchForm" → id="searchForm"の要素を開閉する --}}
                                        {{-- 虫眼鏡ボタン --}}
                                        <i class="fa-solid fa-magnifying-glass text-dark icon-sm"></i>
                                    </button>
                                </li>
                            </ul>
                        @endauth
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            {{-- earth House icon --}}
                            <li class="nav-item" title="earth">
                                <a href="{{ route('index') }}" class="nav-link">
                                    <i class="fa-solid fa-earth-americas text-dark icon-sm"></i>
                                </a>
                            </li>

                            {{-- Home House icon --}}
                            <li class="nav-item" title="Home">
                                <a href="{{ route('index') }}" class="nav-link">
                                    <i class="fa-solid fa-house text-dark icon-sm"></i>
                                </a>
                            </li>

                            {{-- Create Post icon --}}
                            <li class="nav-item" title="Create Post">
                                <a href="{{ route('post.create') }}" class="nav-link">
                                    <i class="fa-solid fa-circle-plus text-dark icon-sm"></i>
                                </a>
                            </li>

                            {{-- User avatar iconにdropdown追加してる --}}
                            <li class="nav-item dropdown">
                                <button id="account-dropdown" class="btn shadow-none nav-link" data-bs-toggle="dropdown">
                                    @if (Auth::user()->avatar)
                                        <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}"
                                            class="rounded-circle avatar-sm">
                                    @else
                                        <i class="fa-solid fa-circle-user text-dark icon-sm"></i>
                                    @endif
                                </button>

                                {{-- ⇩button id="account-dropdown"とリンク --}}
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="account-dropdown">
                                    {{-- [SOON] Admin Controls @canの追加 --}}
                                    @can('admin')
                                        {{-- @if (Gate::allows('admin')) --}}
                                        <a href="{{ route('admin.users') }}" class="dropdown-item">
                                            <i class="fa-solid fa-user-gear"></i> Admin
                                        </a>

                                        <hr class="dropdown-divider">
                                        {{-- @endif --}}
                                    @endcan


                                    {{-- Profile icon button --}}
                                    <a href="{{ route('profile.show', Auth::user()->id) }}" class="dropdown-item">
                                        <i class="fa-solid fa-circle-user"></i> Profile
                                    </a>

                                    {{-- Logout icon button --}}
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fa-solid fa-right-from-bracket"></i>{{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    {{-- [SOON ADMIN MENU (COOL=3)] --}}
                    @if (request()->is('admin/*'))
                        {{-- request()->is() -  check the URL PATH --}}
                        <div class="col-3">
                            <div class="list-group">
                                <a href="{{ route('admin.users') }}"
                                    class="list-group-item {{ request()->is('admin/users') ? 'active' : '' }}">
                                    {{-- bootstrapの機能？'active' : '' --}}
                                    <i class="fas fa-users"></i> Users
                                </a>
                                <a href="{{ route('admin.posts') }}"
                                    class="list-group-item {{ request()->is('admin/posts') ? 'active' : '' }}">
                                    <i class="fa-solid fa-newspaper"></i> Posts
                                </a>
                                {{-- 後でここ追加 --}}
                                <a href="{{ route('admin.categories.index') }}"
                                    class="list-group-item {{ request()->is('admin/categories') ? 'active' : '' }}">
                                    <i class="fa-solid fa-tags"></i> Categories
                                </a>
                            </div>
                        </div>
                    @endif

                    <div class="col-9">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
