<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    // define IDS for the roles
    const ADMIN_ROLE_ID = 1;

    const USER_ROLE_ID = 2;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    #To get all the posts of a user
    // ここ追加したところ
    public function posts() {
        return $this->hasMany(Post::class)->latest();
    }

    // もしアプリの機能で、「マイページに、自分が過去に書いたコメント一覧を表示したい！」 という画面を作るなら
    // hasMany(Comment::class)のやついる⇩まさにこれ

    public function followers() {
        return $this->hasMany(Follow::class, 'following_id');
    }

    // To get all the users that the user is following
    public function following() {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    # Returns TRUE if the AUTH already followed the user
    public function isFollowed() {
        return $this->followers()->where('follower_id', Auth::user()->id)->exists();
        // get all the followers of the user($this->followers()).Then from the list, search for the AUTH USER from follower column (where('follower_id).AUTH::user()->id))
    }

    public function likes() {
        return $this->hasMany(like::class);
    }

}
