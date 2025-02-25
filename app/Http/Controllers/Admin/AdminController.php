<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::all();
        return view('admin.administrator.index', compact('admins'));
    }

    public function add()
    {
        return view('admin.administrator.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'unique:admins,email',
            ],
            'password' => 'required|min:11',
        ]);

        $admin = Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => 'admin',
            'password' => Hash::make($validated['password']),
        ]);

        if ($admin) {
            return redirect()->route('admin.administrator')->with('status', 'success')->with('message', 'Sukses Menambahkan Admin');
        } else {
            return redirect()->back()->with('status', 'danger')->with('message', 'Gagal Menambahkan Admin');
        }
    }

    public function edit($id)
    {
        $admin = Admin::find($id);
        return view('admin.administrator.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'unique:admins,email,' . $id,
            ],
            'password' => 'nullable|min:11',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($request->password)) {
            $updateData['password'] = Hash::make($request->password);
        }

        $admin->update($updateData);

        return redirect()->route('admin.administrator')
            ->with('status', 'success')
            ->with('message', 'Sukses Memperbarui Admin');
    }


    public function destroy($id)
    {
        $admin = Admin::find($id)->delete();

        if ($admin) {
            return redirect()->route('admin.administrator')->with('status', 'success')->with('message', 'Suskses Menghapus Admin');
        }
        return redirect()->route('admin.administrator')->with('status', 'danger')->with('message', 'Gagal Menghapus Admin');
    }
}
