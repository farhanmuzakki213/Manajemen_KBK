<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getDosen()
    {
        $user = Auth::user()->name;
        $user_email = Auth::user()->email;
        $userDosen = Dosen::where('nama_dosen', $user)
            ->where('email', $user_email)
            ->first();
        return $userDosen;
    }
    /**
     * Display the user's profile form. 
     */
    public function edit(): View
    {
        $userDosen = $this->getDosen();
        $user = Auth::user();
        debug($user);
        debug($userDosen);
        return view('admin.content.profile', [
            'userDosen' => $userDosen,
            'user' => $user,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/profile_pictures');
            $image->move($destinationPath, $name);

            // Hapus gambar lama jika ada
            if ($user->profile_picture) {
                $oldImagePath = public_path('/profile_pictures/' . $user->profile_picture);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $user->profile_picture = $name;
        }
        //dd($user->profile_picture);
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully');
    }

    public function resetProfilePicture()
    {
        $user = Auth::user();

        if ($user->profile_picture) {
            $oldImagePath = public_path('/profile_pictures/' . $user->profile_picture);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        $user->profile_picture = null;
        //dd($user->profile_picture);
        $user->save();

        return response()->json(['success' => 'Profile picture reset successfully']);
    }

    public function updatePassword(Request $request)
    {
        // Validate input
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|max:30|confirmed',
        ]);

        // Check if current password matches
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The provided password does not match your current password.'],
            ]);
        }

        // Update the user's password
        auth()->user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Password changed successfully!',
        ]);
    }
}
