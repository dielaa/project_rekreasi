<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function getUsers(Request $request)
    {
    $users = User::select('id', 'name', 'email', 'role');
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<a href="'.route('dashboard.user.edit', $row->id).'" class="btn btn-warning btn-sm">Edit</a> ';
                $actionBtn .= '<form action="'.route('dashboard.user.delete', $row->id).'" method="POST" style="display:inline;">';
                $actionBtn .= csrf_field() . method_field('DELETE');
                $actionBtn .= '<button type="submit" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-sm">Delete</button></form>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,staff',
        ]);
        $validated['password'] = bcrypt($validated['password']);
        User::create($validated);
        return redirect()->route('dashboard.user.index')->with('success', 'User created successfully.');
    }

    public function show($id)
    {
        
    }

    public function edit(User $id)
    {
        $user = $id;
        return view('user.edit', compact('user'));
    }

    public function update(Request $request,User $id)
    {
        $user = $id;
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,staff',
        ]);
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);
        return redirect()->route('dashboard.user.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $id)
    {
        $deleteData = $id->delete();
        if ($deleteData) {
            return redirect()->route('dashboard.user.index')->with('success', 'Successfully delete User!');
        } else {
            return redirect()->back()->with('failed', 'Failed! Please try again.');
        }
    }

    public function export()
    {
        $file_name = 'data-user.xlsx';
        return Excel::download(new UserExport, $file_name);
    }

    public function trash()
    {
        return view('user.trash');
    }

    public function getTrashUser(Request $request)
    {
        $users = User::onlyTrashed()->select('*');
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<form action="'.route('dashboard.restore', ['id' => $row->id]).'" method="POST" style="display:inline;">';
                $actionBtn .= csrf_field() . method_field('PATCH');
                $actionBtn .= '<button type="submit" class="btn btn-success btn-sm me-2">restore</button></form>';
                $actionBtn .= '<form action="'.route('dashboard.delete_permanent', ['id' => $row->id]).'" method="POST" style="display:inline;">';
                $actionBtn .= csrf_field() . method_field('DELETE');
                $actionBtn .= '<button type="submit" onclick="return confirm(\'Are you sure to delete permanently?\')" class="btn btn-danger btn-sm">Delete Permanent</button></form>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function restore($id)
    {
        $users = User::onlyTrashed()->find($id);
        $users->restore();

        return redirect()->route('dashboard.user.index')->with('success', 'Successfully restore data!');
    }

    public function deletePermanent($id)
    {
        $users = User::onlyTrashed()->find($id);
        $users->forceDelete();

        return redirect()->route('dashboard.user.index')->with('success', 'Successfully delete permanent data!');
    }


}
