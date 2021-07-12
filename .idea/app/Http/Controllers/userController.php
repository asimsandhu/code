<?php

namespace App\Http\Controllers;

use App\Models\LoginDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class userController extends Controller
{

    public function login_user(Request $request)
    {
       // dd($request->input());
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $name=$request->name;
        $password=$request->password;

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $login_dt = Carbon::now()->addHours(5);
            $user_id =  auth()->user()->id;
            $session_id = $request->session()->get('_token'); //getting session token
            Session::put('session_id',$session_id);

            $login_time = new LoginDetail();
            $login_time->session_id = $session_id;
            $login_time->user_id = auth()->user()->id;
            $login_time->login_dt = $login_dt;

            $login_time->save();

            return view('admin.dashboard');
        }


        return redirect("login")->withSuccess('Login details are not valid');
    }

    public function login_details(){
        //$detail=LoginDetail::all();
        //$user_id= LoginDetail::all()->pluck('user_id');
        $datetime =Carbon::now()->subDays(3);

        //$dated = Carbon::now()->subDays(3)->toDateString();
        //dd($dated);

        $detail=LoginDetail::select("users.name", "login_details.login_dt", "login_details.logout_dt", "login_details.total_time")
                                        ->leftJoin("users","login_details.user_id","=","users.id")
                                        ->orderBy('login_details.id','DESC')
                                        ->get();
       // dd($left_join);
       //$user= $user_id->users->pluck('name') ;




        //$user_id = $detail->id;

        //$user_name=User::find($user_id);


        return view('auth.login_detail',compact('detail'));


    }
    public function logout() {


        $user_id=auth()->user()->id;
        $session_id=Session::get('session_id');
        $logout_dt=Carbon::now()->addHours(5);


        $login_time=new LoginDetail();
        $user=LoginDetail::where('user_id','=',$user_id)->where('session_id','=',$session_id)->first();
       // $user=DB::select("select * from login_details WHERE user_id='$user_id'  and  session_id ='$session_id' ");

       $in=Carbon::parse($user->login_dt)->toTimeString();
       $out=(Carbon::parse(Carbon::now()->addHours(5)))->toTimeString();
       $in1=Carbon::createFromFormat('H:i:s',$in);
        $out1=Carbon::createFromFormat('H:i:s',$out);
       $total_time=$in1->diffInSeconds($out1);

        if($user)
        {
            $user->logout_dt=$logout_dt;
            $user->total_time=Carbon::parse($total_time)->toTimeString();
            $user->save();
            //dd($logout_dt);
        }

        Session::flush();
        Auth::logout();
//      dd(Carbon::parse($total_time)->toTimeString());
        return Redirect('login');
    }


    public function create_agent(Request $request)
    {
        $request->all();

        $validatedData = $request->validate([

            'name' => 'required|min:4',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:3'

        ]);

        $data = $request->all();
        $password = $request->password;
        $data['password'] = bcrypt($password);
        $User = User::create($data);
        $u=User::findOrFail(6);
        $r=Role::findById(3);
        $u->assignRole($r);

        /*$log = new Log();
        $log->table_name = 'User';
        $log->table_column_id = $User->id;
        $log->user_id = auth()->user()->id;
        $log->type = 'created';
        $log->save();*/

       // return view('supervisor.panel')->with('message', 'User has been created successfully!');
        return redirect()->back()->with('message', 'User has been created successfully!');

    }

    public  function show_agent_crud()
    {

        $roles=Role::all();
        $user=User::all();
       // $u->hasAnyRole('writer', 'reader');

        return view('supervisor.panel',compact('user','roles'));

    }
    public function assign_role(Request $request)
    {

                 $request->all();
                $role=Role::findById($request->role);
                $user=User::findOrFail($request->user_id);
                $user->assignRole($role);
               //  dd($request->all());

        return redirect()->back()->with('message', 'role has been assigned  successfully!');


    }
    //
    public function show_login_form()
    {
        return view('auth.login');

    }

    public function show_dashboard()
    {
        return view('admin.dashboard');
    }
    //

   /* public function login(Request $request){

        $validatedData = $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);


        $credentials = $request->only('name', 'password');
        if (Auth::attempt($credentials)) {

            $login_dt = Carbon::now()->toDateTimeString();
            $user_id =  auth()->user()->id;
            $session_id = $request->session()->get('_token'); //getting session token
            Session::put('session_id',$session_id);

            $login_time = new LoginDetail();
            $login_time->session_id = $session_id;
            $login_time->user_id = auth()->user()->id;
            $login_time->login_dt = $login_dt;

            $login_time->save();

          //  Log::info('User Logged in'. $login_time);
            // $loginUserDetails = new Login

           // return view('/dashboard');

        }
        return redirect()->back()->with('message', 'Incorrect user name or password');

    }*/


}
