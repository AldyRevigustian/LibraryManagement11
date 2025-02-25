<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penerbit;
use Illuminate\Http\Request;

class PenerbitController extends Controller
{
    public function index()
    {
        $penerbits = Penerbit::all();
        return view('admin.penerbit.index', compact('penerbits'));
    }

    public function add()
    {
        return view('admin.penerbit.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'unique:penerbits,nama',
                'max:255',
            ],
        ]);

        $penerbit = Penerbit::create([
            'nama' => $validated['nama'],
        ]);

        if ($penerbit) {
            return redirect()->route('admin.penerbit')->with('status', 'success')->with('message', 'Sukses Menambahkan Penerbit');
        } else {
            return redirect()->back()->with('status', 'danger')->with('message', 'Gagal Menambahkan Penerbit');
        }
    }

    public function edit($id)
    {
        $penerbit = Penerbit::find($id);
        return view('admin.penerbit.edit', compact('penerbit'));
    }

    public function update(Request $request, $id)
    {
        $penerbit = Penerbit::findOrFail($id);

        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'unique:penerbits,nama,' . $id,
                'max:255',
            ],
        ]);

        $updateData = [
            'nama' => $validated['nama'],
        ];

        $penerbit->update($updateData);

        return redirect()->route('admin.penerbit')
            ->with('status', 'success')
            ->with('message', 'Sukses Memperbarui Penerbit');
    }


    public function destroy($id)
    {
        $penerbit = Penerbit::find($id)->delete();

        if ($penerbit) {
            return redirect()->route('admin.penerbit')->with('status', 'success')->with('message', 'Suskses Menghapus Penerbit');
        }
        return redirect()->route('admin.penerbit')->with('status', 'danger')->with('message', 'Gagal Menghapus Penerbit');
    }
}
