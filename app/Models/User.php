<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable;

    protected $guarded = ['password'];

    public function personalDetails()
    {
        return $this->hasOne(PersonalDetail::class);
    }

    public function userJobDetails()
    {
        return $this->hasMany(UserJobDetail::class);
    }

    public function userFamilies(){
        return $this->hasMany(UserFamily::class);
    }


    public function userEducationalBackgrounds(){
        return $this->hasMany(UserEducationalBackground::class);
    }
    public function userProfessionalExaminations(){
        return $this->hasMany(UserProfessionalExamination::class);
    }
    public function userAwardReceives(){
        return $this->hasMany(UserAwardReceive::class);
    }
    public function userAdminPosHelds(){
        return $this->hasMany(UserAdministrativePositionsHeld::class);
    }
    public function userWorkExperiences(){
        return $this->hasMany(UserWorkExperience::class);
    }
    public function userStudies(){
        return $this->hasMany(UserStudy::class);
    }

    public function userParticipations(){
        return $this->hasMany(UserParticipation::class);
    }
    public function userSpecialTrainings(){
        return $this->hasMany(UserSpecialTraining::class);
    }
    public function userOtherInfos(){
        return $this->hasMany(UserOtherInformation::class);
    }
    public function userSchoolCurriculars(){
        return $this->hasMany(UserSchoolCurricular::class);
    }
    public function userOtherDetails(){
        return $this->hasMany(UserOtherDetail::class);
    }
    public function userReferences(){
        return $this->hasMany(UserReference::class);
    }
    public function userValidIds(){
        return $this->hasMany(UserValidId::class);
    }

    public function substitute(){
        return $this->hasMany(Substitute::class);
    }
}
