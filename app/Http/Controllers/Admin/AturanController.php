<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aturan;
use Illuminate\Http\Request;

class AturanController extends Controller
{
    public function index()
    {
        $aturan = Aturan::first();
        return view('admin.aturan', compact('aturan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'maksimal_buku' => 'required|integer|min:1',
            'batas_pengembalian' => 'required|integer|min:1',
            'denda' => 'required|numeric|min:0',
        ]);

        $aturan = Aturan::first();

        if ($aturan->update($request->all())) {
            return redirect()->route('admin.aturan')
                ->with('status', 'success')
                ->with('message', 'Aturan berhasil diperbarui.');
        } else {
            return redirect()->route('admin.aturan')
                ->with('status', 'error')
                ->with('message', 'Aturan gagal diperbarui.');
        }
    }
}
