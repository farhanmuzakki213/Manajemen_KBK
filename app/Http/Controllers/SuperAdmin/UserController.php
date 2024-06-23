<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::get();
        return view('admin.content.superadmin.user.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('admin.content.superadmin.user.create', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:30',
            'roles' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->syncRoles($request->roles);
        return redirect('/users')->with('success', 'User berhasil dibuat dengan hak akses');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->all();
        return view('admin.content.superadmin.user.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|max:30',
            'roles' => 'required|array',
        ]);

        $userRoles = $user->roles->pluck('name')->toArray();
        

        if (in_array('super-admin', $userRoles) || in_array('admin', $userRoles)) {
            $data = [
                'name' => $request->name,
                'roles' => $request->roles,
            ];

            // Jika password diubah, hash password baru
            if (!empty($request->password)) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);
            $user->syncRoles($request->roles);

            return redirect('/users')->with('success', 'User berhasil diperbarui dengan hak akses.');
        }elseif(!in_array('super-admin', $request->roles) || !in_array('admin', $request->roles)){
            $dosenExists = DB::table('dosen')
            ->where('nama_dosen', $request->name)
            ->where('email', $request->email)
            ->exists();
            if (!$dosenExists) {
                return redirect()->back()->withInput()->with('error', 'Data user tidak sesuai dengan data dosen (nama dan email tidak cocok).');
            }
            $allowedRoles = array_diff($request->roles, ['admin', 'super-admin']);
            if(!$allowedRoles){
                return redirect()->back()->withInput()->with('error', 'Dosen tidak boleh memiliki akses admin atau super admin.');
            }
            $data = [
                'name' => $request->name,
                'roles' => $request->allowedRoles,
            ];
    
            // Jika password diubah, hash password baru
            if (!empty($request->password)) {
                $data['password'] = Hash::make($request->password);
            }
    
            $user->update($data);
            $user->syncRoles($allowedRoles);
    
            return redirect('/users')->with('success', 'User berhasil diperbarui dengan hak akses. Tanpa hak akses admin atau super admin');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();
        return redirect('/users')->with('success', 'User berhasil di hapus');
    }
}
