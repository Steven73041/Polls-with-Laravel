<?php

namespace App\Http\Controllers;

use App\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Category;
use Validator;

class CategoryController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('is_admin')->only(['create', 'edit', 'store', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $categories = Category::paginate(20);
        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100|min:2|unique:categories',
        ], $errors = [
            'name.unique' => 'Το όνομα της κατηγορίας υπάρχει ήδη',
            'name.min' => 'Το όνομα της κατηγορίας πρέπει να είναι πάνω από 2 χαρακτήρες',
            'name.required' => 'Το όνομα κατηγορίας είναι υποχρεωτικό'
        ]);

        if ($validator->fails()) {
            return redirect('category/create')->withErrors($validator)->withInput();
        }

        $category = Category::create([
            'name' => $request->name,
        ]);
        Log::create([
            'action' => 'Νέα κατηγορία: '.$category->name,
            'user_id' => Auth::user()->id,
        ]);
        return redirect()->back()->withErrors(['success' => 'Δημιουργήθηκε νέα κατηγορία'], 'success');
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
    public function edit(Category $category) {
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2',
        ],$errors = [
            'name.required' => 'Το όνομα είναι υποχρεωτικό',
            'name.min' => 'Το όνομα πρέπει να έχει πάνω από 2 χαρακτήρες'
        ]);
        if ($validator->fails()) {
            return redirect('category/'.$category->id.'/edit')->withErrors($validator)->withInput();
        }
        $category->update([
            'name' => $request->name,
        ]);
        Log::create([
            'action' => 'Επεξεργασία κατηγορίας: '.$category->name,
            'user_id' => Auth::user()->id,
        ]);

        return back()->withErrors(['success' => 'Η κατηγορία ενημερώθηκε με επιτυχία'], 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category) {
        Log::create([
            'action' => 'Διαγραφή κατηγορίας: '.$category->name,
            'user_id' => Auth::user()->id,
        ]);
        $category->delete();
        return redirect('/');
    }
}
