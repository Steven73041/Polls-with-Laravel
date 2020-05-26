<?php

namespace App\Http\Controllers;

use App\Log;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Category;
use App\Poll;
use Illuminate\Http\Request;

class PollController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $polls = Poll::paginate(20);
        return view('polls.index', compact('polls'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $categories = Category::all();
        return view('polls.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $categories = Category::all();
        $msg_for_cat = empty($categories[0]) ? 'Δεν έχετε δημιουργήσει κατηγορίες για να εμφανιστούν, μπορείτε να φτιάξετε κατηγορία <a href="' . route('category.create') . '">εδώ</a>' : 'Η κατηγορία είναι υποχρεωτική.';
        $validator = Validator::make($request->all(), [
            'question' => 'min:10|max:100|unique:polls',
            'category_id' => 'required|int',
        ], $errors = [
            'question.unique' => 'Αυτή η ερώτηση υπάρχει ήδη',
            'question.max' => 'Η ερώτηση να είναι από 10 έως 100 χαρακτήρες',
            'question.min' => 'Η ερώτηση να είναι από 10 έως 100 χαρακτήρες',
            'category_id.required' => $msg_for_cat,
            'category_id.int' => 'Κάποιος προσπαθεί να hackαρει;',
        ]);
        if ($validator->fails()) {
            return redirect('poll/create')->withErrors($validator)->withInput();
        }
        $poll = Poll::create([
            'question' => $request->question,
            'category_id' => $request->category_id,
            'isClosed' => $request->isClosed,
        ]);
        Log::create([
            'action' => 'Δημιουργία ερώτησης: ' . $poll->question,
            'user_id' => Auth::user()->id,
        ]);
        return back()->withErrors(['success' => 'Επιτυχημένη δημιουργία ερώτησης.'], 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Poll $poll
     * @return \Illuminate\Http\Response
     */
    public function show(Poll $poll) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Poll $poll
     * @return \Illuminate\Http\Response
     */
    public function edit(Poll $poll) {
        $categories = Category::all();
        return view('polls.edit', compact('categories', 'poll'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Poll $poll
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Poll $poll) {
        $validator = Validator::make($request->all(), [
            'question' => 'min:10|max:100',
            'category_id' => 'required|int',
        ], $errors = [
            'question.max' => 'Η ερώτηση να είναι από 10 έως 100 χαρακτήρες',
            'question.min' => 'Η ερώτηση να είναι από 10 έως 100 χαρακτήρες',
            'category_id.required' => 'Η κατηγορία είναι υποχρεωτική',
            'category_id.int' => 'Κάποιος προσπαθεί να hackαρει;',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $poll->update([
            'question' => $request->question,
            'category_id' => $request->category_id,
        ]);
        Log::create([
            'action' => 'Επεξεργασία ερώτησης: ' . $poll->question,
            'user_id' => Auth::user()->id,
        ]);
        return back()->withErrors(['success' => 'Επιτυχημένη επεξεργασία στοιχείων.'], 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Poll $poll
     * @return \Illuminate\Http\Response
     */
    public function destroy(Poll $poll) {
        Log::create([
            'action' => 'Διαγραφή ερώτησης: ' . $poll->question,
            'user_id' => Auth::user()->id,
        ]);
        $poll->delete();
        return redirect('/');
    }
}
