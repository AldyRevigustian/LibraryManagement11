<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::all();
        return view('admin.buku.index', compact('bukus'));
    }

    public function add()
    {
        $kategoris = Kategori::all();
        $penerbits = Penerbit::all();
        return view('admin.buku.create', compact('kategoris', 'penerbits'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'ISBN' => [
                'required',
                'unique:bukus,ISBN',
                'digits_between:1,13',
            ],
            'judul' => 'required|string|max:255',
            'kontributor' => 'required|string|max:255',
            'kategori_id' => 'required',
            'penerbit_id' => 'required',
            'stok' => 'required',
            'tahun_terbit' => 'required',
            'deskripsi_fisik' => 'required',
            'deskripsi' => 'required',
            'foto' => 'required',
        ]);

        $filename = $validated['ISBN'] . '.jpg';
        $request->foto->move(public_path('storage/cover_buku'), $filename);

        $buku = Buku::create([
            'ISBN' => $validated['ISBN'],
            'judul' => $validated['judul'],
            'kontributor' => $validated['kontributor'],
            'kategori_id' => $validated['kategori_id'],
            'penerbit_id' => $validated['penerbit_id'],
            'stok' => $validated['stok'],
            'tahun_terbit' => $validated['tahun_terbit'],
            'deskripsi_fisik' => $validated['deskripsi_fisik'],
            'deskripsi' => $validated['deskripsi'],
            'foto' => '/storage/cover_buku/' . $filename,
        ]);

        if ($buku) {
            return redirect()->route('admin.buku')->with('status', 'success')->with('message', 'Sukses Menambahkan Buku');
        } else {
            return redirect()->back()->with('status', 'danger')->with('message', 'Gagal Menambahkan Buku');
        }
    }

    public function edit($id)
    {
        $buku = Buku::find($id);
        $kategoris = Kategori::all();
        $penerbits = Penerbit::all();

        return view('admin.buku.edit', compact('buku', 'kategoris', 'penerbits'));
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $validated = $request->validate([
            'ISBN' => [
                'required',
                'unique:bukus,ISBN,' . $id,
                'digits_between:1,13',
            ],
            'judul' => 'required|string|max:255',
            'kontributor' => 'required|string|max:255',
            'kategori_id' => 'required',
            'penerbit_id' => 'required',
            'stok' => 'required',
            'tahun_terbit' => 'required',
            'deskripsi_fisik' => 'required',
            'deskripsi' => 'required',
            'foto' => 'nullable',
        ]);

        $updateData = [
            'ISBN' => $validated['ISBN'],
            'judul' => $validated['judul'],
            'kontributor' => $validated['kontributor'],
            'kategori_id' => $validated['kategori_id'],
            'penerbit_id' => $validated['penerbit_id'],
            'stok' => $validated['stok'],
            'tahun_terbit' => $validated['tahun_terbit'],
            'deskripsi_fisik' => $validated['deskripsi_fisik'],
            'deskripsi' => $validated['deskripsi'],
        ];

        if (!empty($request->foto)) {
            $filename = $validated['ISBN'] . '.jpg';
            $request->foto->move(public_path('storage/cover_buku'), $filename);
            $updateData['foto'] = '/storage/cover_buku/' . $filename;
        }

        $buku->update($updateData);

        return redirect()->route('admin.buku')
            ->with('status', 'success')
            ->with('message', 'Sukses Memperbarui Buku');
    }


    public function destroy($id)
    {
        $buku = Buku::find($id);

        if ($buku) {
            if (!empty($buku->foto)) {
                $fotoPath = public_path($buku->foto);
                if (file_exists($fotoPath)) {
                    unlink($fotoPath);
                }
            }
            $buku->delete();
            return redirect()->route('admin.buku')->with('status', 'success')->with('message', 'Sukses Menghapus Buku');
        }
        return redirect()->route('admin.buku')->with('status', 'danger')->with('message', 'Gagal Menghapus Buku');
    }
}
