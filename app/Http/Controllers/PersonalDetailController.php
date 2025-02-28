<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\PersonalDetail;
use App\Models\User;
use App\Models\UserAdministrativePositionsHeld;
use App\Models\UserAwardReceive;
use App\Models\UserEducationalBackground;
use App\Models\UserFamily;
use App\Models\UserOtherDetail;
use App\Models\UserOtherInformation;
use App\Models\UserParticipation;
use App\Models\UserProfessionalExamination;
use App\Models\UserReference;
use App\Models\UserSchoolCurricular;
use App\Models\UserSpecialTraining;
use App\Models\UserStudy;
use App\Models\UserValidId;
use App\Models\UserWorkExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class PersonalDetailController extends Controller
{
    public function updatePersonalDetails(Request $request)
    {
        if ($request->isMethod('post') && $request->all() == []) {
            return redirect()->back()->with('error', 'No changes to update.');
        }

        $user = User::find(Auth::user()->id);

        $fieldsToCheck = ['first_name', 'last_name', 'middle_name'];

        $requestData = $request->except([
            'user_families',
            'user_educational_backgrounds',
            'user_professional_examinations',
            'user_award_receives',
            'user_admin_pos_helds',
            'user_work_experiences',
            'user_studies',
            'user_participations',
            'user_special_trainings',
            'user_other_infos',
            'user_school_curriculars',
            'user_references',
            'user_valid_ids',
            'user_other_details'
        ]);

        $filteredData = Arr::only($requestData, $fieldsToCheck);

        if ($filteredData == $requestData) {
            $user->update($filteredData);
        } else {

            $isFirstNameFilled = !empty($requestData['first_name'] ?? null);
            $isLastNameFilled = !empty($requestData['last_name'] ?? null);
            $isMiddleNameFilled = !empty($requestData['middle_name'] ?? null);

            if (
                !$isFirstNameFilled && !$isLastNameFilled && !$isMiddleNameFilled ||
                ($isFirstNameFilled || $isLastNameFilled || $isMiddleNameFilled)
            ) {

                $user->update(Arr::only($requestData, ['first_name', 'last_name', 'middle_name']));


                $userPersonalDetails = PersonalDetail::where('user_id', Auth::user()->id)->first();
                $userPersonalDetails->update(Arr::except($requestData, ['first_name', 'last_name', 'middle_name']));

                $residentialAddressId = $userPersonalDetails->residential_address_id;
                $permanentAddressId = $userPersonalDetails->permanent_address_id;

                $residentialAddress = Address::find($residentialAddressId);
                $permanentAddress = Address::find($permanentAddressId);

                $residentialAddressData = [];
                $permanentAddressData = [];


                foreach ($requestData as $key => $value) {
                    if (strpos($key, 'residential_address.') === 0 && $value) {
                        $residentialAddressData[str_replace('residential_address.', '', $key)] = $value;
                    }
                }

                foreach ($requestData as $key => $value) {
                    if (strpos($key, 'permanent_address.') === 0 && $value) {
                        $permanentAddressData[str_replace('permanent_address.', '', $key)] = $value;
                    }
                }

                if ($residentialAddressData) {
                    $residentialAddress->update($residentialAddressData);
                }

                if ($permanentAddressData) {
                    $permanentAddress->update($permanentAddressData);
                }
            }
        }

        if ($request->has('user_families')) {
            foreach ($request->user_families as $family) {

                if(isset($family['id'])){
                    $existFamilyMember = UserFamily::where('id', $family['id'] )->first();
                }else{
                    $existFamilyMember = null;
                }

                if($existFamilyMember){
                    unset($family['created_at']);
                    unset($family['updated_at']);

                    UserFamily::where('id',  $existFamilyMember->id)
                    ->update($family);

                }else{
                    $family['user_id'] = Auth::user()->id;
                    UserFamily::create($family);
                }

            }
        }

        if($request->has('user_educational_backgrounds')){
            foreach ($request->user_educational_backgrounds as $user_educational_background) {

                if(isset( $user_educational_background['id'])){
                    $userEducExist = UserEducationalBackground::where('id', $user_educational_background['id'])->first();
                }else{
                    $userEducExist= null;
                }

                if( $userEducExist){

                    unset($user_educational_background['id']);
                    unset($user_educational_background['created_at']);
                    unset($user_educational_background['updated_at']);

                    UserEducationalBackground::where('id', $userEducExist->id)
                    ->update($user_educational_background);

                }else{

                    $user_educational_background['user_id'] = Auth::user()->id;
                    UserEducationalBackground::create($user_educational_background);

                }


            }

        }

        if($request->has('user_professional_examinations')){

            foreach($request->user_professional_examinations as $user_professional_examination){

            if(isset( $user_professional_examination['id'])){
                $userProfExamExist = UserProfessionalExamination::where('id', $user_professional_examination['id'])
                ->first();
            }else{
                $userProfExamExist = null;
            }

            if($userProfExamExist){

                unset($user_professional_examination['created_at']);
                unset($user_professional_examination['updated_at']);

                UserProfessionalExamination::where('id', $userProfExamExist->id)
                ->update($user_professional_examination);

            }else{

                $user_professional_examination['user_id'] = Auth::user()->id;
                UserProfessionalExamination::create($user_professional_examination);

            }

            }

        }

        if($request->has('user_award_receives')){

           foreach($request->user_award_receives as $award){


            if(isset($award['id'])){

               $userAwardExist = UserAwardReceive::find($award['id']);

            }else{
                $userAwardExist = null;
            }

            if($userAwardExist){

                unset($award['created_at']);
                unset($award['updated_at']);

                UserAwardReceive::where('id', $userAwardExist->id)
                ->update($award);

            }else{

                $award['user_id'] = Auth::user()->id;
                UserAwardReceive::create($award);

            }

           }

        }

        if($request->has('user_admin_pos_helds')){

            foreach($request->user_admin_pos_helds as $admin_position_held){


                if(isset($admin_position_held['id'])){

                    $adminPosHeldExist = UserAdministrativePositionsHeld::find($admin_position_held['id']);

                }else{

                    $adminPosHeldExist = null;

                }

                if($adminPosHeldExist){

                    unset( $admin_position_held['created_at']);
                    unset( $admin_position_held['updated_at']);

                    UserAdministrativePositionsHeld::where('id', $adminPosHeldExist->id)
                    ->update($admin_position_held);


                }else{
                    $admin_position_held['user_id'] = Auth::user()->id;

                    UserAdministrativePositionsHeld::create($admin_position_held);

                }

            }

        }

        if($request->has('user_work_experiences')){

            foreach($request->user_work_experiences as $experience){


                if(isset( $experience['id'])){

                    $experienceExist = UserWorkExperience::find( $experience['id']);

                }else{
                    $experienceExist = null;
                }

                if($experienceExist){

                    unset( $experience['created_at']);
                    unset( $experience['updated_at']);

                    UserWorkExperience::where('id', $experienceExist->id)->update(
                        $experience
                    );

                }else{

                    $experience['user_id'] = Auth::user()->id;

                    UserWorkExperience::create(
                        $experience
                    );
                }
            }
        }


        if($request->has('user_studies')){

            foreach($request->user_studies as $study){


                if(isset($study['id'])){

                    $studyExist = UserStudy::find($study['id']);
                }else{

                    $studyExist = null;
                }

                if($studyExist){

                    unset($study['created_at']);
                    unset($study['updated_at']);

                    UserStudy::where('id', $studyExist->id)
                    ->update($study);

                }else{

                    $study['user_id'] = Auth::user()->id;
                    UserStudy::create($study);

                }

            };
        }

        if($request->has('user_participations')){

            foreach($request->user_participations as $participation){

                  $participationExist = isset($participation['id']) ? UserParticipation::find($participation['id']) : null;

                  if($participationExist){

                    unset($participation['created_at']);
                    unset($participation['updated_at']);

                    UserParticipation::
                    where('id', $participationExist->id)
                    ->update($participation);

                  }else{

                    $participation['user_id'] = Auth::user()->id;
                    UserParticipation::create($participation);

                  }
            }
        }


        if($request->has('user_special_trainings')){

            foreach($request->user_special_trainings as $training){


                $trainingExist = isset($training['id']) ? UserSpecialTraining::find($training['id']) : null;

                if( $trainingExist){

                    unset($training['created_at']);
                    unset($training['updated_at']);

                    UserSpecialTraining::where('id', $trainingExist->id)
                    ->update($training);

                }else{

                    $training['user_id'] = Auth::user()->id;
                    UserSpecialTraining::create($training);
                }

            }
        }

        if($request->has('user_other_infos')){

            foreach($request->user_other_infos as $info){

                $infoExist = isset($info['id']) ? UserOtherInformation::find($info['id']) : null;

                if($infoExist){
                    unset($info['created_at']);
                    unset($info['updated_at']);

                    UserOtherInformation::where('id', $infoExist->id)->update($info);

                } else{

                    $info['user_id'] = Auth::user()->id;
                    UserOtherInformation::create($info);
                }

            }
        }

        if($request->has('user_school_curriculars')){

            foreach($request->user_school_curriculars as $curricular){

                $curricularExist = isset($curricular['id']) ? UserSchoolCurricular::find($curricular['id']) : null;

                if($curricularExist){

                    unset($curricular['created_at']);
                    unset($curricular['updated_at']);

                    UserSchoolCurricular::where('id', $curricularExist->id)
                    ->update($curricular);

                }else{

                    $curricular['user_id'] = Auth::user()->id;

                    UserSchoolCurricular::create($curricular);

                }
            }
        }



        if($request->has('user_references')){

            foreach($request->user_references as $reference){

                $referenceExist = isset($reference['id']) ? UserReference::find($reference['id']) : null;

                if ($referenceExist) {

                    unset($reference['address']['id']);
                    unset($reference['address']['updated_at']);
                    unset($reference['address']['created_at']);


                    Address::where('id', $reference['address_id'])->update($reference['address']);

                    unset($reference['address']);
                    unset($reference['address_id']);
                    unset($reference['created_at']);
                    unset($reference['updated_at']);

                    UserReference::where('id', $referenceExist->id)->update($reference);

                }else{

                    $address = Address::create($reference['address']);

                    unset($reference['address']);

                    $reference['address_id'] =  $address->id;
                    $reference['user_id'] = Auth::user()->id;

                    UserReference::create($reference);
                }
            }
        }

        if($request->has('user_valid_ids')){

            foreach($request->user_valid_ids as $id){

                $idExist = isset($id['id']) ? UserValidId::find($id['id']) : null;

            if($idExist){

                unset($id['created_at']);
                unset($id['updated_at']);

                UserValidId::where('id', $idExist->id)->update($id);


            }else{

                $id['user_id'] = Auth::user()->id;
                UserValidId::create($id);
            }

            }
        }



        if ($request->has('user_other_details')) {


            $userOtherDetails = $request->input('user_other_details');

            $detailExist = isset($userOtherDetails['id']) ? UserOtherDetail::find($userOtherDetails['id']) : null;

            if ($detailExist) {

                unset($userOtherDetails['created_at']);
                unset($userOtherDetails['updated_at']);


                UserOtherDetail::where('id', $userOtherDetails['id'])->update($userOtherDetails);
            } else {


                $userOtherDetails['user_id'] = Auth::user()->id;


                UserOtherDetail::create($userOtherDetails);
            }

        }


        session()->flash('success', 'Personal details updated successfully!');

        return redirect()->back();

    }

    public function preview(){

        $this->globalVariables();
        $user = $this->user;
        $roles = $this->roles;

        return inertia('Pages/Account/Components/Printable/Printable', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }
}
