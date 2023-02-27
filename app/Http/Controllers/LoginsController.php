<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\User;
use Illuminate\View\View;

class LoginsController extends Controller {
    /**
     * Display the user's profile form.
     */
    public function index(): View {
        return view('logins.index', [
            'users' => User::addSelect([
                    'last_login_at' => Login::select('created_at')
                        ->whereColumn('user_id', 'users.id')
                        ->latest()
                        ->take(1)
                ])
                ->withCasts(['last_login_at' => 'datetime'])
                ->orderBy('name')
                ->paginate()
        ]);
    }
}
