<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function updateProfilePicture(Request $request)
    {
        $validatedData = $request->validate([
            'image' => ['required', 'string'],
        ]);
    
        $imageData = $request->input('image');
    
        if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $matches)) {
            $extension = $matches[1];
            $imageData = substr($imageData, strpos($imageData, ',') + 1);
            $imageData = base64_decode($imageData);
    
            if (!$imageData) {
                return redirect()->back()->with('error', 'Invalid image data.');
            }
    
           
            $path = 'public/users/images';

            if (!Storage::exists($path)) {
                Storage::makeDirectory($path, 0775, true);
            }
            
          
            $userId = (string)Auth::user()->id;  
            
           
            $files = Storage::files($path);
            
            foreach ($files as $file) {
               
                $filePrefix = strtok(basename($file), '-');
            
                if ($filePrefix === $userId) {
                    Storage::delete($file);
                }
            }
            
    
            $dateTimeNow = Carbon::now()->format('Y-m-d-h-s');
            $fileName = Auth::user()->id . '-' . $dateTimeNow . '.' . $extension;
    
            $storedPath = Storage::put($path . '/' . $fileName, $imageData);
    
            User::find(Auth::user()->id)->update([
                'img' => $fileName,
            ]);
    
            if ($storedPath) {
                session()->flash('success', 'Image uploaded successfully!');
                return redirect()->route('account');
            } else {
                return redirect()->back()->with([
                    'error' => 'Error uploading the new image.',
                ]);
            }
        } else {
            return redirect()->back()->with('error', 'Invalid image format.');
        }
    }
}    