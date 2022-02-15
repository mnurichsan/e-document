<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        // if ($request->ajax()) {
        //     $data = User::get();
        //     return Datatables::of($data)
        //         ->addIndexColumn()
              
        //         ->editColumn('aksi', function ($data) {
        //             $actionButton = '
        //            <button data-toggle="modal" data-target="#editUser" onclick="editData(&quot;' . $data->id . '&quot;)" class="btn waves-effect waves-light btn-warning btn-sm">
        //                  <i class="fa fa-edit"></i>
        //             </button>
        //              <button class="btn waves-effect waves-light btn-danger btn-sm" onclick="alertHapus(&quot;' . $data->id . '&quot;)">
        //                  <i class="fa fa-trash"></i>
        //             </button>';
        //             return $actionButton;
        //         })
        //         ->escapeColumns([])
        //         ->make(true);
        // }
        $data = User::get();
        $user =  Auth::user();
        return view('useroperator.index',compact('data','user'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'opd'
        ];
        // return $data;
        User::create($data);
        toast('Data Berhasil Di Tambah', 'success');
        return redirect()->back();
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $data = User::findOrFail($id);

        return response()->json($data, 200);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        if ($request->password != null) {
            $data = [
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ];
        } else {
            $data = [
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email
            ];
        }
        User::findOrFail($id)->update($data);
        toast('Data Berhasil Di Update', 'success');
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $id = $request->id;

        $data = User::findOrFail($id)->delete();
        if ($data) {
            return response()->json(['message' => 'User Berhasil Di Hapus'], 200);
        } else {
            return response()->json(['message' => 'Error'], 200);
        }
    }
}
