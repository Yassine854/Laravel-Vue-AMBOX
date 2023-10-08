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
        $user->email = $request->email;
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


    //Expediteur

    public function get_all_expediteurs(){
        $expediteurs=User::where('role', 2)->get();
        return response()->json([
            'expediteurs'=>$expediteurs
        ],200);
    }

    public function createExpediteur(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users'),
            ],
            'entreprise' => 'required|string|max:255',
            'city'=> 'required',
            'prix_livraison'=> 'required|numeric',
            'prix_retour'=> 'required|numeric',
            'phone' => [
                'required',
                'numeric',
                'digits:8',
                Rule::unique('users')->ignore(auth()->user()->id ?? null),
            ],
            'address'=> 'required|string|max:255',
            'password' => 'required|string|min:8',
        ];

        $messages = [
            'required' => 'Ce champ est requis.',
            'string' => 'Ce champ doit être une chaîne de caractères.',
            'numeric' => 'Ce champ doit être un nombre.',
            'max' => 'Ce champ ne doit pas dépasser :max caractères.',
            'email' => 'L\'adresse email n\'est pas valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'phone.required' => 'Le numéro de téléphone est requis.',
            'phone.numeric' => 'Le numéro de téléphone doit être un nombre.',
            'phone.digits' => 'Le numéro de téléphone doit comporter 8 chiffres.',
            'phone.unique' => 'Ce numéro de téléphone est déjà utilisé.',
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
            $user->entreprise = $request->entreprise;
            $user->city=$request->city;
            $user->prix_livraison = $request->prix_livraison;
            $user->prix_retour = $request->prix_retour;
            $user->phone=$request->phone;
            $user->address=$request->address;
            $user->password = Hash::make($request->password);
            $user->role=2;
            $user->save();

            $success = true;
            $message = "Expediteur register successfully";

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


    public function updateExpediteur(Request $request, $id)
{
    $rules = [
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'email',
            'max:255',
            Rule::unique('users')->ignore($id),
        ],
        'entreprise' => 'required|string|max:255',
        'city'=> 'required',
        'prix_livraison'=> 'required|numeric',
        'prix_retour'=> 'required|numeric',
        'phone' => [
            'required',
            'numeric',
            'digits:8',
            Rule::unique('users')->ignore($id),
        ],
        'address'=> 'required|string|max:255',
    ];

    $messages = [
        'required' => 'Ce champ est requis.',
        'string' => 'Ce champ doit être une chaîne de caractères.',
        'numeric' => 'Ce champ doit être un nombre.',
        'max' => 'Ce champ ne doit pas dépasser :max caractères.',
        'email' => 'L\'adresse email n\'est pas valide.',
        'email.unique' => 'Cet email est déjà utilisé.',
        'phone.required' => 'Le numéro de téléphone est requis.',
        'phone.numeric' => 'Le numéro de téléphone doit être un nombre.',
        'phone.digits' => 'Le numéro de téléphone doit comporter 8 chiffres.',
        'phone.unique' => 'Ce numéro de téléphone est déjà utilisé.',
        'min' => 'Le mot de passe doit avoir au moins :min caractères.',

    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    try {
        $user = User::where('id', $id)->where('role', 2)->first(); // Use 'first' to retrieve the user instance
        if (!$user) {
            return response()->json(['message' => 'Expediteur not found'], 404);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->entreprise = $request->entreprise;
        $user->city=$request->city;
        $user->prix_livraison = $request->prix_livraison;
        $user->prix_retour = $request->prix_retour;
        $user->phone=$request->phone;
        $user->address=$request->address;
        $user->update();

        $success = true;
        $message = "Expediteur updated successfully";

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

public function disableExpediteur($id)
    {
        $expediteur = User::find($id);
        $expediteur->disabled=true;
        $expediteur->save();
        return response()->json(['success'=> 'expediteur disabled successfully']);

    }


     //Livreurs

     public function get_all_livreurs(){
        $livreurs=User::where('role', 3)->get();
        return response()->json([
            'livreurs'=>$livreurs
        ],200);
    }

    public function createLivreur(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users'),
            ],
            'city'=> 'required',
            'phone' => [
                'required',
                'numeric',
                'digits:8',
                Rule::unique('users')->ignore(auth()->user()->id ?? null),
            ],
            'address'=> 'required|string|max:255',
            'password' => 'required|string|min:8',
        ];

        $messages = [
            'required' => 'Ce champ est requis.',
            'string' => 'Ce champ doit être une chaîne de caractères.',
            'max' => 'Ce champ ne doit pas dépasser :max caractères.',
            'email' => 'L\'adresse email n\'est pas valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'phone.required' => 'Le numéro de téléphone est requis.',
            'phone.numeric' => 'Le numéro de téléphone doit être un nombre.',
            'phone.digits' => 'Le numéro de téléphone doit comporter 8 chiffres.',
            'phone.unique' => 'Ce numéro de téléphone est déjà utilisé.',
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
            $user->city=$request->city;
            $user->phone=$request->phone;
            $user->address=$request->address;
            $user->password = Hash::make($request->password);
            $user->role=3;
            $user->save();

            $success = true;
            $message = "livreur register successfully";

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


    public function updateLivreur(Request $request, $id)
{
    $rules = [
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'email',
            'max:255',
            Rule::unique('users')->ignore($id),
        ],
        'city'=> 'required',
        'phone' => [
            'required',
            'numeric',
            'digits:8',
            Rule::unique('users')->ignore($id),
        ],
        'address'=> 'required|string|max:255',
    ];

    $messages = [
        'required' => 'Ce champ est requis.',
        'string' => 'Ce champ doit être une chaîne de caractères.',
        'max' => 'Ce champ ne doit pas dépasser :max caractères.',
        'email' => 'L\'adresse email n\'est pas valide.',
        'email.unique' => 'Cet email est déjà utilisé.',
        'phone.required' => 'Le numéro de téléphone est requis.',
        'phone.numeric' => 'Le numéro de téléphone doit être un nombre.',
        'phone.digits' => 'Le numéro de téléphone doit comporter 8 chiffres.',
        'phone.unique' => 'Ce numéro de téléphone est déjà utilisé.',
        'min' => 'Le mot de passe doit avoir au moins :min caractères.',

    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    try {
        $user = User::where('id', $id)->where('role', 3)->first(); // Use 'first' to retrieve the user instance
        if (!$user) {
            return response()->json(['message' => 'Admin not found'], 404);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->city=$request->city;
        $user->phone=$request->phone;
        $user->address=$request->address;
        $user->update();

        $success = true;
        $message = "Expediteur updated successfully";

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

public function disableLivreur($id)
    {
        $expediteur = User::find($id);
        $expediteur->disabled=true;
        $expediteur->save();
        return response()->json(['success'=> 'livreur disabled successfully']);

    }

}
