<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{ 

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }
    public function index()
    {
        $users = User::all(); // Đảm bảo bạn đang truyền danh sách users

        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048',
            'score' => 'nullable|integer',
            'trust_score' => 'nullable|integer',
            'gender' => 'nullable|in:male,female,other',
            'bank_account_number' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'account_holder_name' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được tạo thành công!');
    }



    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048',
            'score' => 'nullable|integer',
            'trust_score' => 'nullable|integer',
            'gender' => 'nullable|in:male,female,other',
            'bank_account_number' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'account_holder_name' => 'nullable|string',
        ]);

        $data = $request->all();
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Thông tin người dùng đã được cập nhật!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã bị xóa!');
    }
}
