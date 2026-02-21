<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tool;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $tools = Tool::paginate(10);
        return view('admin.tools.index', compact('tools'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.tools.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name_tool' => 'required|string|max:255',
            'category_tool' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
        ]);
        Tool::create([
            'name_tool' => $request->name_tool,
            'category_tool' => $request->category_tool,
            'stock' => $request->stock,
        ]);

        return redirect()->route('admin.tools.index')->with('success', 'Alat berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tool $tool)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tool $tool)
    {
        //
        return view('admin.tools.edit', compact('tool'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tool $tool)
    {
        //
        $request->validate([
            'name_tool' => 'required|string|max:255',
            'category_tool' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
        ]);
        $tool->name_tool = $request->name_tool;
        $tool->category_tool = $request->category_tool;
        $tool->stock = $request->stock;
        $tool->save();
        return redirect()->route('admin.tools.index')->with('success', 'Alat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tool $tool)
    {
        //
        $tool->delete();
        return redirect()->route('admin.tools.index')->with('success', 'Alat berhasil dihapus.');
    }
}
