<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\SubRole;
use App\Models\Region;
use App\Models\City;
use App\Models\Product;
use App\Models\Reward;
use App\Models\Slider;
use App\Models\Area;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;
use Auth;
use Session;
use App\Models\Wallet;
use App\Models\WalletCoinsHistory;
use App\Models\ProductCode;
use App\Models\CoinRequest;
use App\Models\BankDetails;

use App\Models\totalWalletAmmount;

class ApiController extends Controller
{
    public function register(Request $request)
    {
       
     
       
        $email_verify= User::where('email',$request->email)->first();
        if($email_verify){
            return response()->json(['success'=> false, 'message'=> 'Email is already exits plz sign up with different email!']);
        }
        if($request->role_id==1 && $request->sub_role_id==1 ){
            $request->validate([
            'name'=> 'required',
            'password'=> 'required|string|confirmed',
            'email'=> 'required|unique:users',
            'contact'=> 'required',
            'address'=> 'required',
            'device_type'=> 'required',
            'device_token'=> 'required',
            
            'shop_name'=> 'required',
            'role_id'=> 'required',
            'sub_role_id'=> 'required'
            ]);
        }else{
            $request->validate([
            'name'=> 'required',
            'password'=> 'required|string|confirmed',
            'email'=> 'required|unique:users',
            'shop_name'=> 'required',
            'contact'=> 'required',
            'address'=> 'required',
            'area'=> 'required',
            'city'=> 'required',
            'region'=> 'required',
            'device_type'=> 'required',
            'device_token'=> 'required',
           
            'role_id'=> 'required',
            'sub_role_id'=> 'required'
            ]);
            
        }
        
      
        $otp = mt_rand(1000, 9999);
        if($request->profile_image){  
        $image_64 = $request->profile_image; //your base64 encoded data
        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1]; // .jpg .png .pdf
        $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
        $image = str_replace($replace, '', $image_64);
        $image = str_replace(' ', '+', $image);
        $imageName = Str::random(10) . '.' . $extension;
        Storage::disk('public')->put('/images/profiles/' . $imageName, base64_decode($image));
        }
    
        
        
        if($request->role_id==1 && $request->sub_role_id==1 ){
                        $user = new User();
                        $user->email = $request->email;
                        $user->name = $request->name;
                        $user->shop_name = $request->shop_name;
                        $user->contact = $request->contact;
                        $user->address = $request->address;
                        $user->device_type = $request->device_type;
                        $user->device_token = $request->device_token;
                        $user->role_id = $request->role_id;
                        $user->sub_role_id = $request->sub_role_id;
                        if($request->profile_image){
                        $user->profile_image = $imageName;
                        }
                        $user->otp_code = $otp;
                        $user->password = Hash::make($request->password);
                        if($user->save())
                        {
                            
                            
                        $wallet= new Wallet;
                        $wallet->user_id=$user->id;
                        $wallet->amount=300;
                        $wallet->save();
                        
                        
                        
                          return response()->json(['success'=> true, 'message'=> 'User has been created successfully', 'user'=>$user]);
                           
                        }else
                        {
                            return response()->json(['success'=> false, 'message'=> 'Unable to create user']);
                        }
        }else{

                        $user = new User();
                        $user->email = $request->email;
                        $user->name = $request->name;
                        $user->shop_name = $request->shop_name;
                        $user->contact = $request->contact;
                        $user->address = $request->address;
                        $user->area = $request->area;
                        $user->city = $request->city;
                        $user->region = $request->region;
                        $user->device_type = $request->device_type;
                        $user->device_token = $request->device_token;
                        $user->role_id = $request->role_id;
                        $user->sub_role_id = $request->sub_role_id;
                         if($request->profile_image){
                        $user->profile_image = $imageName;
                        }
                        $user->otp_code = $otp;
                        $user->password = Hash::make($request->password);
                        if($user->save())
                        {
                            $wallet= new Wallet;
                            $wallet->user_id=$user->id;
                            $wallet->amount=300;
                            $wallet->save();
                      
                          return response()->json(['success'=> true, 'message'=> 'User has been created successfully', 'user'=>$user]);
                           
                        }else
                        {
                            return response()->json(['success'=> false, 'message'=> 'Unable to create user']);
                        }
        }
            
    }
    // public function register(Request $request)
    // {
       
    //         $request->validate([
    //         'name'=> 'required',
    //         'password'=> 'required|string|confirmed',
    //         'email'=> 'required|unique:users',
    //         'shop_name'=> 'required',
    //         'contact'=> 'required',
    //         'address'=> 'required',
    //         'area'=> 'required',
    //         'city'=> 'required',
    //         'region'=> 'required',
    //         'device_type'=> 'required',
    //         'device_token'=> 'required',
    //         'profile_image'=> 'required',
    //         'role_id'=> 'required',
    //         'sub_role_id'=> 'required'
    //         ]);
            
        
        
      
    //     $otp = mt_rand(1000, 9999);
    //     if($request->profile_image){
    //     $image_64 = $request->profile_image; //your base64 encoded data
    //     $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1]; // .jpg .png .pdf
    //     $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
    //     $image = str_replace($replace, '', $image_64);
    //     $image = str_replace(' ', '+', $image);
    //     $imageName = Str::random(10) . '.' . $extension;
    //     Storage::disk('public')->put('/images/profiles/' . $imageName, base64_decode($image));
    //     }

    //     $user = new User();
    //     $user->email = $request->email;
    //     $user->name = $request->name;
    //     $user->shop_name = $request->shop_name;
    //     $user->contact = $request->contact;
    //     $user->address = $request->address;
    //     $user->area = $request->area;
    //     $user->city = $request->city;
    //     $user->region = $request->region;
    //     $user->device_type = $request->device_type;
    //     $user->device_token = $request->device_token;
    //     $user->role_id = $request->role_id;
    //     $user->sub_role_id = $request->sub_role_id;
    //     $user->profile_image = $imageName;
    //     $user->otp_code = $otp;
    //     $user->password = Hash::make($request->password);
    //     if($user->save())
    //     {
    //       return response()->json(['success'=> true, 'message'=> 'User has been created successfully', 'user'=>$user]);
           
    //     }else
    //     {
    //         return response()->json(['success'=> false, 'message'=> 'Unable to create user']);
    //     }
    //     }
            
    
    
    public function verify_email(Request $request)
    {
        $request->validate([
            'otp_code'=> 'required'
            ]);
            $user = User::where('otp_code', $request->otp_code)->first();
            if(!$user){
               return response()->json(['success' => false, 'message' => 'Otp not matched']);
            }
            $user->is_verified=1;
            $data_save= $user->save();
            if($data_save==1)
            {
                return response()->json(['success'=> true, 'message'=> 'user has been verify successfully','user'=>$user]);
            }else
            {
              return response()->json(['success'=> false, 'message'=> 'Unable to verify user']);   
            }
    }
    
public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_type' => 'required',
        'device_token' => 'required'
    ]);

    $user = User::where('email', $request->email)->where('user_delete',0)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['success' => false, 'message' => 'Invalid email or password'], 401);
    } else {
            if($user->activation==0){
                return response()->json(['success' => false, 'message' => 'You are not allowed to login by admin'], 401);
            }else{
            $user->update(['device_type' => $request->device_type, 'device_token' => $request->device_token]);
            $userDetail = User::where('email', $request->email)->first();
            return response()->json(['success' => true, 'message' => 'Successfully Logged In!', 'user' => $userDetail]);
            }
            // If the user is verified, continue with the login process
    }
}

    

        public function get_bank_data()
        {
           $bank_data=DB::table('banks')->orderBy('name', 'asc')->where('status',1)->get();
           if($bank_data)
           {
               return response()->json(['success'=> true, 'bank list'=> $bank_data]);
           }else
           {
               return response()->json(['success'=> false]);
           }
        }
        public function region()
        {
        //   $region = Region::all();
           $region = Region::orderBy('region_name', 'asc')->get();

           if($region)
           {
               return response()->json(['success'=> true, 'region'=> $region]);
           }else
           {
               return response()->json(['success'=> false]);
           }
        }
        
        public function cities($region_id)
        {
          $city = City::where('region_id', $region_id)->orderBy('city_name', 'asc')->get();
          if($city)
           {
               return response()->json(['success'=> true, 'city'=> $city]);
           }else
           {
               return response()->json(['success'=> false]);
           }
        }
        
        public function area($city_id)
        {
              $area = Area::where('city_id', $city_id)->orderBy('area_name', 'asc')->get();
              if($area)
               {
                   return response()->json(['success'=> true, 'area'=> $area]);
               }else
               {
                   return response()->json(['success'=> false]);
               }
        }
        
        public function roles()
        {
            $role = Role::all();
            if($role)
            {
                return response()->json(['success'=> true, 'role'=> $role]);
            }else
            {
                return response()->json(['success'=> false]);
            }
        }
        
        public function sub_roles($role_id)
        {
            $sub_role = SubRole::where('role_id', $role_id)->get();
            if($sub_role)
            {
                return response()->json(['success'=> true, 'sub_role'=> $sub_role]);
            }else
            {
                
                return response()->json(['success'=> false]);
            }
        }
        
        
        public function Hash_making(){
            dd(Hash::make('12345678'));
        }
        public function password_change(Request $request,$id){
          $user=User::find($id);
          if(!$user){
            return response()->json(['success'=> false, 'message'=> 'Please Write Correct credentials']);  
          }

          $validation=$request->validate([
                'current_password' => 'required',
                'new_password' => 'required',
                'confirm_password' => 'required|same:new_password',
            ]);
        if (!$validation) {
            // return response()->json(['failure' => 'New Password or confirmed password does not match'], 422);
             return response()->json(['success'=> false, 'message'=> 'New Password or confirmed password does not match']);
        }
            
          if(!Hash::check($request->current_password, $user->password)){
                return response()->json(['success'=> false, 'message'=> 'Current Password not matched']);
                
                // return response()->json(['failure' => 'Current Password not matched']);
            }else{
                $user->password=Hash::make($request->new_password);
                $user->save();
                return response()->json(['success'=> true, 'message'=> 'Password Changed Successfully']);

            }

            
        }
        public function forget_password_send_otp(Request $request){
           
            $validation=$request->validate([
                'email' => 'required|email',
            ]);
            if (!$validation) {
            return response()->json(['success'=> false, 'message'=> 'Please Write Correct credentials']);
            }
            $user=User::where('email',$request->email)->first();
            if(!$user){
            return response()->json(['success'=> false, 'message'=> 'Please Write Correct credentials']);
            }
            $otp = mt_rand(1000, 9999);
            $user->otp_code=$otp;
            $user->forget_activation=0;
            $user->is_verified=0;
            $user->save();
            $details = ['Otp' => $otp];
            Mail::send('Otp', $details, function($message) use ($request) {
                $message->to($request->email)->subject('Welcome to  Future Parts');
            });
            // Mail::to($request->email)->send(new OtpEmail($otp));
            return response()->json(['success'=> true, 'message'=> 'Otp Send to your email!','otp'=>$otp]);
            
        }
        
        
        
        public function reset_password(Request $request,$id){
          $user=User::find($id);
          if(!$user){
            return response()->json(['success'=> false, 'message'=> 'User Not Found']);    
          }

          $validation=$request->validate([
                'new_password' => 'required',
                'confirm_password' => 'required|same:new_password',
            ]);
        if (!$validation) {
            return response()->json(['success'=> false, 'message'=> 'New Password or confirmed password does not match']);
   
        }
                $user->password=Hash::make($request->new_password);
                $user->save();
                return response()->json(['success'=> true, 'message'=> 'Password change Successfully!']);
                
        }
        
        
        
    public function EditProfile(Request $request,$id)
    {
            $user = User::find($id);
            $data=$request->all();
            if($user==null){
            return response()->json(['success'=> false, 'message'=> 'Please Login first then update your profile!']);        
            // return response()->json(['failure' => 'Please Login first then update your profile'], 422);  
            }
            if($request->profile_image){
            $image_64 = $request->profile_image; //your base64 encoded data
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1]; // .jpg .png .pdf
            $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);
            $imageName = Str::random(10) . '.' . $extension;
            Storage::disk('public')->put('/images/profiles/' . $imageName, base64_decode($image));
            $data['profile_image']=$imageName;
            $user->profile_image = $imageName;                
            }
            $save_data= $user->fill($data)->save();
            if($save_data)
            {
               return response()->json(['success'=> true, 'message'=> 'Your Profile Update Successfully!', 'user'=>$user]);
            }else
            {
                return response()->json(['success'=> false, 'message'=> 'Unable to create user']);
            }
    }
        
         public function logout(Request $request)
        {
            Session::flush();
            Auth::logout();
            return response()->json(['success'=> true, 'message'=> 'Successfully logged out']);
            
        }
        
        
       public function product_detailV2(Request $request)
        {
            $product_code=ProductCode::where('id',$request->id)->first();

            if ($product_code === null) {
               return response()->json(['success'=> false, 'message'=> 'Sorry product not found with the current QRcode'],400); 
            }
            $product=Product::where('id',$product_code->product_id)->first();
            $user = User::where('id', $request->userId)->first();
            if(intval($product->category)!==$user->sub_role_id){
                  return response()->json(['success'=> false, 'message'=> 'You are not allowed to scan that product!'],400); 
                
            }
            
            
            $count_allow= DB::table('reward_count_option')->where('id', 1)->first();
            $user->count_scanning += 1;
            if($user->count_scanning % intval($count_allow->count)==0){
                $user->count_prize += 1;
            }
            $user->save();
            // return ($product_code->scanned==='Yes');
            if(isset($product_code->scanned) && $product_code->scanned==='Yes' && $product_code->scanned!=='No'){
                if($product_code->user_id!=null){
                    $TempVar = $product_code->user_id;
                    
                // $users = User::join('cities', 'users.city', '=', 'cities.id')
                // ->join('areas', 'users.area', '=', 'areas.id')
                // ->join('regions', 'users.region', '=', 'regions.id')
                // ->select('users.*', 'cities..city_name,c.city_name as city_name', 'areas.area_name as area_name', 'regions.region_name as region_name')
                // ->get();
                $user = DB::Select("select a.*,b.city_name,c.area_name,d.region_name from users a left join cities b on a.city = b.id left join area c on a.area = c.id left join regions d on a.region = d.id where a.id ='$TempVar'");
                // return response()->json(['id'=>$user]);
                    
                }else{
                    $user=null;
                }
               return response()->json(['success'=> false, 'message'=> 'Product already Scanned','scanned'=>'Yes','product'=>$product,'user'=>$user],200);  
            }
            $product= Product::find($product_code->product_id); 
            // $product_code->scanned='Yes';
            // $product_code->save();
            if($product){
            return response()->json(['message' => 'Product Scan Successfully!','scanned'=>'No','product'=> $product], 200);
            }
            else{
             return response()->json(['success'=> false, 'message'=> 'Product Not Found']);
            }
        }
        
        
        public function product_detail(Request $request)
        {
            $product_code=ProductCode::where('id',$request->id)->first();

            if ($product_code === null) {
               return response()->json(['success'=> false, 'message'=> 'Sorry product not found with the current QRcode'],400); 
            }
            $product=Product::where('id',$product_code->product_id)->first();
            $user = User::where('id', $request->userId)->first();
            if(intval($product->category)!==$user->sub_role_id){
                  return response()->json(['success'=> false, 'message'=> 'You are not allowed to scan that product!'],400); 
                
            }
            
            
            $count_allow= DB::table('reward_count_option')->where('id', 1)->first();
            $user->count_scanning += 1;
            if($user->count_scanning % intval($count_allow->count)==0){
                $user->count_prize += 1;
            }
            $user->save();
            // return ($product_code->scanned==='Yes');
            if(isset($product_code->scanned) && $product_code->scanned==='Yes' && $product_code->scanned!=='No'){
                if($product_code->user_id!=null){
                 $TempVar = $product_code->user_id;
                $user = DB::Select("select a.*,b.city_name,c.area_name,d.region_name from users a left join cities b on a.city = b.id left join area c on a.area = c.id left join regions d on a.region = d.id where a.id ='$TempVar'");

                }else{
                    $user=null;
                }
               return response()->json(['success'=> false, 'message'=> 'Product already Scanned','scanned'=>'Yes','product'=>$product,'user'=>$user],200);  
            }
            $product= Product::find($product_code->product_id); 
            // $product_code->scanned='Yes';
            // $product_code->save();
            if($product){
            return response()->json(['message' => 'Product Scan Successfully!','scanned'=>'No','product'=> $product], 200);
            }
            else{
             return response()->json(['success'=> false, 'message'=> 'Product Not Found']);
            }
        }
        
        
          public function spinReward(Request $request)
        {
            $user = User::where('id', $request->userId)->first();
            $count = DB::table('reward_count_option')->where('id', 1)->value('count');
            $count=intval($count);
            
            if($user->count_prize>0 && $user->count_scanning>0 ){
               $user->count_scanning -= 10;
            if($user->count_scanning % $count==0){
               $user->count_prize -= 1;
            }
               $user->save();
               
               $reward=new Reward;
               $reward->reward_data= $request->reward_data;
               $reward->userId= $request->userId;
               
               $words = explode(" ", $request->reward_data);
               if($words[1]=='Points'){
               $Wallet=new Wallet;
               $last_wallet = Wallet::where('user_id', $request->userId)->latest()->first();
               $Wallet->amount=intval($words[0])+$last_wallet->amount;
               $Wallet->user_id=$request->userId;
               $save_coins_request_with_update_wallet=$Wallet->save();                   
               }
            if($reward->save()){
               return response()->json(['message' => 'Congratulation you win that reward successfully!'], 200);
            }
            else{
             return response()->json(['success'=> false, 'message'=> 'Some thing went wrong']);
            }
            }else{
             return response()->json(['success'=> false, 'message'=> 'You are not allowed to spin for winning the prize!']);   
            }
            
        }
        
        
        public function insertWalltet(Request $request)
        {
            $validation=$request->validate([
                'user_id' => 'required',
                'amount' => 'required',
                'product_id' => 'required',
            ]);
            
            if($request->product_code_id){
                
                
                
             $product_code=ProductCode::where('id',$request->product_code_id)->first(); 
             

            if($product_code->scanned=='Yes'){
                
               return response()->json(['success'=> false, 'message'=> 'This qrcode already scanned by somebody!']);  
            }
            $product_code->scanned='Yes';
            $product_code->user_id=$request->user_id;
            $product_code->save();
            }
            if (!$validation) {
            return response()->json(['success'=> false, 'message'=> 'All fields required']);
            }
            $data=$request->all();
            if($request->product_id){
              $product=Product::where('id',$request->product_id)->select('price')->first();
              $data['product_price']= $product->price;
            }
            

            $old_wallet=Wallet::where('user_id',$request->user_id)->latest()->first();
            $wallet= new Wallet;
            if($old_wallet){
            $updated_price=$old_wallet->amount + $request->amount;
            $data['amount']=$updated_price;
            }
            $save_wallet= $wallet->create($data)->save();
            
            $walletHistory= new WalletCoinsHistory;
            $walletHistory->user_id=$request->user_id;
            $walletHistory->status='insertwallet';
            $walletHistory->amount=$request->amount;
            $walletHistory->product_id=$request->product_id;
            $walletHistory->save();
            if(!$save_wallet){
            return response()->json(['success'=> false, 'message'=> 'Something went wrong data not save']);
            }
            return response()->json(['success'=> true, 'message'=> 'Data save into wallet successfully!']);
        }
        
            
        
        public function deleteWallet(Request $request,$id)
        {
            $wallet= Wallet::find($id);
            if(count($wallet)<=0){
            return response()->json(['success'=> false, 'message'=> 'Something went wrong data not found']);    
            }
            $wallet->delete();
            return response()->json(['success'=> true, 'message'=> 'Delete wallet data  successfully!']);
        }
        public function Wallethistory(Request $request,$user_id)
        {
            
            // $wallet = Wallet::where('user_id', $user_id)->oldest()->get();
            $wallet = Wallet::where('user_id', $user_id)->latest()->get();
            
            if(count($wallet)<=0){
            return response()->json(['success'=> false, 'message'=> 'You must login first then futhure proceed!',]);    
            }
            $result = [];
            foreach($wallet as $data){
             $request_amount_data=CoinRequest::where('w_id',$data->id)->first();
            
            if($request_amount_data){
             $transaction_details=DB::table('transaction_details')->where('coin_request_id',$request_amount_data->id)->first();
            }else{
             $transaction_details=null;   
            }
             
             $request_amount = $request_amount_data ? $request_amount_data->coins : null;
             $product_details=Product::where('id',$data->product_id)->first();
             $result[]=['wallet'=>$data,'product_details'=>$product_details,'request_amount'=>$request_amount,'request_amount_data'=>$request_amount_data,'transaction_details'=>$transaction_details];
            }
         
            $total_coins = Wallet::where('user_id',$user_id)->latest()->first();
            $total_coins=$total_coins->amount;
            $user=User::where('id',$user_id)->first();
            return response()->json(['success'=> true, 'message'=> 'Wallet history get successfully!','wallet'=>$result,'total coins'=>$total_coins,'user'=>$user]);
        }
        
        public function coinRequest(Request $request,$user_id)
        {
           
  $validation=$request->validate([
                'coins' => 'required',
                'account_no' => 'required',
                'account_title' => 'required',
            ]);
            
            if (!$validation) {
            return response()->json(['success'=> false, 'message'=> 'All fields required']);
            }
            $data=$request->all();
            $wallet = Wallet::where('user_id', $user_id)->latest()->first();
            if(!$wallet){
            return response()->json(['success'=> false, 'message'=> 'You have no amount in your wallet!']);    
            }
            $wallet_id=$wallet->id;
            $data['user_id']=$user_id;
            $coins_request= new CoinRequest;
            $data['w_id']=$wallet_id;
             $data['account_no']=$request->account_no;
            $data['account_title']=$request->account_title;
            $save_coins_request= $coins_request->create($data)->save();   
            $latestCoinRequest = CoinRequest::latest()->first();            
            if(intval($wallet->amount) < intval($latestCoinRequest->coins)){
             return response()->json(['status' => 'error', 'message' => 'This user have not enough amount to withdraw the request amount!']);
            }else{
            $update_amount=intval($wallet->amount)-intval($latestCoinRequest->coins);
            $Wallet=new Wallet;
            $Wallet->amount=$update_amount;
            $Wallet->user_id=$user_id;
            $save_coins_request_with_update_wallet=$Wallet->save();
         }
            
            if(!$save_coins_request_with_update_wallet){
            return response()->json(['success'=> false, 'message'=> 'Something went wrong data not save']);
            }
            return response()->json(['success'=> true, 'message'=> 'You request to withdraw the amount successfully!']);
         }
        public function coinHistory(Request $request,$user_id)
        {    
            $coin_history= CoinRequest::where('user_id',$user_id)->oldest()->get();  
            return response()->json(['success'=> true, 'message'=> 'Coin history get Successfully!','Coin history'=>$coin_history]);
               
        }
        public function totalCoins(Request $request,$user_id)
        {    
            $coins= Wallet::where('user_id',$user_id)->get();
            if(count($coins)<=0){
            return response()->json(['success'=> false, 'message'=> 'No Coin found']);    
            }
            
            $withdraw_amount= CoinRequest::where('user_id',$user_id)->where('approaved',1)->get();
            $withdraw_amount= $withdraw_amount->sum('coins');
            $total_coins = Wallet::where('user_id',$user_id)->latest()->first();
            $total_coins=$total_coins->amount;
            return response()->json(['success'=> true, 'message'=> 'Total Coins:','Total Coins'=>$total_coins]);
               
        }
        public function withdrawAmount(Request $request,$user_id)
        {    
            $coins= CoinRequest::where('user_id',$user_id)->where('approaved',1)->get();
            if(count($coins)<=0){
            return response()->json(['success'=> false, 'message'=> 'No withdraw amount found']);       
            }
            $total_coins = $coins->sum('coins');
            return response()->json(['success'=> true, 'message'=> 'Total Withdraw Amount:','Total Withdraw Amount'=>$total_coins]);
               
        }
        public function walletData(Request $request,$user_id)
        {    
            $wallet= Wallet::where('user_id',$user_id)->get();
            $wallet_amount = $wallet->sum('amount');
            $coins= CoinRequest::where('user_id',$user_id)->where('approaved',1)->get();
            $total_coins = $coins->sum('coins');
            return response()->json(['success'=> true, 'message'=> 'Total Withdraw Amount:','Total Withdraw Amount'=>$total_coins]);
               
        }
        
        public function storeBankData(Request $request)
        {    
            $data=$request->all();
            $bank_data= new BankDetails;
            $bank_data->create($data)->save();
            return response()->json(['success'=> true, 'message'=> 'You bank details store successfully!']);  
        }
        public function bankData(Request $request,$id)
        {
            $bank_data= BankDetails::where('user_id',$id)->get();
            if(!$bank_data){
            return response()->json(['success'=> false, 'message'=> 'No Bank Details Found!']);    
            }
            return response()->json(['success'=> true, 'message'=> 'You bank details!','bank_data'=>$bank_data]);  
        }
        
        public function bankDelete(Request $request,$id)
        {
            $bank_data= BankDetails::find($id)->delete();
            if(!$bank_data){
            return response()->json(['success'=> false, 'message'=> 'No Bank Details Found!']);    
            }
            return response()->json(['success'=> true, 'message'=> 'Delete Data Successfully!']);  
        }
        
        
          public function updateBankData(Request $request,$user_id,$bank_id)
        {    
            $data=$request->all();
            $bank_data= BankDetails::where('user_id',$user_id)->where('id',$bank_id)->first();
            if(!$bank_data){
            return response()->json(['success'=> false, 'message'=> 'No Bank Details Found!']);    
            }
            $updateBankData=$bank_data->update($data);
            if($updateBankData){
            return response()->json(['success'=> true, 'message'=> 'Update Bank Details Successfully!']);
            }
        }
          public function Slider(Request $request)
        {    
            $data=Slider::all();
            if(count($data)<=0){
            return response()->json(['success'=> false, 'message'=> 'No slide image available!']);    
            }else{    
            return response()->json(['success'=> true, 'images'=> $data]);    
            }
        }
          public function userData(Request $request,$id)
        {    
            
            $user=DB::table('users')->where('id',$id)->first();
            return response()->json(['success'=> true, 'response'=> $user]);    
            
        }
        
        
        public function showPrivacyPolicy()
    {
        $privacyPolicy = 
        "Future Parts Company Privacy Policy
        Welcome to Future Parts Company! We appreciate your trust in us and are committed to protecting
        your privacy. This Privacy Policy outlines how we collect, use, disclose, and protect your personal
        information. By using the Future Parts Company mobile app, you agree to the terms and conditions of
        this Privacy Policy.

        1. Information We Collect
        1.1 Personal Information:
        To provide you with our services, we collect personal information such as your name, contact details,
        address, and other relevant information required for order fulfillment.

        1.2 Payment Information:
        When you claim your rewarded point through our app, we collect payment information such as Bank
        account, Jazz Cash, Easy Paisa and UPaisa details. Please note that we do not store this information; it is
        securely processed through our payment gateway.

        1.3 Device Information:
        We collect information about the device you use to access our app, including the device model,
        operating system, and unique device identifiers.

        2. How We Use Your Information
        2.1 Reward Claim:
        We use your personal information to process and fulfill your claim for rewarded point.

        2.2 Improving Our Services:
        We analyze usage data to understand how our app is used and identify areas for improvement. This
        helps us enhance user experience and optimize our services.

        2.3 Marketing and Communications:
        With your consent, we may send you promotional emails and notifications about special offers, new
        products, and other updates. You can opt out of these communications at any time.

        3. Information Sharing
        3.1 Legal Compliance:
        We may disclose your information when required by law or to protect our rights, property, and safety,
        or that of our users.

        4. Security
        4.1 Data Security:
        We implement security measures to protect your personal information from unauthorized access,
        disclosure, alteration, and destruction.

        5. Your Choices and Rights
        5.1 Access and Correction:
        You have the right to access and correct your personal information.
        Contact us at futurepartscompany@gmail.com to request access or make corrections.

        6. Changes to the Privacy Policy
        6.1 Updates:
        We may update this Privacy Policy to reflect changes in our practices. We will notify you of any
        significant changes through the app or other means.

        7. Contact Us
        7.1 Questions:
        If you have any questions or concerns about this Privacy Policy or our data practices, please contact us
        at futurepartscompany@gmail.com.

        Thank you for choosing Future Parts Company!
        Administrator,
        Future Parts Company
        EOT";

        return response()->json(['privacy_policy' => $privacyPolicy]);
    }
        
        
        
         
}