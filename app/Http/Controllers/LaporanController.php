<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    //
    public function index()
    {
        $data = Borrowing ::with('user','tool')->get();
        return view('officer.laporan.index', compact('data'));
    }

    public function print()
    {
        $data = Borrowing ::with('user', 'tool')->get();
        return view('officer.laporan.print', compact('data'));
    }
}
