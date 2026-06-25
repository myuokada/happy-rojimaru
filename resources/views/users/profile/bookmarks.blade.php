@extends('layouts.app')

@section('title', 'Saved Posts')

@section('content')
    @include('users.profile.header')

    <div style="margin-top: 30px">
        @if ($bookmarks->isNotEmpty())
            <div class="row">
                @foreach ($bookmarks as $bookmark)
                    @if($bookmark->post)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <a href="{{ route('post.show', $bookmark->post->id) }}">
                                <img src="{{ $bookmark->post->image }}" alt="post id {{ $bookmark->post->id }}" class="grid-img w-100">
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <h3 class="text-muted text-center py-5">No Saved Posts Yet</h3>
        @endif
    </div>
@endsection
