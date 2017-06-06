<?php
namespace Helpers;
use City; use Excel; use File; use User2016; use Crypt; use DateTime; use Log; use School; use Admins; use Centre; use CityRep;

class Helper
{
    public static function helloWorld()
    {
        return 'Hello World';
    }

    public static function checkmail($email){
        $access_key = '2d2034b57f4157fed390d5fd62071678';	//technothlon.iitg@gmail.com
        $result=array();
        $ch = curl_init('http://apilayer.net/api/check?access_key='.$access_key.'&email='.$email.'');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        curl_close($ch);
        $validationResult = json_decode($json, true);
        if (array_key_exists('smtp_check', $validationResult)){
            if($validationResult['smtp_check']){
                $result['val']=1;
                $result['email']=$email;
            }
            else if($validationResult['did_you_mean']){
                $result['email']=$validationResult['did_you_mean'];
                $result['val']=1;
            }
            else{
                $result['val']=0;
                $result['email']=$email;
            }
        }
        else{
            $result['error']=$validationResult['error']['type'];
        }
        return $result;
    }

    public static function schoolregfilename($school){
        $city=City::find($school->city_id)->name;
        $filename = $school->city_id . '_' .$city.'_' . $school->id . '_' . $school->name.'.xlsx';
        return $filename;
    }

    public static function genregsheet($school)
    {                
        $school->status = 1;
        $school->save();
        $filename = Helper::schoolregfilename($school);
        $filename = substr($filename, 0,-5);
        Excel::create($filename, function ($excel) use ($school) {
            $excel->setTitle('Registrations');
            $excel->setCreator('Technothlon')
                ->setCompany('Technothlon');
            $excel->setDescription('Registration details for ' . $school->name);            
            if(User2016::where('school_id', $school->id)->whereIn('mode',[0,2])->whereSquad('JUNIORS')->count() !== 0){
                $excel->sheet('JUNIORS', function ($sheet) use ($school) {
                    $sheet->appendRow(array('Name 1', 'Name 2', 'Roll', 'Password', 'Email 1', 'Email 2', 'Contact 1', 'Contact2'));
                    $users = array();
                    foreach (User2016::where('school_id', $school->id)->whereIn('mode',[0,2])->whereSquad('JUNIORS')->get() as $user) {                        
                        $users[] = array($user->name1, $user->name2, $user->roll, Crypt::decrypt($user->password_enc), $user->email1, $user->email2, $user->contact1, $user->contact2);
                    }
                    $sheet->rows($users);
                });
            }

            if(User2016::where('school_id', $school->id)->whereIn('mode',[0,2])->whereSquad('HAUTS')->count() !== 0)
            {
                $excel->sheet('HAUTS', function ($sheet) use ($school) {
                    $sheet->appendRow(array('Name 1', 'Name 2', 'Roll', 'Password', 'Email 1', 'Email 2', 'Contact 1', 'Contact2'));
                    $users = array();
                    foreach (User2016::where('school_id', $school->id)->whereIn('mode',[0,2])->whereSquad('HAUTS')->get() as $user) {
                        $users[] = array($user->name1, $user->name2, $user->roll, Crypt::decrypt($user->password_enc), $user->email1, $user->email2, $user->contact1, $user->contact2);
                    }
                    $sheet->rows($users);
                });
            }
        })->store('xlsx', storage_path('files/regsheets'));
        $now=new DateTime();
        File::append(storage_path('reports/regsheet_generated_schools.txt'),$now->format('d-m-Y H:i:s')."\n".$school."\n\n");
    }

    public static function email_pattern($email){
        $regex_email = "/^[a-zA-Z0-9._]+@[a-zA-Z.]+$/";
        if(!preg_match($regex_email,$email))
            return 0;
        return 1;
    }
    
    public static function newroll($squad,$language,$centre_city,$mode){
        $roll="";
        if($squad === 'JUNIORS') {
            $roll="J";
        }
        else {
            $roll="H";
        }
        if($language === 'en') {
            $roll .= "E";
        }
        else {
            $roll .= "H";
        }
        $centre_id=City::find($centre_city/10);
        $roll .= $centre_id->code;
        $roll .= $mode;
        $lastreg=User2016::withTrashed()->where('roll', 'LIKE', "%$roll%")->orderBy('roll','desc')->first();
        if($lastreg)
            $lastroll=intval(substr($lastreg->roll,-4));
        else
            $lastroll=0;
        $roll .= str_pad(strval($lastroll+1), 4, "0", STR_PAD_LEFT);
        
        return $roll;    
    }

    public static function examendtime($start){
        $time = explode(":",$start);
        $hr = intval($time[0]);
        $min = intval($time[1]);
        $min += 30;
        $hr += intval($min/60) + 2;
        $min = $min%60;
        if($min<10)
            $min = '0'.$min;
        $end = $hr.":".$min;
        return $end;
    }

    public static function kvattendancesheet($id){
        $kv = School::find($id);
        if(!$kv)
        {
            Log::info("kvnotfound:".$id);
            echo "Not Found: ".$id."<br>";
            return;
        }
        Excel::create($kv->id.'_'.$kv->name, function ($excel) use ($kv) {
            $excel->setTitle('Attendance Sheet');
            $excel->setCreator('Technothlon')
                ->setCompany('Technothlon');
            $excel->setDescription('Attendance Sheet for '.$kv->name);
 
            $excel->sheet('Offline', function ($sheet) use ($kv) {
                $sheet->appendRow(array('Name 1', 'Name 2', 'Squad', 'Roll', 'Password'));
                $users = array();
                foreach (User2016::where('school_id', $kv->id)->whereMode(2)->orderBy('squad')->get() as $user) {
                    $users[] = array($user->name1, $user->name2, $user->squad, $user->roll, Crypt::decrypt($user->password_enc));
                }
                $sheet->rows($users);
            });
        })->store('xlsx',storage_path('files/kvattendance'));
    }
}    



