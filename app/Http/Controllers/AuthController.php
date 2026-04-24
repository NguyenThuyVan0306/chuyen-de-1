<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') return redirect()->route('admin.dashboard');
            if (Auth::user()->role === 'leader') return redirect()->route('leader.home');
            return redirect()->route('member.home');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'role' => 'required|in:member,leader',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'role.required' => 'Thiếu thông tin vai trò',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                Auth::logout();
                return back()->with('error', 'Vui lòng dùng cổng đăng nhập dành cho Quản trị viên');
            }
            
            // Strictly check if the actual role matches the requested role
            if (Auth::user()->role !== $request->role) {
                Auth::logout();
                $roleName = $request->role == 'leader' ? 'Trưởng nhóm' : 'Thành viên';
                return back()->with('error', 'Tài khoản không thuộc vai trò ' . $roleName);
            }
            
            if (Auth::user()->role === 'leader') {
                return redirect()->route('leader.home')->with('success', 'Đăng nhập thành công với tư cách Trưởng nhóm');
            }

            return redirect()->route('member.home')
                ->with('success', 'Đăng nhập thành công');
        }

        return back()->with('error', 'Email hoặc mật khẩu không đúng');
    }

    public function showAdminLoginForm()
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                Auth::logout(); // Bắt buộc đăng xuất các phiên rác của User bình thường nếu họ cố vào trang này
            }
        }
        return view('auth.admin-login');
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                Auth::logout();
                return back()->with('error', 'Chỉ tài khoản admin mới được đăng nhập tại đây');
            }
        }

        return back()->with('error', 'Email hoặc mật khẩu không đúng');
    }

    public function showRegisterForm()
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') return redirect()->route('admin.dashboard');
            if (Auth::user()->role === 'leader') return redirect()->route('leader.home');
            return redirect()->route('member.home');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:member,leader',
        ], [
            'name.required' => 'Vui lòng nhập họ tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
            'role.required' => 'Vui lòng chọn vai trò',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => 'active',
        ]);

        return redirect()->route('login')->with('success', 'Đăng ký thành công, vui lòng đăng nhập');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Đăng xuất thành công');
    }
}