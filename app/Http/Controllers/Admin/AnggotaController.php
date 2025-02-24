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
        return view('admin.anggota.add');
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
}
