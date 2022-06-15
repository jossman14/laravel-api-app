<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //check deleted address
        $check_deleted_address = User::find(Auth::user()->id)->address_delete;

        $deleted_address = "address is not found or deleted";
        $not_deleted_address = User::where("id", Auth::user()->id)->select("address")->first();

        $data = $check_deleted_address == 1 ? $deleted_address : $not_deleted_address;

        return response($data ,200);

        // check address from id
        return response( User::where("id", Auth::user()->id)->select('address')->first(),201);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::find(Auth::user()->id);

        if ($user->address_delete == 0) {
            return response([
                "message" => "address already exists",
                "address" => $user->address,
            ],400);
        }

        $fields = $request->validate([
            'address' => 'required',
        ]);

        // take other data from db
        $data = [
            "name" => $request->name != null ? $request->name : $user->name,
            "email" => $request->email != null ? $request->email : $user->email,
            "date_of_birth" => $request->date_of_birth != null ? $request->date_of_birth : $user->date_of_birth,
            "address" => $fields['address'],
            "address_delete" => 0,
            "city" => $request->city != null ? $request->city : $user->city,
            "password" => $request->password != null ? $request->password : $user->password,
        ];

        $user->update($data);

        return response([
            "message" => "create succesfull",
            "address" => $data['address'],
        ],201);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = User::find(Auth::user()->id);

        // take other data from db
        $data = [
            "name" => $request->name != null ? $request->name : $user->name,
            "email" => $request->email != null ? $request->email : $user->email,
            "date_of_birth" => $request->date_of_birth != null ? $request->date_of_birth : $user->date_of_birth,
            "address" => $request->address != null ? $request->address : $user->address,
            "address_delete" => 0,
            "city" => $request->city != null ? $request->city : $user->city,
            "password" => $request->password != null ? $request->password : $user->password,
        ];

        $user->update($data);

        return response([
            "message" => "update succesfull",
            "address" => $data['address'],
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $user = User::find(Auth::user()->id);

        // take other data from db
        $data = [
            "name" => $user->name,
            "email" => $user->email,
            "date_of_birth" => $user->date_of_birth,
            "address" => "",
            "address_delete" => 1,
            "city" => $user->city,
            "password" => $user->password,
        ];

        $user->update($data);
        return response([
            "message" => "delete succesfull",
        ],200);
    }
}
