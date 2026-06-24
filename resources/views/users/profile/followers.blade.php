@extends('layouts.app')

@section('title', 'Followers')

@section('content')
    @include('users.profile.header')

    <div style="margin-top: 30px">
        @if ($user->followers->isNotEmpty())
            <div class="row justify-content-center">
                <div class="col-4">
                    <h3 class="text-secondary text-center mb-4">Followers</h3>

                    @foreach ($user->followers as $follower)
                        {{-- 💡 w-100 と mx-auto で横幅のブレを完全に固定します --}}
                        <div class="row align-items-center mt-3 w-100 mx-auto">

                            {{-- 左端：アバターエリア（幅2をキープ） --}}
                            <div class="col-2 p-0 text-center">
                                <a href="{{ route('profile.show', $follower->follower->id) }}">
                                    @if ($follower->follower->avatar)
                                        <img src="{{ $follower->follower->avatar }}" alt="{{ $follower->follower->name }}"
                                            class="rounded-circle avatar-sm">
                                    @else
                                        <i class="fa-solid fa-circle-user text-secondary" style="font-size: 30px;"></i>
                                    @endif
                                </a>
                            </div>

                            {{-- 真ん中：ユーザー名（幅6に固定して左詰めに） --}}
                            <div class="col-6 ps-2 text-truncate text-start">
                                <a href="{{ route('profile.show', $follower->follower->id) }}"
                                    class="text-decoration-none text-dark fw-bold">
                                    {{ $follower->follower->name }}
                                </a>
                            </div>

                            {{-- 右端：フォローボタン（幅4に固定して右寄せに） --}}
                            <div class="col-4 p-0 text-end">
                                @if ($follower->follower->id != Auth::user()->id)
                                    @if ($follower->follower->isFollowed())
                                        <form action="{{ route('follow.destroy', $follower->follower->id) }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn-sm border-0 bg-transparent p-0 text-secondary fw-bold">
                                                Following
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('follow.store', $follower->follower->id) }}"
                                            method="post">
                                            @csrf
                                            <button type="submit"
                                                class="btn-sm border-0 bg-transparent p-0 text-primary fw-bold">
                                                Follow
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <h3 class="text-secondary text-center mx-auto">No Followers</h3>
        @endif
    </div>
@endsection
