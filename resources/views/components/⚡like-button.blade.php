<?php

use Livewire\Component;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    public $post;
    public $liked;
    public $likesCount;

    public function mount($post)
    {
        $this->post = $post;

        $this->liked = Like::where('user_id', Auth::id())
            ->where('post_id', $post->id)
            ->exists();

        $this->likesCount = $post->likes()->count();
    }

    public function toggle()
    {
        $like = Like::where('user_id', Auth::id())
            ->where('post_id', $this->post->id)
            ->first();
    if ($like) {
        Like::where('user_id', Auth::id())
            ->where('post_id', $this->post->id)
            ->delete();

        $this->liked = false;

        $this->dispatch('unliked');

    } else {
        Like::create([
            'user_id' => Auth::id(),
            'post_id' => $this->post->id,
        ]);

        $this->liked = true;

        $this->dispatch('liked');
    }

     $this->likesCount = Like::where(
        'post_id',
        $this->post->id
    )->count();
    }
};
?>

<div class="d-flex align-items-center">
    <button
        wire:click="toggle"
        class="btn btn-sm shadow-none p-0"
    >
        <i class="fa-solid fa-heart {{ $liked ? 'text-danger' : 'text-secondary' }}"></i>
    </button>

    <span class="ms-2">
        {{ $likesCount }}
    </span>
</div>
