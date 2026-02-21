<?php

namespace App\Http\Controllers;

use App\Models\ReturnItem;
use Illuminate\Http\Request;

class ReturnItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $returns = ReturnItem::paginate(10);
        return view('admin.returns.index', compact('returns'));
    }

    public function officerIndex()
    {
        $returns = ReturnItem::paginate(10);
        return view('officer.returns.index', compact('returns'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.returns.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'returned_at' => 'required|date',
        ]);
        ReturnItem::create([
            'borrowing_id' => $request->borrowing_id,
            'returned_at' => $request->returned_at,
        ]);
        return redirect()->route('admin.returns.index')->with('success', 'Pengembalian berhasil ditambahkan.');        
    }

    /**
     * Display the specified resource.
     */
    public function show(ReturnItem $returnItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReturnItem $returnItem)
    {
        //
        return view('admin.returns.edit', compact('returnItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReturnItem $returnItem)
    {
        //
        $request->validate([
            'returned_at' => 'required|date',
        ]);
        $returnItem->update([
            'returned_at' => $request->returned_at,
        ]);
        return redirect()->route('admin.returns.index')->with('success', 'Pengembalian berhasil diperbarui.'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReturnItem $returnItem)
    {
        //
        $returnItem->delete();
        return redirect()->route('admin.returns.index')->with('success', 'Pengembalian berhasil dihapus.');    
    }
}
