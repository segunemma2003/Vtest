<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Models\User; 
use Illuminate\Support\Facades\Auth; 

use Validator;

class UserController extends Controller
{
    public $successStatus = 200;



    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['success' =>true,'data'=> $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }
    //

    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email|unique:users', 
            'password' => 'required',
            'image'=>'nullable',
            'refered_by'=>'nullable',
            'c_password' => 'required|same:password', 
        ]);
if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
    $name='';
if($request->hasFile('image')){
       if($request->get('image'))
       {
          $image = $request->get('image');
          $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
          \Image::make($request->get('image'))->save(public_path('images/').$name);
        }

       $image= new FileUpload();
       $image->image_name = $name;
       $image->save();
}
$lastUser=User::all()->last();
$count=1;
if($lastUser != null){
    $count=$lastUser->id + 1;
}
        $input = $request->all();
        $r_id=null;
        if(isset($input['refered_by'])){
            $userData =User::where('referal_id','=',$input['refered_by'])->first();
            if($userData != null){
               $r_id=$userData->id;
                $userData->balance=$userData->balance+1000;
                $userData->save();
            }else{
                return response([
                    "status"=>false,
                    "message"=>"wrong referer id"
                ],402);
            }
        }
        $input['refered_by']=$r_id;
        $input['referal_id']=\Hashids::encode($count+strtotime(now()));
        $input['account_number']=\Hashids::connection('alternative')->encode($count+strtotime(now()));
        $input['image']=$name;
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        $success['name'] =  $user->name;
        return response()->json(['success'=>true,'data'=>$success], $this-> successStatus); 
    }

    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success'=>true,'data' => $user], $this-> successStatus); 
    } 
}
