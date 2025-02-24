<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggotas = Anggota::all();
        return view('admin.anggota.index', compact('anggotas'));
    }

    public function add()
    {
        return view('admin.anggota.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => [
                'required',
                'unique:anggotas,nim',
                'digits_between:1,10',
            ],
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'unique:anggotas,email',
                'regex:/^[a-zA-Z0-9._%+-]+@binus(\.[a-zA-Z]+)+$/'
            ],
            'password' => 'required|min:11',
        ]);

        $anggota = Anggota::create([
            'nim' => $validated['nim'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        if ($anggota) {
            return redirect()->route('admin.anggota')->with('status', 'success')->with('message', 'Sukses Menambahkan Anggota');
        } else {
            return redirect()->back()->with('status', 'danger')->with('message', 'Gagal Menambahkan Anggota');
        }
    }

    public function edit($id)
    {
        $anggota = Anggota::find($id);
        return view('admin.anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);

        $validated = $request->validate([
            'nim' => [
                'required',
                'digits_between:1,10',
                'unique:anggotas,nim,' . $id,
            ],
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'unique:anggotas,email,' . $id,
                'regex:/^[a-zA-Z0-9._%+-]+@binus(\.[a-zA-Z]+)+$/'
            ],
            'password' => 'nullable|min:11',
        ]);

        $updateData = [
            'nim' => $validated['nim'],
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($request->password)) {
            $updateData['password'] = Hash::make($request->password);
        }

        $anggota->update($updateData);

        return redirect()->route('admin.anggota')
            ->with('status', 'success')
            ->with('message', 'Sukses Memperbarui Anggota');
    }


    public function destroy($id)
    {
        $anggota = Anggota::find($id)->delete();

        if ($anggota) {
            return redirect()->route('admin.anggota')->with('status', 'success')->with('message', 'Suskses Menghapus Anggota');
        }
        return redirect()->route('admin.anggota')->with('status', 'danger')->with('message', 'Gagal Menghapus Anggota');
    }
}
