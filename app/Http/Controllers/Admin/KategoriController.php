<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function add()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'unique:kategoris,nama',
                'max:255',
            ],
        ]);

        $kategori = Kategori::create([
            'nama' => $validated['nama'],
        ]);

        if ($kategori) {
            return redirect()->route('admin.kategori')->with('status', 'success')->with('message', 'Sukses Menambahkan Kategori');
        } else {
            return redirect()->back()->with('status', 'danger')->with('message', 'Gagal Menambahkan Kategori');
        }
    }

    public function edit($id)
    {
        $kategori = Kategori::find($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'unique:kategoris,nama,' . $id,
                'max:255',
            ],
        ]);

        $updateData = [
            'nama' => $validated['nama'],
        ];

        $kategori->update($updateData);

        return redirect()->route('admin.kategori')
            ->with('status', 'success')
            ->with('message', 'Sukses Memperbarui Kategori');
    }


    public function destroy($id)
    {
        $kategori = Kategori::find($id)->delete();

        if ($kategori) {
            return redirect()->route('admin.kategori')->with('status', 'success')->with('message', 'Suskses Menghapus Kategori');
        }
        return redirect()->route('admin.kategori')->with('status', 'danger')->with('message', 'Gagal Menghapus Kategori');
    }
}
