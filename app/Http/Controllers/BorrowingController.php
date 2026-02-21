<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $borrowings = Borrowing::paginate(10);
        return view('admin.borrowings.index', compact('borrowings'));
    }

    public function officerIndex()
    {
        $borrowings = Borrowing::where('approved_by', Auth::id())->paginate(10);
        return view('officer.borrowings.index', compact('borrowings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $tools = Tool::all();
        return view('admin.borrowings.create', compact('tools'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'borrowed_at' => 'required|date',
            'returned_at' => 'required|date|after:borrowed_at',
        ]);
        Borrowing::create([
            'user_id' => Auth::id(),
            'tool_id' => $request->tool_id,
            'borrowed_at' => $request->borrowed_at,
            'returned_at' => $request->return_at,
        ]);
        return redirect()->route('admin.borrowings.index')->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrowing $borrowing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $tools = Tool::all();

        return view('admin.borrowings.edit', compact('borrowing', 'tools'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tool_id' => 'required|integer',
            'borrowed_at' => 'required|date',
            'returned_at' => 'required|date|after:borrowed_at',
        ]);

        $borrowing = Borrowing::findOrFail($id);
        $borrowing->update($request->all());

        return redirect()->route('admin.borrowings.index')
            ->with('success', 'Data peminjaman berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrowing $borrowing)
    {
        //
        $borrowing->delete();
        return redirect()->route('admin.borrowings.index')->with('success', 'Peminjaman berhasil dihapus.');
    }
}
