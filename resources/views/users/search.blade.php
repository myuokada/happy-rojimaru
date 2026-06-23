@extends('layouts.app')
@section('title', 'Search Results')
@section('content')
<div class="row justify-content-center">
    <div class="col-7">
        <p class="h5 text-muted mb-4">
            Search results for <span class="fw-bold">{{ $search }}</span>
        </p>

        {{-- ===== USERS ===== --}}
        <h6 class="text-uppercase text-muted mb-3">
            <i class="fa-solid fa-users me-1"></i> Users
        </h6>
        @forelse ($users as $user)
            <div class="row align-items-center mb-3">
                <div class="col-auto">
                    <a href="{{ route('profile.show', $user->id) }}">
                        @if ($user->avatar)
                            <img src="{{ $user->avatar }}" class="rounded-circle avatar-md" alt="{{ $user->name }}">
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
                <div class="col-auto">
                    @if ($user->id !== Auth::user()->id)
                        @if ($user->isFollowed())
                            <form action="{{ route('follow.destroy', $user->id) }}" method="post">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-secondary fw-bold btn-sm">Following</button>
                            </form>
                        @else
                            <form action="{{ route('follow.store', $user->id) }}" method="post">
                                @csrf
                                <button class="btn btn-primary btn-sm fw-bold">Follow</button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        @empty
            <p class="text-muted small mb-4">No users found.</p>
        @endforelse

        <hr class="my-4">

        {{-- ===== POSTS ===== --}}
        <h6 class="text-uppercase text-muted mb-3">
            <i class="fa-solid fa-newspaper me-1"></i> Posts
        </h6>
        @forelse ($posts as $post)
            <div class="mb-3">
                <a href="{{ route('post.show', $post->id) }}" class="text-decoration-none text-dark fw-bold">
                    {{ Str::limit($post->description, 60) }}
                </a>
                <p class="text-muted small mb-0">by {{ $post->user->name }}</p>
            </div>
        @empty
            <p class="text-muted small mb-4">No posts found.</p>
        @endforelse

        <hr class="my-4">

        {{-- ===== CATEGORIES ===== --}}
        <h6 class="text-uppercase text-muted mb-3">
            <i class="fa-solid fa-tags me-1"></i> Categories
        </h6>
        @forelse ($categories as $category)
            <span class="badge bg-secondary me-1 mb-1">{{ $category->name }}</span>
        @empty
            <p class="text-muted small">No categories found.</p>
        @endforelse

    </div>
</div>
@endsection
