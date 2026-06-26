{{-- clickable image --}}
<div class="container p-0">
    <a href="{{ route('post.show', $post->id) }}">
        <img src="{{ $post->image }}" alt="post id {{ $post->id }}" class="w-100">
    </a>
</div>
<div class="card-body">
    {{-- heart button + no.of likes --}}
    <div class="row align-items-center">
        <div class="col-auto pe-1">
            <button class="like-btn btn btn-sm shadow-none p-0 pe-0" data-id="{{ $post->id }}">
                <i class="fa-solid fa-heart
                    {{ $post->isLiked() ? 'text-danger' : 'text-secondary' }}">
                </i>
            </button>
        </div>
        <div class="col-auto p-0">
            <span>{{ $post->likes->count() }}</span>
        </div>
        {{-- ここからbookmark --}}
        <div class="col-auto ps-2 ms-1">
            @if (Auth::user()->isBookmarked($post->id))
                <form action="{{ route('bookmark.destroy', $post->id) }}" method="post" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm shadow-none p-0">
                        <i class="fa-solid fa-bookmark text-primary"></i>
                    </button>
                </form>
            @else
                <form action="{{ route('bookmark.store', $post->id) }}" method="post" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm shadow-none p-0">
                        <i class="fa-regular fa-bookmark text-secondary"></i>
                    </button>
                </form>
            @endif
        </div>
        <div class="col-auto">
<livewire:like-button :post="$post" :key="$post->id" />        </div>
        <div class="col text-end">
            @foreach ($post->categoryPost as $category_post)
                {{-- call the relationship to get how many categories under a post (Post Model - categoryPost) --}}
                <div class="badge bg-secondary bg-opacity-50">
                    {{ $category_post->category->name }}
                    {{-- ここのnameをidにしたらadminに登録したidの番号に切り替わる --}}
                    {{-- to get the name of the category, check categoryPost model and call category method relationship --}}
                </div>
            @endforeach
            @if ($post->categoryPost->isEmpty())
                <span class="badge bg-dark text-white">Uncategorized</span>
            @endif
        </div>
    </div>
    {{-- owner + description --}}
    <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark fw-bold">
        {{ $post->user->name }}
    </a>
    <p class="d-inline fw-light">{{ $post->description }}</p>
    &nbsp;
    <p class="text-uppercase text-muted xsmall">{{ date('M d,Y', strtotime($post->created_at)) }}</p>
    {{-- strtotime->string to time（文字から時間へ）の略 --}}

    {{-- include comments here --}}
    @include('users.posts.contents.comments')
</div>


