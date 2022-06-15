<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



/**
 * @author Tanzilal Mustaqim
 * @email derekln14@gmail.com
 * @create date 2022-06-15 10:19:10
 * @modify date 2022-06-15 10:19:10
 * @desc create user controller
 */

class UserController extends Controller
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

        $deleted_address = User::where("id", Auth::user()->id)->first()->makeHidden(['address','address_delete']);
        $not_deleted_address = User::where("id", Auth::user()->id)->first()->makeHidden(['address_delete']);

        $data = $check_deleted_address == 1 ? $deleted_address : $not_deleted_address;

        return response(
            $data ,200);
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

        // check empty input, if the input is empty, it will use the old data
        $data = [
            "name" => $request->name != null ? $request->name : $user->name,
            "email" => $request->email != null ? $request->email : $user->email,
            "date_of_birth" => $request->date_of_birth != null ? $request->date_of_birth : $user->date_of_birth,
            "address" => $request->address != null ? $request->address : $user->address,
            "address_delete" => $request->address_delete != null ? $request->address_delete : $user->address_delete,
            "city" => $request->city != null ? $request->city : $user->city,
            "password" => $request->password != null ? $request->password : $user->password,
        ];

        $user->update($data);
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        return User::destroy(Auth::user()->id);
    }
}
