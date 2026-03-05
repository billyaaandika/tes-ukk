<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function index()
    {
        $tools = Tool::where('status', 'available')->get();   
        return view('user.tools.index', compact('tools')  );
    }

    public function create()
    {
        //
        $Tools = Tool::findOrFail(request('tool_id'));
        return view('user.tools.create', compact('Tools'));
    }

    public function store(Request $request)
    {
        //
        $request->validate([
            'tool_id' => 'required|exists:tools,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Borrowing::create([
            'user_id' => Auth::id(),
            'tool_id' => $request->tool_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'pending',
        ]);

        return redirect()->route('user.tools.index')->with('success', 'Tool borrowed successfully!');
    }

    /**
     * Display borrowings list for current user
     */
    public function borrowingsList()
    {
        $borrowings = Borrowing::where('user_id', Auth::id())
            ->with(['tool', 'approvedBy'])
            ->latest()
            ->paginate(10);
        return view('user.borrowing_list', compact('borrowings'));
    }

    /**
     * Display borrowing detail
     */
    public function borrowingShow($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        
        // Check if user is the borrower
        if ($borrowing->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('user.borrowing_show', compact('borrowing'));
    }

    /**
     * Cancel borrowing request
     */
    public function borrowingCancel($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        
        // Check if user is the borrower
        if ($borrowing->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow cancellation if status is pending
        if ($borrowing->approval_status !== 'pending') {
            return back()->with('error', 'Tidak bisa membatalkan peminjaman yang sudah disetujui/ditolak');
        }

        $borrowing->delete();
        return redirect()->route('user.borrowings.list')->with('success', 'Peminjaman dibatalkan');
    }

    /**
     * Return borrowed item
     */
    public function borrowingReturn($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        
        // Check if user is the borrower
        if ($borrowing->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow return if status is borrowed and approved
        if ($borrowing->status !== 'borrowed' || $borrowing->approval_status !== 'approved') {
            return back()->with('error', 'Tidak bisa mengembalikan alat yang belum dipinjam atau belum disetujui');
        }

        // Create return record
        \App\Models\ReturnItem::create([
            'borrowing_id' => $borrowing->id,
            'returned_at' => now(),
        ]);

        // Update borrowing status
        $borrowing->update([
            'status' => 'returned',
            'returned_at' => now(),
        ]);

        // Update tool status to available
        $borrowing->tool->update(['status' => 'available']);

        return redirect()->route('user.borrowings.list')->with('success', 'Alat berhasil dikembalikan');
    }
}
