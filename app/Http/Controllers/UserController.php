<?php

namespace App\Http\Controllers;

use App\Category;
use App\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\User;
use App\Mail\UsersCreated;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('is_admin')->except(['edit', 'update']);
        $this->middleware('auth');
    }

    public function index() {
        $users = User::paginate(20);
        return view('users.index', compact('users'));
    }

    public function show(User $user) {
        return view('users.edit', compact('user'));
    }

    public function edit(User $user) {
        if (($user->id !== auth()->user()->id || !$user->id) && !auth()->user()->role == 1) {
            return redirect(route('user.edit', auth()->user()->id));
        } else {
            $categories = Category::all();
            $user_categories = $user->categories;
            $cat_ids = [];
            foreach ($user_categories as $cat) {
                $cat_ids[] = $cat->id;
            }
            return view('users.edit', compact('user', 'categories', 'cat_ids'));
        }
    }

    public function create() {
        $categories = Category::all();
        return view('users.create', compact('categories'));
    }

    /**
     * @return \Illuminate\View\View for creating users
     */
    public function viewCreateUsers() {
        $categories = Category::all();
        return view('users.users_create', compact('categories'));
    }

    public function createUsers(Request $request) {
        $passwords = ['nvi2y922lHPrVwB', 'Y262lx7gh9fYNor', 'AW8fPjMOVBC63Nj', 'ZnP91zyNEA0ss8T', '3f7J5E4BH46375N'];
        $validator = Validator::make($request->all(), [
            'email' => 'array|required|min:1',
            'name' => 'array|required|min:1',
            'email.*' => 'required|regex:/^.+@.+$/i|max:100|unique:users,email|min:7|distinct',
            'name.*' => 'required|max:100|unique:users,name|min:5|string|distinct',
        ], $errors = [
            'name.required' => 'Παρακαλώ εισάγεται ονοματεπώνυμο',
            'name.max' => 'Παρακαλώ εισάγεται ονοματεπώνυμο μέχρι 100 χαρακτήρες',
            'email.regex' => 'Παρακαλώ εισάγεται ένα έγκυρο e-mail',
            'email.unique' => 'Το e-mail υπάρχει ήδη',
            'name.min' => 'Το ονοματεπώνυμο πρέπει να έχει πάνω από 4 χαρακτήρες',
            'email.min' => 'Το e-mail πρέπει να έχει πάνω από 6 χαρακτήρες',
        ]);

        if ($validator->fails()) {
            return redirect(route('user.viewCreateUsers'))->withErrors($validator)->withInput();
        }
        $i = 0;
        foreach ($request->email as $email) {
            $password = $passwords[rand(0, 4)];
            User::create([
                'name' => $request->name[$i],
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 2

            ]);
            Mail::to($email)->send(new UsersCreated($email, $password));
            $i++;
        }

        Log::create([
            'action' => 'Δημιουργία χρηστών: ' . implode(', ', $request->email),
            'user_id' => Auth::user()->id,
        ]);
        return view('users.users_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'max:100|regex:/^.+@.+$/i|unique:users,email,' . $request->email,
            'password' => 'max:25',
            'name' => 'required|max:100',
//            'categories' => 'required',
        ], $errors = [
            'email.regex' => 'Παρακαλώ βάλτε έγκυρο email',
            'email.unique' => 'Το e-mail υπάρχει ήδη',
            'email.min' => 'Το e-mail πρέπει να έχει πάνω από 7 χαρακτήρες',
            'name.required' => 'Το όνομα είναι υποχρεωτικό',
//            'categories.required' => 'Οι κατηγορία/ες είναι υποχρεωτικές'
        ]);
        if ($validator->fails()) {
            return redirect('user/create')->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($request->send_email == 1) {
            Mail::to($user->email)->send(new UsersCreated($user->email, $request->password));
        }

        Log::create([
            'action' => 'Δημιουργία χρήστη: ' . $user->email,
            'user_id' => Auth::user()->id,
        ]);
        if ($request->categories) {
            $user->categories()->attach($request->categories);
        }
        return redirect()->back()->withErrors(['success' => 'Δημιουργήθηκε νέος χρήστης'], 'success');
    }

    public function update(User $user, Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'max:100|regex:/^.+@.+$/i|unique:users,email,' . $user->id,
            'password' => 'max:25',
            'name' => 'required|max:100',
        ], $errors = [
            'email.regex' => 'Παρακαλώ βάλτε έγκυρο email',
            'email.unique' => 'Το e-mail υπάρχει ήδη',
            'email.min' => 'Το e-mail πρέπει να έχει πάνω από 7 χαρακτήρες',
            'name.required' => 'Το όνομα είναι υποχρεωτικό'
        ]);
        if ($validator->fails()) {
            return redirect('user/' . $user->id . '/edit')->withErrors($validator)->withInput();
        }
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        if ($request->categories) {
            $user->categories()->sync($request->categories, true);
        } else {
            $user->categories()->detach();
        }

        if ($user->role == 1) {
            $user->update([
                'role' => (integer)$request->role,
            ]);
        }

        if ($request->send_email == 1) {
            Mail::to($user->email)->send(new UsersCreated($user->email, $request->password));
        }
        Log::create([
            'action' => 'Επεξεργασία χρήστη: ' . $user->email,
            'user_id' => Auth::user()->id,
        ]);
        return back()->withErrors(['success' => 'Επιτυχημένη επεξεργασία στοιχείων.'], 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(User $user) {
        Log::create([
            'action' => 'Διαγραφή χρήστη: ' . $user->email,
            'user_id' => Auth::user()->id,
        ]);
        $user->delete();
        return redirect('/');
    }
}
