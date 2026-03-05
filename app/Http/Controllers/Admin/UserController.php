<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Tool;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function index(Request $request)
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:admin,user,officer',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user,officer',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function borrowingsList()
    {
        $user = User::findOrFail(Auth::id());
        $borrowings = $user->borrowings()->with('tool')->latest()->paginate(10);
        return view('users.borrowing_list', compact('user', 'borrowings'));
    }

    public function borrowingscreate()
    {
        $tools = Tool::get();
        return view('users.borrowing_create', compact('tools'));
    }

    public function borrowingsstore(Request $request)
    {
        $request->validate([
            'tool_id' => 'required|exists:tools,id',
            'borrowed_at' => 'required|date',
            'return_plan' => 'required|date|after_or_equal:borrowed_at',
            'description' => 'nullable|string',
        ]);

        Borrowing::create([
            'user_id' => Auth::id(),
            'tool_id' => $request->tool_id,
            'borrowed_at' => $request->borrowed_at,
            'return_plan' => $request->return_plan,
            'description' => $request->description,
            'status' => 'borrowed',
            'approval_status' => 'pending',
            'approved_by' => null,
        ]);

        return redirect()->route('user.borrowings_list')
            ->with('success', 'Peminjaman berhasil diajukan!');
    }

    public function borrowingcancel($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        if ($borrowing->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $borrowing->delete();
        return redirect()->route('user.borrowings_list')->with('success', 'Peminjaman berhasil dibatalkan.');
    }

    public function borrowingreturn($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        if ($borrowing->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $borrowing->status = 'returned';
        $borrowing->returned_at = now();
        $borrowing->save();

        return redirect()->route('user.borrowings_list')->with('success', 'Peminjaman berhasil dikembalikan.');
    }
}
