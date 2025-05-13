<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Komentar;
use Illuminate\Support\Facades\Auth;

class KomentarController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'dokumen_id' => 'required|exists:dokumen,id',
        'komentar' => 'required|string|max:1000',
    ]);

    $komentar = new Komentar();
    $komentar->dokumen_id = $validated['dokumen_id'];
    $komentar->user_id = auth()->id(); // Pastikan user sedang login
    $komentar->isi = $validated['isi'];
    $komentar->save();

    return redirect()->back()->with('success', 'Komentar berhasil dikirim.');
}

}

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
