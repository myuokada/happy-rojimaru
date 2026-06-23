@extends('layouts.app')

@section('title', 'Explore People')

@section('content')
    <div class="row justify-content-center">
        <div class="col-5">

            <p class="h5 text-muted mb-4">Search results for <span class="fw-bold">{{ $search }}</span></p>

            @forelse ($users as $user)
                <div class="row align-items-center mb-3">
                    <div class="col-auto">
                        <a href="{{ route('profile.show', $user->id) }}">
                            @if ($user->avatar){{-- アイコン（左側） --}}
                                <img src="{{ $user->avatar }}" alt=" {{ $user->name }}" class="rounded-circle avatar-md">
                            @else
                                <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                            @endif
                        </a>
                    </div>

                    <div class="col ps-0 text-truncate">
                        <a href="{{ route('profile.show', $user->id) }}"
                            class="text-decoration-none text-dark fw-bold">{{ $user->name }}</a>
                        <p class="text-muted mb-0">{{ $user->email }}</p>
                    </div>
                    <div class="col-auto">{{-- フォロー/フォロー解除ボタン（右側）--}}
                        @if ($user->id !== Auth::user()->id) {{-- 自分自身にはフォローボタンを表示しない--}}
                            @if ($user->isFollowed()){{-- 相手フォロー済か否かでボタンの色と、送信機能（保存か削除か）を自動で切り替え--}}
                                <form action="{{ route('follow.destroy', $user->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="btn btn-outline-secondary fw-bold btn-sm">Following</button>
                                </form>
                            @else
                                <form action="{{ route('follow.store', $user->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm fw-bold">Follow</button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            @empty {{-- 検索結果ゼロのメッセージ --}}
                <p class="lead text-muted text-center">No users found.</p>
            @endforelse
        </div>
    </div>
@endsection
