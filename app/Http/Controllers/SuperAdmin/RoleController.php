<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::get();
        return view('admin.content.superadmin.role.index', [
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.content.superadmin.role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:roles,name'
            ]
        ]);


        Role::create([
            'name' => $request->name
        ]);
        return redirect('roles')->with('success', 'role berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('admin.content.superadmin.role.edit', [
            'role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:roles,name,' . $role->id
            ]
        ]);


        $role->update([
            'name' => $request->name
        ]);
        return redirect('roles')->with('success', 'role berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($roleId)
    {
        $role = Role::find($roleId);
        $role->delete();
        return redirect('roles')->with('success', 'role berhasil dihapus');
    }

    public function addPermissionsToRole($roleId)
    {
        $permissionsAdmin = Permission::where('name', 'like', 'admin%')->get();
        foreach ($permissionsAdmin as &$item) {
            $item['name'] = str_replace('admin-', '', $item['name']);
            $item['name_real'] = 'admin-' . $item['name'];
        }

        $permissionsSuperAdmin = Permission::where('name', 'like', 'superAdmin%')->get();
        foreach ($permissionsSuperAdmin as &$item) {
            $item['name'] = str_replace('superAdmin-', '', $item['name']);
            $item['name_real'] = 'superAdmin-' . $item['name'];
        }
        $permissionsPengurusKbk = Permission::where('name', 'like', 'pengurusKbk%')->get();
        foreach ($permissionsPengurusKbk as &$item) {
            $item['name'] = str_replace('pengurusKbk-', '', $item['name']);
            $item['name_real'] = 'pengurusKbk-' . $item['name'];
        }
        $permissionsDosenKbk = Permission::where('name', 'like', 'dosenKbk%')->get();
        foreach ($permissionsDosenKbk as &$item) {
            $item['name'] = str_replace('dosenKbk-', '', $item['name']);
            $item['name_real'] = 'dosenKbk-' . $item['name'];
        }
        $permissionsDosenMatkul = Permission::where('name', 'like', 'dosenMatkul%')->get();
        foreach ($permissionsDosenMatkul as &$item) {
            $item['name'] = str_replace('dosenMatkul-', '', $item['name']);
            $item['name_real'] = 'dosenMatkul-' . $item['name'];
        }
        $permissionsPimpinanProdi = Permission::where('name', 'like', 'pimpinanProdi%')->get();
        foreach ($permissionsPimpinanProdi as &$item) {
            $item['name'] = str_replace('pimpinanProdi-', '', $item['name']);
            $item['name_real'] = 'pimpinanProdi-' . $item['name'];
        }
        $permissionsPimpinanJurusan = Permission::where('name', 'like', 'pimpinanJurusan%')->get();
        foreach ($permissionsPimpinanJurusan as &$item) {
            $item['name'] = str_replace('pimpinanJurusan-', '', $item['name']);
            $item['name_real'] = 'pimpinanJurusan-' . $item['name'];
        }
        //dd($permissionsSuperAdmin->toArray());
        $role = Role::findOrFail($roleId);
        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id', $role->id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('admin.content.superadmin.role.add-permission', [
            'role' => $role,
            'permissionsAdmin' => $permissionsAdmin,
            'permissionsSuperAdmin' => $permissionsSuperAdmin,
            'permissionsPengurusKbk' => $permissionsPengurusKbk,
            'permissionsDosenKbk' => $permissionsDosenKbk,
            'permissionsDosenMatkul' => $permissionsDosenMatkul,
            'permissionsPimpinanProdi' => $permissionsPimpinanProdi,
            'permissionsPimpinanJurusan' => $permissionsPimpinanJurusan,
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function givePermissionsToRole(Request $request, $roleId)
    {
        $request->validate([
            'permission' => 'required'
        ]);

        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permission);

        return redirect()->back()->with('success', 'Permission ditambahkan ke role');
    }
}
