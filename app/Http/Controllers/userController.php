<?php

namespace App\Http\Controllers;

use App\Models\LoginDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
            return view('admin.dashboard');
        }

        return redirect("login")->withSuccess('Login details are not valid');
    }

    public function logout() {
        Session::flush();
        Auth::logout();

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
