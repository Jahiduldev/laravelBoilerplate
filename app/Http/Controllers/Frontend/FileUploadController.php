<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\User\IUserRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FileUploadController extends Controller
{


    public function upload(Request $request)
    {

        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            $userRepository = app(IUserRepository::class);
    
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('upload/user_images'), $imageName);
                $imagePath = 'upload/user_images/' . $imageName;
                $userRepository->update(Auth::id(), ['photo' => $imagePath]);
                return $this->success(['file_url' => asset($imagePath)], "File uploaded successfully");
            }
        } catch (Exception $e) {
            return $this->error('Error', [$e->getMessage()]);
        }
    }
}
