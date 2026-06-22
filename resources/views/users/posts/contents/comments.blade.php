<div class="mt-3">
    {{-- Show all comments here --}}
    @if ($post->comments->isNotEmpty())
        <hr>
        {{-- call relationship ti show all comments (check Post Model) and check if its not empty --}}
        <ul class="list-group">
            @foreach ($post->comments->take(3) as $comment)
                <li class="list-group-item border-0 p-0 mb-2">
                    <a href="{{ route('profile.show', $comment->user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $comment->user->name }}</a>
                    &nbsp;
                    <p class="d-inline fw-bold">{{ $comment->body }}</p>

                    <form action="{{ route('comment.destroy', $comment->id) }}" method="post">
                        @csrf
                        @method('DELETE')

                        <span
                            class="text-uppercase text-muted xsmall
                                    ">{{ date('M d, Y', strtotime($comment->created_at)) }}</span>

                        {{-- If the AUTH user is the OWNER of the comment,show delete btn --}}
                        @if (Auth::user()->id === $comment->user->id)
                            &middot;
                            <button type="submit" class="border-0 bg-transparent  text-danger p-0 xsmall">
                                Delete
                            </button>
                        @endif
                    </form>
                </li>
            @endforeach

            {{-- もしコメント３以上だったらコメントのリンクに飛ばすよーのaタグつける --}}
            @if ($post->comments->count() > 3)
                <li class="list-group-item border-0 px-0 pt-0">
                    <a href="{{ route('post.show', $post->id) }}" class="text-decoration-none small">
                        View all {{ $post->comments->count() }} comments
                    </a>
                </li>
            @endif
        </ul>
    @endif

    <form action="{{ route('comment.store', $post->id) }}" method="post">
        @csrf

        <div class="input-group">
            {{-- in name attribute add the id of the specific post user commented --}}
            <textarea name="comment_body{{ $post->id }}" cols="30" rows="1" class="form-control form-control-sm"
                placeholder="Add comment...">{{ old('comment_body' . $post->id) }}</textarea>
            <button type="submit" class="btn btn-outline-secondary btn-sm" title="Post">
                <i class="fa-regular fa-paper-plane"></i>
            </button>
        </div>

        @error('comment_body' . $post->id)
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </form>
</div>
