<?php

namespace App\Http\Controllers;
use Symfony\Component\HttpFoundation\Response;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index ()
    {
        $User = User::all();

        return $this->validResponse($User);

    }

    public function store(Request $request) 
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ];

        $this->validate($request, $rules);

        $fields = $request->all();
        $fields['password'] = Hash::make($request->password);

        $user = User::create($fields);

        return $this->validResponse($user,Response::HTTP_CREATED);

    }

    public function show($UserId)
    {
        $User = User::findOrFail($UserId);

        return $this->validResponse($User);
    }


    public function update(Request $request,$UserId)
    {
        $rules = [
            'name' => 'max:255',
            'email' => 'email|unique:users,email' . $UserId,
            'password' => 'min:8|confirmed',
        ];

        $this->validate($request,$rules);

        $User = User::findOrFail($UserId);

        $User->fill($request->all());


        // check if input field has password
        if($request->has('password')) {

            $User->passowrd = Hash::make($request->password);
        }

        // check if there is any change to existing database values
        if ($User->isClean()) {
            return $this->errorResponse('There is no change in any value',Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $User->save();

        return $this->validResponse($User);

    }



    public function destroy($UserId)
    {
        $User = User::findOrFail($UserId);

        $User->delete();

        return $this->validResponse($User);
    }


    public function me (Request $request) 
    {
        return $this->validResponse($request->user());
    }
    //
}
