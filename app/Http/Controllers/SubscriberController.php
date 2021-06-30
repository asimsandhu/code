<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SubscriberController extends Controller
{
    //

    public function show_subscriber_crud()
    {
    //dd (   Carbon::today()->now()->addHour(5));

         // $role=Role::findById(4);
        //$perm=Permission::findById(1);
       // $role->givePermissionTo($perm);

       $sub= Subscriber::all();
        return view('subscriber.subscriber',['sub'=>$sub]);

    }

    public function create_subscriber(Request $request)
    {

        $request->all();

        //   dd($request->all());
//        $validatedData = $request->validate([
//
//            'cellno' => 'required|min:4',
//
//        ]);
        $data = $request->all();
        $data['first_call_dt'] = Carbon::today()->now()->addHour(5);
        // $data= new Subscriber;
        $sub = Subscriber::create($data);
        return redirect()->back()->with('message', 'User has been created successfully!');

    }
}
