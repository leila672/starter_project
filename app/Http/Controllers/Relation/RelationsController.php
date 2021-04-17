<?php

namespace App\Http\Controllers\Relation;

use App\Http\Controllers\Controller;
use App\models\phone;
use App\User;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Service;
use Illuminate\Http\Request;

class RelationsController extends Controller
{
    ################### one to one relationship mehtods #########

    public function hasOneRelation()
    {
         $user = \App\User::with(['phone' => function ($q) {
            $q->select('code', 'phone','user_id');
        }])->find(5);

      return $user -> phone -> code;
        // $phone = $user -> phone;

        return response()->json($user);
    }
 public function hasOneRelationReverse()
 {
     $phone = Phone::with(['user' => function ($q) {
         $q->select('id', 'name');
     }])->find(1);

     $phone= phone::find(1);
     $phone->makeVisible(['user_id']);
     return $phone ;
 }
    public function getUserHasPhone()
    {
        return User::whereHas('phone')->get();
    }

    public function getUserNotHasPhone()
    {
        return User::whereDoesntHave('phone')->get();
    }

    public function getUserWhereHasPhoneWithCondition()
    {
        return User::whereHas('phone', function ($q) {
            $q->where('code', '02');
        })->get();
    }


    ################### one to many relationship mehtods #########

    public function getHospitalDoctors()
    {
        $hospital = Hospital::find(1);

       // return $hospital = Hospital::with('doctors')->find(1);;

        //return $hospital -> name;

        $doctors = $hospital->doctors;

        /*foreach ($doctors as $doctor) {
            echo $doctor->name . '<br>';
        }*/

        $doctor = Doctor::find(3);

         return $doctor->hospital->name;

    }

    public function hospitals()
    {

        $hospitals = Hospital::select('id', 'name', 'address')->get();
        return view('doctors.hospitals', compact('hospitals'));
    }

    public function doctors($hospital_id)
    {

        $hospital = Hospital::find($hospital_id);
        $doctors = $hospital->doctors;
        return view('doctors.doctors', compact('doctors'));
    }

    // get all hospital which must has doctors
    public function hospitalsHasDoctor()
    {
        return $hospitals = Hospital::whereHas('doctors')->get();
    }

    public function hospitalsHasOnlyMaleDoctors()
    {
        return $hospitals = Hospital::with('doctors')->with('doctors', function ($q) {
            $q->where('gender', 1);
        })->get();
    }


    public function hospitals_not_has_doctors()
    {

        return Hospital::whereDoesntHave('doctors')->get();
    }

    public function deleteHospital($hospital_id)
    {
        $hospital = Hospital::find($hospital_id);
        if (!$hospital)
            return abort('404');
        //delete doctors in this hospital
        $hospital->doctors()->delete();
        $hospital->delete();

        return redirect() -> route('hospital.all');
    }

    public function getDoctorServices()
    {
        return $doctor = Doctor::with('services')->find(2);
        //  return $doctor -> services;
    }

    public function getServiceDoctors()
    {
        return $doctors = Service::with(['doctors' => function ($q) {
            $q->select('doctors.id', 'name', 'title');
        }])->find(1);
    }

    public function getDoctorServicesById($doctorId)
    {
        $doctor = Doctor::find($doctorId);
        $services = $doctor->services;  //doctor services

        $doctors = Doctor::select('id', 'name')->get();
        $allServices = Service::select('id', 'name')->get(); // all db serves

        return view('doctors.services', compact('services', 'doctors', 'allServices'));


    }


    public function saveServicesToDoctors(Request $request)
    {

        $doctor = Doctor::find($request->doctor_id);

        if (!$doctor)
            return abort('404');
        // $doctor ->services()-> attach($request -> servicesIds);  // many to many insert to database
        //$doctor ->services()-> sync($request -> servicesIds);
        $doctor->services()->syncWithoutDetaching($request->servicesIds);
        return 'success';
    }

}
