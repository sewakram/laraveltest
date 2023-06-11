<?php

namespace App\Http\Controllers;

use App\usermodel;
use App\address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Redirect,Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usersdetails=array();
        $datas=DB::table('user')
        // ->join('address', 'user.id', '=', 'address.user_id','left')
        ->get();
        foreach ($datas as $key => $value) {
            $address=DB::table('address')
            ->where('user_id',$value->id)
            ->get();

                array_push($usersdetails,(object)array_merge((array)$datas[$key],array('address'=>json_encode($address))));


        }
        // dd($usersdetails);
        return view('users.index', ['datas' => $usersdetails]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->address);

        $r=$request->validate([
            'name' => 'required',
            'email' => 'required',
            'mobile_number' => 'required',
            'gender' => 'required',
            'age' => 'required',
            'dob' => 'required',
            ]);
            $custId = $request->cust_id;
            usermodel::updateOrCreate(['id' => $custId],['name' => $request->name, 'email' => $request->email,'mobile_number'=>$request->mobile_number,'gender'=>$request->gender,'age'=>$request->age,'dob'=>$request->dob]);
            // dd($request->address);
            $user_id=DB::getPdo()->lastInsertId();
            if(!empty($request->address)){


                foreach ($request->address as $key => $value) {
                    address::updateOrCreate(['id' => $request->address_id[$key]],['address' => $request->address[$key], 'city' => $request->city[$key],'state'=>$request->state[$key],'pincode'=>$request->pincode[$key],'user_id'=>($custId)?$custId:$user_id]);
                }
            }

            if(empty($request->cust_id))
                $msg = 'User entry created successfully.';
            else
                $msg = 'User data is updated successfully';
            return redirect()->route('user.index')->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\usermodel  $usermodel
     * @return \Illuminate\Http\Response
     */
    public function show(usermodel $usermodel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\usermodel  $usermodel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // echo $id;die();
        // $where = array('id' => $id);
		// $customer = usermodel::where($where)->first();
        $usersdetails=array();
        $datas=DB::table('user')->where('id',$id)->first();

        // foreach ($datas as $key => $value) {
            $address=DB::table('address')
            ->where('user_id',$datas->id)
            ->get();

                array_push($usersdetails,(object)array_merge((array)$datas,array('address'=>json_encode($address))));

                // dd($usersdetails);
        // }
		return Response::json($usersdetails);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\usermodel  $usermodel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, usermodel $usermodel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\usermodel  $usermodel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $cust = usermodel::where('id',$id)->delete();
        foreach ($request->address_ids as $key => $value) {
            $cust = address::where('id',$value)->delete();
        }
		return Response::json($cust);
    }
}
