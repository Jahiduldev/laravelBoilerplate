<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\User\IUserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(public IUserRepository $userRepository) {
    }

    public function UserDashboard(Request $request){
        $userData = User::find(Auth::id());
        return view('dashboard', compact('userData'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function UserLogout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'User Logout Successfully!.',
            'alert-type' => 'success',
        );
        return redirect('/login')->with($notification);
    }

    public function UserUpdatePassword(Request $request){
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'new_password_confirm' => 'required|same:new_password',
        ]);
        // Match the old password
        if(!Hash::check($request->old_password, auth::user()->password)){
            return redirect()->to('/dashboard?tab=account-ChangePassword')->with("error", "Old password doesn't match!.");
        }
        $this->userRepository->update(auth::user()->id, ['password' => Hash::make($request->new_password)]);
        return redirect()->to('/dashboard?tab=account-ChangePassword')->with("status", "Password changed sucessfully");
    }
}
