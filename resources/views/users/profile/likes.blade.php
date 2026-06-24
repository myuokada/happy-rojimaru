@extends('layouts.app')

@section('title', 'Likes')

@section('content')
    @include('users.profile.header')

    <div style="margin-top: 30px">
        @if ($likes->isNotEmpty())
            <div class="row justify-content-center">
                <div class="col-5">
                    <h3 class="text-secondary text-center mb-4">Liked</h3>

                    @foreach ($likes as $like)
                        <div class="row align-items-center mt-3">
                            <div class="col-auto">
                                @if (($like->post?->likes?->count() ?? 0) > 1)
                                    <div class="position-relative" style="width: 55px; height: 45px;">
                                        {{-- 1枚目：この通知の主 --}}
                                        @if ($like->user?->avatar)
                                            <img src="{{ $like->user->avatar }}"
                                                class="rounded-circle position-absolute border border-white"
                                                style="width: 35px; height: 35px; top: 0; left: 0; z-index: 2;">
                                        @else
                                            <i class="fa-solid fa-circle-user text-secondary position-absolute"
                                                style="font-size: 35px; top: 0; left: 0; z-index: 2;"></i>
                                        @endif

                                        {{-- 2枚目：【修正】1枚目の人(user_id)とは「違う人」のいいねを狙い撃ちして表示！ --}}
                                        @if ($like->post?->likes->where('user_id', '!=', $like->user_id)->first()?->user?->avatar)
                                            <img src="{{ $like->post->likes->where('user_id', '!=', $like->user_id)->first()->user->avatar }}"
                                                class="rounded-circle position-absolute border border-white"
                                                style="width: 35px; height: 35px; bottom: 0; right: 0; z-index: 1;">
                                        @else
                                            <i class="fa-solid fa-circle-user text-muted position-absolute"
                                                style="font-size: 35px; bottom: 0; right: 0; z-index: 1; opacity: 0.6;"></i>
                                        @endif
                                    </div>
                                @else
                                    {{-- 1人だけの時はスッキリ1枚表示 --}}
                                    <a href="{{ route('profile.show', $like->user?->id ?? $like->user_id) }}">
                                        @if ($like->user?->avatar)
                                            <img src="{{ $like->user->avatar }}" class="rounded-circle border border-white"
                                                style="width: 44px; height: 44px; object-fit: cover;">
                                        @else
                                            <i class="fa-solid fa-circle-user text-secondary" style="font-size: 44px;"></i>
                                        @endif
                                    </a>
                                @endif
                            </div>
                            <div class="col ps-3">
                                <a href="{{ route('profile.show', $like->user?->id ?? $like->user_id) }}"
                                    class="text-decoration-none text-dark fw-bold">
                                    {{ $like->user?->name ?? 'Someone' }}
                                </a>

                                @if (($like->post?->likes?->count() ?? 0) > 1)
                                    <span class="text-muted"> and <strong
                                            class="text-dark">{{ $like->post->likes->count() - 1 }}
                                            {{ $like->post->likes->count() - 1 == 1 ? 'other' : 'others' }}</strong> liked
                                        your post.</span>
                                @else
                                    <span class="text-muted"> liked your post.</span>
                                @endif
                            </div>
                            <div class="col-auto text-end">
                                @if ($like->post?->id)
                                    <a href="{{ route('post.show', $like->post->id) }}">
                                        @if ($like->post->image)
                                            <img src="{{ $like->post->image }}" alt="Post Image"
                                                class="img-thumbnail p-0 border-0"
                                                style="width: 44px; height: 44px; object-fit: cover;">
                                        @else
                                            <i class="fa-regular fa-image text-secondary icon-sm"></i>
                                        @endif
                                    </a>
                                @else
                                    <i class="fa-regular fa-image text-muted icon-sm" style="font-size: 30px;"></i>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    {{-- 10件以上ある場合だけSee moreボタンを出す --}}
                    @if ($has_more)
                        <div class="text-center mt-4">
                            <a href="{{ route('profile.likes', ['id' => $user->id, 'show_all' => 1]) }}"
                                class="text-decoration-none fw-bold text-secondary">
                                See more...
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <h3 class="text-secondary text-center mx-auto">No likes</h3>
        @endif
    </div>
@endsection
