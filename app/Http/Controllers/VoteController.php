<?php

namespace App\Http\Controllers;

use App\Category;
use App\Log;
use App\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller {
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('is_admin')->except(['store', 'vote']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Vote
     *
     */
    public function vote($id) {
        $category = Category::find($id);
        $polls = $category->polls;
        $new_arr = [];
        foreach ($polls as $poll) {
            if (user_has_voted_this($poll->id) || $poll->isClosed == 1) continue;
            $new_arr[] = $poll;
        }
        $poll = !empty($new_arr) ? $new_arr[0] : null;
        if ($poll) {
            return view('vote.vote', compact('poll'));
        } else {
            return redirect('/');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $user = auth()->user();
        if (!empty($request->answer)) {
            foreach ($request->answer as $answer) {
                $vote = Vote::create([
                    'user_id' => $user->id,
                    'poll_id' => $request->poll_id,
                    'answer' => $answer,
                ]);
            }
            Log::create([
                'action' => 'Ψήφος από ' . $user->email . ' στην ερώτηση ' . $vote->poll->question,
                'user_id' => $user->id,
            ]);
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Vote $vote) {
        return view('vote.edit', compact('vote'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vote $vote) {
        $vote->update([
            'answer' => $request->answer,
        ]);
        Log::create([
            'action' => 'Επεργασία απάντησης στην ερώτηση: ' . $vote->poll->question,
            'user_id' => auth()->user()->id,
        ]);
        return back()->withErrors(['success' => 'Επιτυχής επεξεργασία απάντησης'], 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }
}
