<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($credentials)) {
            $success = true;
            $message = "User login successfully";
        } else {
            $success = false;
            $message = "Unautorised";
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);
    }


    public function register(Request $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $success = true;
            $message = "User register successfully";

        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);

    }


    public function logout()
    {
        try {
            Session::flush();
            $success = true;
            $message = "Logout successfully";
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);
    }

    //Admin

    public function get_all_admins(){
        $admins=User::where('role', 1)->get();
        return response()->json([
            'admins'=>$admins
        ],200);
    }

    public function createAdmin(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users'),
            ],
            'password' => 'required|string|min:8',
        ];

        $messages = [
            'required' => 'Ce champ est requis.',
            'string' => 'Ce champ doit être une chaîne de caractères.',
            'max' => 'Ce champ ne doit pas dépasser :max caractères.',
            'email' => 'L\'adresse email n\'est pas valide.',
            'unique' => 'Cet email est déjà utilisé.',
            'min' => 'Le mot de passe doit avoir au moins :min caractères.',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role=1;
            $user->save();

            $success = true;
            $message = "Admin register successfully";

        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);

    }


    public function updateAdmin(Request $request, $id)
{
    $rules = [
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'email',
            'max:255',
            Rule::unique('users')->ignore($id), // Exclude the current user's email from unique validation
        ],
    ];

    $messages = [
        'required' => 'Ce champ est requis.',
        'string' => 'Ce champ doit être une chaîne de caractères.',
        'max' => 'Ce champ ne doit pas dépasser :max caractères.',
        'email' => 'L\'adresse email n\'est pas valide.',
        'unique' => 'Cet email est déjà utilisé.',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    try {
        $user = User::where('id', $id)->where('role', 1)->first(); // Use 'first' to retrieve the user instance
        if (!$user) {
            return response()->json(['message' => 'Admin not found'], 404);
        }

        $user->name = $request->name;
        if ($user->email !== $request->email) {
            // Only update the email if it has changed
            $user->email = $request->email;
        }

        $user->update();

        $success = true;
        $message = "Admin updated successfully";

    } catch (\Illuminate\Database\QueryException $ex) {
        $success = false;
        $message = $ex->getMessage();
    }

    $response = [
        'success' => $success,
        'message' => $message
    ];

    return response()->json($response);
}

public function disableAdmin($id)
    {
        $admin = User::find($id);
        $admin->disabled=true;
        $admin->save();
        return response()->json(['success'=> 'admin disabled successfully']);

    }

}
