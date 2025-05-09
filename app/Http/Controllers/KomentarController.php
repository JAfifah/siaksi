<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Komentar;
use Illuminate\Support\Facades\Auth;

class KomentarController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'isi' => 'required|string',
            'table' => 'required|string',
        ]);

        Komentar::create([
            'user_id' => Auth::id(),
            'table' => $request->table,
            'isi' => $request->isi,
        ]);

        return back()->with('success', 'Komentar berhasil dikirim.');
    }
}
