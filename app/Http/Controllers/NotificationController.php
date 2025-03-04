<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class NotificationController extends Controller
{
    public function create($title, $description, $type, $for, $link){

        if($for === 'all'){

            $userIds = User::orderBy('id', 'ASC')->get()->pluck('id');
            $for =  $userIds->implode(', ');

        }else if($for === 'staff'){

            $staffs = User::role('staff')->get()->pluck('id'); 
            $for = $for . $staffs->implode(', ');

        
        }else if($for === 'admin'){

            $admins = User::role('admin')->get()->pluck('id'); 
            $for = $for . $admins->implode(', ');

            
        }else if($for === 'p-admin'){

            $p_admins = User::role('p-admin')->get()->pluck('id'); 
            $for = $p_admins;

        
        }else if($for === 'vp-admin'){

            $vp_admins = User::role('vp-admin')->get()->pluck('id'); 
            $for = $vp_admins;

        

        }else if($for === 'vp-acad'){

            $vp_acads = User::role('vp-acad')->get()->pluck('id'); 
            $for = $vp_acads;

        
        }else if($for === 'hr'){

            $hrs = User::role('hr')->get()->pluck('id'); 
            $for = $hrs;

        }else if($for === 'dean'){

            $departmentId = UserDepartment::where('user_id', Auth::user()->id)->pluck('department_id')->first();
            $userIds = UserDepartment::where('type', 'head')->where('department_id', $departmentId)->pluck('user_id');

            $for = $userIds;

        }else{
            $for = '['.$for.']';
        }

        Notification::create([
            'title' => $title,
            'description' => $description,
            'type' => $type,
            'for' => $for ,            
            'link' => $link
        ]);
    }

    public function fetch($id)
    {

        $notifications = Notification::orderBy('created_at', 'DESC')->get();
    
        $filteredNotifications = $notifications->filter(function ($notification) use ($id) {
            $array = json_decode($notification->for, true);
            $arrayDeleted = json_decode($notification->isDeletedBy, true);
    
            if (!is_array($array)) {
                $array = [];
            }

            if (!is_array($arrayDeleted)) {
                $arrayDeleted = [];
            }
    
            return in_array($id, $array) && !in_array($id, $arrayDeleted);
        });
    
       
        return $filteredNotifications;
    }
    

    public function read($id , $type)
    {
        $id = (int)$id;
        $type = (string)$type;
       
        if($type != 'all'){
            $notifications = Notification::whereJsonContains('for', $id * 1)
            ->where('type', $type)->get(); 
    
       
            foreach ($notifications as $notification) {
               
                $isReadBy = json_decode($notification->isReadBy, true);
        
                
                if (!is_array($isReadBy)) {
                    $isReadBy = [];
                }
        
              
                if (!in_array($id, $isReadBy)) {
                    $isReadBy[] = $id; 
                }
        
               
                $notification->isReadBy = json_encode($isReadBy);
                $notification->save();
            }
        }else{

           
            $notifications = Notification::whereJsonContains('for', $id)
            ->whereJsonDoesntContain('isReadBy', $id)
            ->whereJsonDoesntContain('isDeletedBy', $id)
            ->get(); 
    
            foreach ($notifications as $notification) {

               
               
                $isReadBy = json_decode($notification->isReadBy, true);
                $for = json_decode($notification->for, true);
               
        
                
                if (!is_array($isReadBy)) {
                    $isReadBy = [];
                }
        
              
                if (!in_array($id, $isReadBy)) {
                    $isReadBy[] = $id; 
                }
        
                $notification->isReadBy = json_encode($isReadBy);
                $notification->save();

    
                if($for === $isReadBy){
                    $notification->delete();
                }

                
            }

            return redirect()->back()->with('success', 'Notifications marked as all read successfully!');
        }
       
       
    }
    

    public function delete($id , $type)
    {
        
        $id = (int)$id;
        $type = (string)$type;
           
            $notifications = Notification::whereJsonContains('for', $id)
            ->whereJsonDoesntContain('isDeletedBy', $id)
            ->get(); 
    
            foreach ($notifications as $notification) {
               
                $isDeletedBy = json_decode($notification->isDeletedBy, true);
        
                
                if (!is_array($isDeletedBy)) {
                    $isDeletedBy = [];
                }
        
              
                if (!in_array($id, $isDeletedBy)) {
                    $isDeletedBy[] = $id; 
                }
        
                $notification->isDeletedBy = json_encode($isDeletedBy);
                $notification->save();

                
            }

            return redirect()->back()->with('success', 'Notifications deleted successfully!');
        
       
       
    }
}
