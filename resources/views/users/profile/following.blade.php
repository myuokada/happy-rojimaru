@extends('layouts.app')

@section('title', 'Following')

@section('content')
    @include('users.profile.header')

    <div style="margin-top: 30px">
        @if ($user->following->isNotEmpty())
            <div class="row justify-content-center">
                <div class="col-4">
                    <h3 class="text-secondary text-center mb-4">Following</h3>

                    @foreach ($user->following as $following)
                        <div class="row align-items-center mt-3 w-100 mx-auto">
                            <div class="col-2 p-0 text-center">
                                <a href="{{ route('profile.show', $following->following->id) }}">
                                    @if ($following->following->avatar)
                                        <img src="{{ $following->following->avatar }}" alt="{{ $following->following->name }}"
                                            class="rounded-circle avatar-sm">
                                    @else
                                        <i class="fa-solid fa-circle-user text-secondary" style="font-size: 30px;"></i>
                                    @endif
                                </a>
                            </div>

                            <div class="col-6 ps-2 text-truncate text-start">
                                <a href="{{ route('profile.show', $following->following->id) }}"
                                    class="text-decoration-none text-dark fw-bold">
                                    {{ $following->following->name }}
                                </a>
                            </div>

                            <div class="col-4 p-0 text-end">
                                @if ($following->following->id != Auth::user()->id)
                                    @if ($following->following->isFollowed())
                                        <form action="{{ route('follow.destroy', $following->following->id) }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn-sm border-0 bg-transparent p-0 text-secondary fw-bold">
                                                Following
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('follow.store', $following->following->id) }}"
                                            method="post">
                                            @csrf
                                            <button type="submit" class="btn-sm border-0 bg-transparent p-0 text-primary fw-bold">
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
            <h3 class="text-secondary text-center mx-auto">No Following</h3>
        @endif
    </div>
@endsection
