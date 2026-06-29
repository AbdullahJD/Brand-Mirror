<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);

        return view('Dashboard.Pages.users.index', compact('users'));
    }

    public function create()
    {
        return view('Dashboard.Pages.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,employee',
        ]);

        $users = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        app(NotificationService::class)->notifyRoles(
            ['admin'],
            'log',
            'New Employee Created',
            "Employee {$users->name} was created"
        );

        return redirect()->route('users.index')
            ->with('success', __('messages.flash_user_created'));
    }

    public function show(string $id)
    {
        //
    }

    public function edit(User $user)
    {
        return view('Dashboard.Pages.users.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,employee',
        ]);

        // ❌ منع تغيير آخر Admin إلى Employee
        if ($user->role === 'admin' && $request->role !== 'admin') {

            $adminCount = User::where('role', 'admin')->count();

            if ($adminCount <= 1) {
                return redirect()->back()
                    ->with('error', __('messages.flash_cannot_change_last_admin'));
            }
        }

        // ❌ منع تعديل نفسك إلى Employee إذا كنت آخر Admin
        if (auth()->id() === $user->id && $user->role === 'admin' && $request->role !== 'admin') {

            $adminCount = User::where('role', 'admin')->count();

            if ($adminCount <= 1) {
                return redirect()->back()
                    ->with('error', __('messages.flash_cannot_downgrade_self'));
            }
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        app(NotificationService::class)->notifyRoles(
            ['admin'],
            'log',
            'New Employee Updated',
            "Employee {$user->name} was updated"
        );

        return redirect()->route('users.index')
            ->with('updated', __('messages.flash_user_updated'));
    }

    public function destroy(string $id)
    {
         $user = User::findOrFail($id);

        //  منع حذف نفسه
        if (auth()->id() === $user->id) {
            return redirect()->back()
                ->with('error', __('messages.flash_cannot_delete_self'));
        }

        //  منع حذف آخر Admin
        if ($user->role === 'admin') {
            $adminCount = User::where('role', 'admin')->count();

            if ($adminCount <= 1) {
                return redirect()->back()
                    ->with('error', __('messages.flash_cannot_delete_last_admin'));
            }
        }

        $user->delete();

        app(NotificationService::class)->notifyRoles(
            ['admin'],
            'log',
            'New Employee Deleted',
            "Employee {$user->name} was deleted"
        );

        return redirect()->route('users.index')
            ->with('deleted', __('messages.flash_user_deleted'));
    }
}
