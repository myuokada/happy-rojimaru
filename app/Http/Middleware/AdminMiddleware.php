<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // 💡 ここを「Facades\Auth」に微調整しました！
use App\Models\User;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 💡 もし「ログインしていて」、かつ「管理者（ADMIN）」だったら…

        if (Auth::check() && Auth::user()->role_id == User::ADMIN_ROLE_ID) {
        // Auth::check() - returns TRUE if the user is logged into the application
        // Check if AUTH USER'S role ID is equal to the defined ADMIN ROLE ID in USER Model
            return $next($request); // ⭕️ 次の処理（コントローラー）に進んでいいよ！
            // proceed ti NEXT REQUEST (CONTROLLER)
        }
        return redirect()->route('index');
    }
}
