<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('anggota.profile');
    }

    public function update(Request $request, $id)
    {
        $profile = Anggota::findOrFail($id);
        if (!empty($request->foto)) {
            $filename = $profile->nim . '.jpg';
            $request->foto->move(public_path('storage/profile'), $filename);
            $updateData['foto'] = '/storage/profile/' . $filename;
        }

        if(!empty($request->password)){
            $updateData['password'] = Hash::make($request->password);
        }

        $profile->update($updateData);

        return redirect()->route('anggota.profile')
            ->with('status', 'success')
            ->with('message', 'Sukses Memperbarui Profile');
    }
}
