<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(15);
        $stats = [
            'total_users' => User::count(),
            'admin_users' => User::whereHas('roles', function($q) {
                $q->where('name', 'Admin');
            })->count(),
            'live_staff' => User::whereHas('roles', function($q) {
                $q->where('name', 'Nhân viên Live');
            })->count(),
            'cskh_staff' => User::whereHas('roles', function($q) {
                $q->where('name', 'CSKH');
            })->count(),
            'external_users' => User::where('user_type', 'external_login')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'account' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:255',
            'platform' => 'nullable|string|max:255',
            'user_type' => 'required|in:system,external_login',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'account' => $validated['account'],
            'bank_account' => $validated['bank_account'],
            'platform' => $validated['platform'],
            'user_type' => $validated['user_type'],
        ]);

        $user->assignRole($validated['roles']);

        return redirect()->route('admin.users.index')->with('success', 'Tạo user thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'account' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:255',
            'platform' => 'nullable|string|max:255',
            'user_type' => 'required|in:system,external_login',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name'
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'account' => $validated['account'],
            'bank_account' => $validated['bank_account'],
            'platform' => $validated['platform'],
            'user_type' => $validated['user_type'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);
        $user->syncRoles($validated['roles']);

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật user thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'Không thể xóa chính mình!');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Xóa user thành công!');
    }
}
