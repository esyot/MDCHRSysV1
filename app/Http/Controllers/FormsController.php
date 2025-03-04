<?php

namespace App\Http\Controllers;

use App\Models\LeaveForm;
use App\Models\Notification;
use App\Models\TravelForm;
use App\Models\UserDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormsController extends Controller
{
    public function index()
    {
        $this->globalVariables();
        $roles = $this->roles;
        $user = Auth::user();

        $notificationsController = new NotificationController();
        $notificationsController->read(Auth::user()->id,  'tracking');

           
        $travelForms = TravelForm::where('user_id', $user->id)
        ->with([
            'substitutes',
              'substitutes.user'
        ])
        ->orderBy('created_at', 'ASC')
        ->get();
            

        $leaveForms = LeaveForm::where('user_id', Auth::user()->id)
        ->with([
            'substitutes',
            'substitutes.user'
        ])
        ->orderBy('created_at', 'ASC')
        ->get();



        $travelForms->transform(function ($form) use ($user) {
            $form->first_name = $user->first_name;
            $form->last_name = $user->last_name;
            $form->middle_name = $user->middle_name;
            return $form;
        });
            
       
       
        $forms = [];
        $forms['Travel Form'] = $travelForms;
        $forms['Leave Form'] = $leaveForms;
        
          
        $flattenedForms = [];
        foreach ($forms as $formType => $formArray) {
            foreach ($formArray as $form) {
                $form['form_type'] = $formType;
                $flattenedForms[] = $form;
            }
        }
        
        usort($flattenedForms, function($a, $b) {
           return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

       
        
        return inertia('Pages/Forms/Tracking/Tracking', [
            'roles' => $roles,
            'user' => $user,
            'forms' => $flattenedForms,
            'messageSuccess' => session('success') ?? null,
            'pageTitle'=> 'Track Forms'
        ]);
            
    }

    public function checking($action=null){

            $this->globalVariables();
            $roles = $this->roles;
            $user = $this->user;

            $notificationsController = new NotificationController();
            $notificationsController->read($user->id,  'checking');

            $travelForms = [];
            $leaveForms = [];
            
            if($roles->contains('vp-admin')){

                $leaveForms = LeaveForm::where('status', 'hr_approved')
                ->with([
                    'substitutes.user',
                    'user',
                    'endorser',
                    'userJobDetail',
                   
                ])->orderBy('created_at', 'ASC')->get();

                $travelForms = TravelForm::where('status', 'hr_approved' )
                ->orderBy('created_at', 'ASC')
                ->with([
                    'substitutes.user',
                    'user',
                    'endorser',
                    'userJobDetail',
                   
                ])->orderBy('created_at', 'ASC')->get();


            }else if($roles->contains('hr')){
                
                $leaveForms = LeaveForm::where('status', 'dean_approved')
                ->with([
                    'substitutes.user',
                    'user',
                    'recommender',
                    'userJobDetail',
                   
                ])->orderBy('created_at', 'ASC')->get();

                $travelForms = TravelForm::where('status', 'dean_approved' )
                
                ->orderBy('created_at', 'ASC')
                ->with([
                    'substitutes.user',
                    'user',
                    'recommender',
                    'userJobDetail',
                   
                ])->orderBy('created_at', 'ASC')->get();

            }
            else if($roles->contains('dean')) {

                $departmentIds = UserDepartment::where('user_id', $user->id)->pluck('department_id')->toArray();
                
                $userIds = UserDepartment::whereIn('department_id', $departmentIds)->pluck('user_id')->toArray();
    
                $leaveForms = LeaveForm::whereIn('user_id', $userIds)
                    ->where('status', 'pending')
                    ->with([
                        'substitutes.user',
                        'user',
                        'endorser',
                        'userJobDetail',
                    ])->orderBy('created_at', 'ASC')->get();
    
                $travelForms = TravelForm::whereIn('user_id', $userIds)
                    ->where('status', 'pending')
                    ->orderBy('created_at', 'ASC')
                    ->with([
                        'substitutes.user',
                        'user',
                        'endorser',
                        'userJobDetail',
                    ])->orderBy('created_at', 'ASC')->get();
            }

            else if($roles->contains('vp-acad')){

    
                $leaveForms = LeaveForm::where('status', 'vp_admin_approved')
                ->with([
                    'substitutes.user',
                    'user',
                    'endorser',
                    'userJobDetail',
                   
                ])->orderBy('created_at', 'ASC')->get();

                $travelForms = TravelForm::where('status', 'vp_admin_approved' )
                ->orderBy('created_at', 'ASC')
                ->with([
                    'substitutes.user',
                    'user',
                    'endorser',
                    'userJobDetail',
                   
                ])->orderBy('created_at', 'ASC')->get();
                               
            }    
            else if($roles->contains('p-admin')){
                $leaveForms = LeaveForm::where('status', 'vp_acad_approved')
                ->with([
                    'substitutes.user',
                    'user',
                    'endorser',
                    'userJobDetail',
                   
                ])->orderBy('created_at', 'ASC')->get();


                $travelForms = TravelForm::where('status', 'vp_acad_approved' )
                ->orderBy('created_at', 'ASC')
                ->with([
                    'substitutes.user',
                    'user',
                    'endorser',
                    'userJobDetail',
                   
                ])->orderBy('created_at', 'ASC')->get();
               
            }             
        
           
            $forms = [];
            $forms['Travel Form'] = $travelForms;
            $forms['Leave Form'] = $leaveForms;

            
            $flattenedForms = [];
            foreach ($forms as $formType => $formArray) {
                foreach ($formArray as $form) {
                    $form['form_type'] = $formType;
            
                    $form['endorser'] = $form['endorser'] ? $form['endorser']->toArray() : null;
                    $form['user_job_detail'] = $form['user_job_detail'] ? $form['user_job_detail']->toArray() : null;
                    
                    $flattenedForms[] = $form;
                }
            }
  
            usort($flattenedForms, function($a, $b) {
               return strtotime($b['created_at']) - strtotime($a['created_at']);
            });
              
            return inertia('Pages/Forms/Checking/Checking', [
                'user' => $user,
                'pageTitle' => 'Checking',
                'selected' => $action ?? 'all',
                'forms' => $flattenedForms, 
                'roles' => $roles,
                'messageSuccess' => session('success') ?? null,
            ]);
        
    }

    public function forward(Request $request){

        $this->globalVariables();
        $user = $this->user;

    
       if($request->action == 'dean_approved'){
        if($request->form_type == 'Leave Form'){

            LeaveForm::find($request->id)
            ->update([
                'status' => $request->action,
                'recommended_by' => Auth::user()->id,
            ]);

            $notificationController = new NotificationController();
            $notificationController->create(
                'Leave Form',
                $user->last_name .', '. $user->first_name . ' forwarded a leave application, check it now.',
                'checking',
                'hr',
                '/forms/checking'
            );
           }

        if($request->form_type == 'Travel Form'){

            TravelForm::where('id', $request->id)
            ->where('user_id', $request->user_id)
            ->update([
                'status' => $request->action,
                'recommended_by' => Auth::user()->id,
            ]);
           }

           $notificationController = new NotificationController();
           $notificationController->create(
               'Travel Form',
               $user->last_name .', '. $user->first_name . ' forwarded a travel form, check it now for approval.',
               'checking',
               'hr',
               '/forms/checking'
           );
       }



       if($request->action == 'hr_approved'){

        if($request->form_type == 'Leave Form'){
 
         LeaveForm::find($request->id)
         ->update([
             'status' => $request->action,
             'endorsed_by' => Auth::user()->id,
         ]);

         $notificationController = new NotificationController();
         $notificationController->create(
             'Leave Form',
             $user->last_name .', '. $user->first_name . ' forwarded a leave application, check it now for approval',
             'checking',
             'vp-admin',
             '/forms/checking'
         );
        }
        else if($request->form_type == 'Travel Form'){

            TravelForm::where('id', $request->id)
            ->where('user_id', $request->user_id)
            ->update([
                'status' => $request->action,
                'endorsed_by' => Auth::user()->id,
            ]);
           }

           $notificationController = new NotificationController();
           $notificationController->create(
               'Travel Form',
               $user->last_name .', '. $user->first_name . ' forwarded a travel application, check it now for approval',
               'checking',
               'vp-admin',
               '/forms/checking'
           );
        
        }

       if($request->action == 'vp_admin_approved'){
        if($request->form_type == 'Leave Form'){

            LeaveForm::find($request->id)
            ->update([
                'days_with_pay'=> $request->days_with_pay ?? 0,
                'days_without_pay'=> $request->days_with_pay ?? 0,
                'status' => $request->action,
               
            ]);

            $notificationController = new NotificationController();
            $notificationController->create(
             'Leave Form',
             $user->last_name .', '. $user->first_name . ' forwarded a leave application, check it now for approval',
             'checking',
             'vp-acad',
             '/forms/checking'
         );
           }else if($request->form_type == 'Travel Form'){

            TravelForm::where('id', $request->id)
            ->where('user_id', $request->user_id)
            ->update([
                'status' => $request->action,
            ]);

            $notificationController = new NotificationController();
            $notificationController->create(
             'Travel Form',
             $user->last_name .', '. $user->first_name . ' forwarded a travel application, check it now for approval',
             'checking',
             'vp-acad',
             '/forms/checking'
         );
           }
       }

       if($request->action == 'vp_acad_approved'){
        if($request->form_type == 'Leave Form'){

            LeaveForm::find($request->id)
            ->update([
                'status' => $request->action,
            ]);

            $notificationController = new NotificationController();
            $notificationController->create(
             'Leave Form',
             $user->last_name .', '. $user->first_name . ' forwarded a leave application, check it now for approval',
             'checking',
             'p-admin',
             '/forms/checking'
            );
           }else if($request->form_type == 'Travel Form'){

            TravelForm::where('id', $request->id)
            ->where('user_id', $request->user_id)
            ->update([
                'status' => $request->action,
            ]);

            $notificationController = new NotificationController();
            $notificationController->create(
             'Travel Form',
             $user->last_name .', '. $user->first_name . ' forwarded a leave application, check it now for approval',
             'checking',
             'p-admin',
             '/forms/checking'
            );
           }

       }

       if($request->action == 'p_admin_approved'){
        if($request->form_type == 'Leave Form'){

            LeaveForm::find($request->id)
            ->update([
                'status' => 'approved',
            ]);

            $notificationController = new NotificationController();
            $notificationController->create(
             'Leave Form',
             $user->last_name .', '. $user->first_name . ' approved your leave application, check it now.',
             'tracking',
             $request->user_id,
             '/forms/tracking'
            );

           }else if($request->form_type == 'Travel Form'){

            TravelForm::where('id', $request->id)
            ->where('user_id', $request->user_id)
            ->update([
                'status' => 'approved',
            ]);

            $notificationController = new NotificationController();
            $notificationController->create(
             'Travel Form',
             $user->last_name .', '. $user->first_name . ' approved your travel application, check it now.',
             'tracking',
             $request->user_id,
             '/forms/tracking'
            );
           }

       }

       if($request->action == 'disapproval'){
        if($request->form_type == 'Leave Form'){

            LeaveForm::find($request->id)
            ->update([
                'status' => 'declined',
                'disapproved_by' => Auth::user()->id,
                'disapproval_description' => $request->disapproval_description
               
            ]);
           }

       }

       return redirect()->back()->with([
        'success'=>'Form submitted successfully!'
       ]);

    }
    public function find($form_type, $user_id, $year)
    {
        $forms = [];

        if ($form_type === 'Leave Form') {
            $forms = LeaveForm::whereYear('date_start', $year)
                ->where('user_id', $user_id)
                ->where('status', 'approved')
                ->select([
                    'id',
                    'user_id',
                    'leave_type',
                    'date_start',
                    'date_end',
                    'created_at',
                    'status',
                ])->get() ?? null;
        } else if ($form_type === 'Travel Form') {
            $forms = TravelForm::whereYear('date_start', $year)
                ->where('user_id', $user_id)
                ->where('status', 'approved')
                ->select([
                    'id',
                    'user_id',
                    'date_start',
                    'date_end',
                    'semister',
                    'created_at',
                    'status',
                ])->get() ?? null;
        } else {
            return response()->json(['message' => 'Invalid form type'], 400);
        }

        return response()->json($forms);
    }

    public function delete($type, $id){
        if($type == 'Leave Form'){
            LeaveForm::find($id)->delete();
        }else if($type == 'Travel Form'){
            TravelForm::find($id)->delete();
        }

        return redirect()->back()->with([
            'success'=>'Form deleted successfully!'
        ]);
    }    
}
