{{-- clickable image --}}
<div class="container p-0">
    <a href="{{ route('post.show', $post->id) }}">
        <img src="{{ $post->image }}" alt="post id {{ $post->id }}" class="w-100">
    </a>
</div>
<div class="card-body">
    {{-- heart button + no.of likes --}}
    <div class="row align-items-center">
        <div class="col-auto">
            @if ($post->isLiked())
                <form action="{{ route('like.destroy', $post->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm shadow-none p-0">
                        <i class="fa-solid fa-heart text-danger"></i>
                    </button>
                </form>
            @else
                <form action="{{ route('like.store', $post->id) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-sm shadow-none p-0">
                        <i class="fa-regular fa-heart"></i>
                    </button>
                </form>
            @endif
        </div>
        <div class="col-auto px-0">
            <span>{{ $post->likes->count() }}</span>
        </div>
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
