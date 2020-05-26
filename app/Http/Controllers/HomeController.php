<?php

namespace App\Http\Controllers;

use App\Category;
use App\User;
use App\Poll;
use App\Log;
use Illuminate\Http\Request;

class HomeController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        if (auth()->user()->role == 1) {
            $categories_count = Category::all()->count();
            $users_count = User::all()->count();
            $logs_count = Log::all()->count();
            $polls_count = Poll::all()->count();

            $categories = Category::paginate(20);
            $users = User::paginate(20);
            $polls = Poll::paginate(20);
            $logs = Log::orderBy('created_at', 'desc')->paginate(20);
            return view('admin-home', compact('categories','users','polls','logs',
            'users_count', 'logs_count', 'polls_count', 'categories_count'));
        } else {
            $user = auth()->user();
            $categories = $user->categories;
            $logs = $user->logs;

            return view('voter-home', compact('categories', 'logs'));
        }
    }

    /**
     * Show the test dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function test() {
        return view('test');
    }
}
