<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use DB;

use App\Models\Patients;
use App\Models\User;
use App\Models\Visits;
use App\Models\VitalDetails;
use Illuminate\Support\Facades\Crypt;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\File as FacadesFile;
use Spatie\Backtrace\File;
use Symfony\Component\Console\Input\Input;

class patient_registration_app extends Controller
{
   
    public $FILE_NAME = "temp_store_data.json"; // 


    public function VitalRedirection($bmi)
    {
        if ($bmi < 25) {
            return redirect('/patients/vital/form/section-a');
        }
        return redirect('/patients/vital/form/section-b');
    }
    public function VitalForm(Request $request)
    {
        $PATIENT_ID = $request->patient_id;
        $PATIENT_HEIGHT = (int) $request->height;
        $PATIENT_WEIGHT = (float) $request->weight;

        $PATIENT_BMI = number_format($PATIENT_WEIGHT / pow(($PATIENT_HEIGHT * .01), 2), 2, '.', ',');
        //create an object of the values to be saved temporary
        $data = [
            "patient_id" => $PATIENT_ID,
            "Height" => $PATIENT_HEIGHT,
            "weight" => $PATIENT_WEIGHT,
            "bmi" => $PATIENT_BMI
        ];
        // Store vital form data to be saved later
        if (Storage::disk('public')->exists($this->FILE_NAME)) {
            $FileData = json_decode(Storage::disk('public')->get($this->FILE_NAME));
            if ($FileData === null) {
                Storage::disk('public')->put($this->FILE_NAME, json_encode([$data]));

                // redirection to section page based on BMI
                return $this->VitalRedirection((float)$PATIENT_BMI)->with("patient_id", $PATIENT_ID);
            } else {
                $object = null;
                foreach ($FileData as $key => $value) {
                    if (Crypt::decrypt($value->patient_id) == Crypt::decrypt($data['patient_id'])) {
                        $object = $key;
                        break;
                    }
                }
                if ($object !== null) {
                    array_splice($FileData, $object, 1);
                }
                array_push($FileData, $data);

                Storage::disk('public')->put($this->FILE_NAME, json_encode($FileData));
                return $this->VitalRedirection((float)$PATIENT_BMI)->with("patient_id", $PATIENT_ID);
            }
        } else {
            Storage::disk('public')->put($this->FILE_NAME, json_encode([$data]));
            return $this->VitalRedirection((float)$PATIENT_BMI)->with("patient_id", $PATIENT_ID);
        }
    }

    public function GetVisits(Request $req)
    {
        $visitsData = [];
        $patients = Patients::all();
        $visitsDetails = VitalDetails::all();
        $visits = Visits::all();

        foreach ($visitsDetails as $key => $vd) {
            foreach ($visits as $v) {
                if ($vd->visit_id == $v->id) {
                    foreach ($patients as $p) {
                        if ($vd->patient_id == $p->patient_id) {
                            $bmiVal = (float) $v->bmi;

                            $vd['Patient_name'] = $p->first_name . " " . $p->last_name;
                            $vd['age'] = (int)date_diff(date_create($p->birth_date), date_create('now'))->format("%Y%") * 1;
                            $vd['height'] = $v->height;
                            $vd['weight'] = $v->weight;
                            $vd['bmiVal'] = $v->bmi;
                            $vd['bmi'] = ($bmiVal < 18.5) ? "Underweight" : (($bmiVal > 18.5 && $bmiVal < 25) ? "Normal" : "Overweight");
                        }
                    }
                }
            }
        }

        return view('layouts/patients/visits', ['user' => auth()->user(), 'data' => $visitsDetails]);
    }
    public function LogOut(Request $req)
    {
        auth()->logout();
        return redirect('/');
    }
    // public function GetPatients(Request $req)
    // {

    //     $patients = Patients::all();

    //     return view('layouts/patients/patientList', ['data' => $patients, 'user' => json_encode($this->AUTH_USER)]);
    // }

    public function CancelVital(Request $request)
    {
        $patientID = Crypt::decrypt($request->patient_id);
        $FileData = json_decode(Storage::disk('public')->get($this->FILE_NAME));
        $object = null;
        foreach ($FileData as $key => $value) {
            if (Crypt::decrypt($value->patient_id) == $patientID) {
                $object = $key;
                break;
            }
        }

        if ($object !== null) {
            array_splice($FileData, $object, 1);
        }
        Storage::disk('public')->put($this->FILE_NAME, json_encode($FileData));
        return redirect(route('get.patients'));
    }
    public function SectionBackWithData(Request $request)
    {
        $patientID = Crypt::decrypt($request->patient_id);
        $FileData = json_decode(Storage::disk('public')->get($this->FILE_NAME));
        $object = null;
        foreach ($FileData as $key => $value) {
            if (Crypt::decrypt($value->patient_id) == $patientID) {
                $object = $key;
                break;
            }
        }
        $storedData = $FileData[$object];
        return redirect('/patients/vital')->with('data', $storedData)->with('patient_id', $request->patient_id);
    }
    public function VitalFormSection(Request $request)
    {
        $patientID = Crypt::decrypt($request->patient_id);
        $gn_health = $request->general_health;
        $comment = $request->comment;
        $ondiet = null;
        $ondrug = null;

        $FileData = json_decode(Storage::disk('public')->get($this->FILE_NAME));
        $object = null;
        foreach ($FileData as $key => $value) {
            if (Crypt::decrypt($value->patient_id) == $patientID) {
                $object = $key;
                break;
            }
        }
        $storedData = $FileData[$object];

        if (isset($request->ondiet)) {
            $ondiet = $request->ondiet;
        }
        if (isset($request->ondrug)) {
            $ondrug = $request->ondrug;
        }

        $visitId = rand(10000, 1000000);

        $postVD = new VitalDetails();
        $post = new Visits();
        $post->id = $visitId;
        $post->patient_id = Crypt::decrypt($storedData->patient_id);
        $post->date = date('Y-m-d h:i:s');
        $post->height = $storedData->Height;
        $post->weight = $storedData->weight;
        $post->bmi = (float)$storedData->bmi;
        $post->timestamps = false;

        $postVD->visit_id = $visitId;
        $postVD->patient_id = Crypt::decrypt($storedData->patient_id);
        $postVD->date = date('Y-m-d h:i:s');
        $postVD->health = $gn_health;
        $postVD->onDiet = $ondiet;
        $postVD->onDrugs = $ondrug;
        $postVD->comments = $comment;
        $postVD->timestamps = false;

        if ($post->save() && $postVD->save()) {
            if ($object !== null) {
                array_splice($FileData, $object, 1);
            }
            Storage::disk('public')->put($this->FILE_NAME, json_encode($FileData));
            return redirect('/patients/new')->with('entry_success', 'Information successfully added ');
        }

        // return back()->with('entry_error', $gn_health.' -->L<-- '..' A '.$ondrug )->with("patient_id",Crypt::decrypt($request->patient_id));
        // if($request->form_name == "section_a"){
        //     $ondiet = $request->ondiet;

        // }
        // if($request->form_name == "section_b"){
        //     $ondrug = $request->ondrug;

        // }

    }

    public function registerPatients(Request $request)
    {
        $p_id = "PT-" . rand(1000, 10000);
        $fname = $request->fname;
        $lname = $request->lname;
        $bod = $request->bod;
        $email = $request->email;
        $gender = $request->gender;

        // 'email' => 'required|email|unique:patients',
        $request->validate([
            'fname' => 'required|max:50',
            'lname' => 'required|max:50',
            'bod' => 'required|date',
            'email' => 'required|email',
            'gender' => 'required',
        ]);

        $userExists = Patients::where('email', '=', $email)->exists();
        if ($userExists) {
            return redirect('/patients/vital')->with('patient_id', Crypt::encrypt(Patients::select('patient_id')->where('email', '=', $email)->get()[0]->patient_id));
            // return back()->with('entry_error', 'A user with Same email is already Registered ' . $userExists);
        } else {

            $post = new Patients();

            $post->patient_id = $p_id;
            $post->first_name = $fname;
            $post->last_name = $lname;
            $post->birth_date = $bod;
            $post->email = $email;
            $post->gender = $gender;
            $post->timestamps;

            if ($post->save()) {
                // $EmailTitle = 'Welcome to International Student Affaires.';
                // $subject = 'Account Creation';
                // $msg='
                // <p>Your account has successfully been created. Click on the link below to access the system. </p>
                // <p><a href="http://localhost:8000/" style="padding:5px; border-radius:5px; background:rgb(17,60,122); color:#fff; ">Login Now</a></p>
                // <p>Please remember to change your password to improve your account security. </p>';

                // return redirect()->route('emailsend',[$subject, $request->email,$EmailTitle,Crypt::encryptString($msg)]);

                return redirect('/patients/vital')->with('patient_id', Crypt::encrypt($p_id));
                // return back()->with('entry_success', 'A New Patient has been registered Successfully');
            } else {
                return back()->with('entry_error', 'Patient could not be added. Try later.');
            }
        }
    }


    
}
