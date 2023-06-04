<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Room;
use App\Models\User;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use \Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::getAll();
        $users = collect($users);
        // $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id = NULL)
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            // 'user_code' => ['required', 'string', Rule::unique('users')],
            'username' => ['required', 'string', Rule::unique('users')],
            'email' => ['required', 'email', Rule::unique('users')],
            'role' => ['required', 'string'],
            'gender' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect('/admin/users/create')
                ->withErrors($validator)
                ->withInput();
        }
        $fullName = $request->first_name . $request->last_name;

        User::insert($request);

        return redirect('admin/users/')->withErrors($validator)->with('status', 'Selamat Data Berhasil Di Tambahkan')->withInput();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = DB::select('select * from users  where username = ?', [$id]);
        $user = collect($user);
        return view('users.edit', compact('user', 'id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $username)
    {
        $user = DB::select('select * from users where username = ?', [$username]);
        // $user = collect($user);

        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            // 'user_code' => ['required', 'string', Rule::unique('users')->ignore($user[0]->id)],
            'username' => ['required', 'string', Rule::unique('users')->ignore($user[0]->id)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user[0]->id)],
            'role' => ['required', 'string'],
            'gender' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect('/admin/users/'. $username.'/edit')
                ->withErrors($validator)
                ->withInput();
        }
        $fullName = $request->input('first_name') . $request->input('last_name');
        User::edit($fullName, $request, $username);

        return redirect('/admin/users')->withErrors($validator)->withSuccess('Selamat Data Berhasil Di Update')->with('status', 'Selamat Data Berhasil Di Update')->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $username)
    {
        $user = User::where('username','=', $username)->first();
        if ($user) {
            $roomIds = $user->rooms()->delete(); // Get the room IDs associated with the user
            // dd($roomIds);
            $borrowIds = $user->borrows()->delete(); // Get the borrow IDs associated with the user
            // Room::whereIn('id', $roomIds)->delete(); // Delete the associated rooms
            // Borrow::whereIn('id', $borrowIds)->delete(); // Delete the associated borrows
            // Room::destroy($roomIds); // Delete the associated Rooms
            // Borrow::destroy($borrowIds); // Delete the associated borrows

        User::destroy($username); // Delete the user
        }
        if (Gate::allows('admin')) {
            return redirect('/admin/users')->with('status', 'Data berhasil Di Hapus');
        }elseif (Gate::allows('operator')) {
            return redirect('/oprator/users')->with('status', 'Data berhasil Di Hapus');
        } else {
            abort(403, 'Unauthorized');
        }
    }

    public function resetPassword(User $user)
    {
        // Generate a new password
        $newPassword = 'invsch@garut';

        // Update the user's password
        $user->password = Hash::make($newPassword);
        $user->save();

        // Send an email or notification to the user with the new password

        return redirect()->back()->with('status', 'Password has been reset successfully.');
    }
}
