<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($jenis)
    {
        $title = "Kelola Data User " . strtoupper($jenis);
        $users = User::where('tipe_user', $jenis)->get();

        return view('admin.users.index', compact('title', 'users', 'jenis'));
    }

    public function store(Request $request)
    {
        // cek username
        try {
            $cek = User::where('username', $request->username);
            if (!$cek->exists()) {

                $user = User::create([
                    'username' => $request->username,
                    'password' => bcrypt($request->password),
                    'nama' => $request->nama,
                    'nomor_hp' => $request->nomor_hp,
                    'tipe_user' => $request->role,
                    'created_at' => Carbon::now()
                ]);

                $user->assignRole($request->role);

                if ($user) {
                    return redirect()->back()->with('success', 'User berhasil ditambah');
                } else {
                    return redirect()->back()->with('alert', 'User gagal ditambah');
                }
            } else {
                return redirect()->back()->with('alert', 'User gagal ditambah, Username sudah terdaftar');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('alert', 'User gagal ditambah.');
        }
    }

    public function edit(Request $request)
    {
        return User::find($request->id);
    }

    public function update(Request $request)
    {
        $value = [
            'nama' => $request->nama,
            'nomor_hp' => $request->nomor_hp,
        ];
        $query = User::where('id', $request->id)
            ->update($value);

        if ($query) {
            return redirect()->back()->with('success', 'User berhasil diubah');
        } else {
            return redirect()->back()->with('alert', 'User gagal diubah');
        }
    }

    public function hapus(Request $request)
    {

        $query = User::where('id', $request->id)
            ->delete();

        if ($query) {
            User::where('id', $request->id_user)->delete();
            return redirect()->back()->with('success', 'Berhasil menghapus user');
        } else {
            return redirect()->back()->with('alert', 'Gagal menghapus user');
        }
    }

    public function resetpw(Request $request)
    {
        $query = User::where('id', $request->id)
            ->update([
                'password' => bcrypt($request->password)
            ]);

        if ($query) {
            return redirect()->back()->with('success', 'Password User berhasil diubah');
        } else {
            return redirect()->back()->with('alert', 'Password User gagal diubah');
        }
    }
}
