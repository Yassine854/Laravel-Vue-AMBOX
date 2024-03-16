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
use Illuminate\Validation\ValidationException;

use App\Models\Solde;


class UserController extends Controller
{
    public function login(Request $request)
{
    $identifier = $request->identifier;
    $password = $request->password;

    // Check if the identifier is an email or a phone number
    if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
        $credentials = ['email' => $identifier, 'password' => $password];
    } else {
        // The identifier is a phone number
        $credentials = ['phone' => $identifier, 'password' => $password];
    }

    if (Auth::attempt($credentials)) {
        $success = true;
        $message = "User login successfully";
    } else {
        $success = false;
        $message = "Veuillez vérifier vos données.";
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
                'nullable',
                'email',
                'max:255',
                Rule::unique('users'),
            ],
            'phone' => [
                'required',
                'numeric',
                'digits:8',
                Rule::unique('users'),
            ],
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
            $user->phone = $request->phone;
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
            'nullable',
            'email',
            'max:255',
            Rule::unique('users')->ignore($id),
        ],
        'phone' => [
            'required',
            'numeric',
            'digits:8',
            Rule::unique('users')->ignore($id),
        ],
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

    if ($admin && $id != 1) {
        $admin->disabled = true;
        $admin->save();
        return response()->json(['success' => 'Admin disabled successfully']);
    }

    return response()->json(['error' => 'Admin not found or cannot be disabled'], 404);
}


    public function enableAdmin($id)
    {
        $admin = User::find($id);
        $admin->disabled=false;
        $admin->save();
        return response()->json(['success'=> 'admin enabled successfully']);

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
                'nullable',
                'email',
                'max:255',
                Rule::unique('users'),
            ],
            'entreprise' => 'required|string|max:255',
            'gouvernorat' => 'required|string|max:255',
            'delegation' => 'required|string|max:255',
            'localite' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'prix_livraison'=> 'required|numeric',
            'prix_retour'=> 'required|numeric',
            'phone' => [
                'required',
                'numeric',
                'digits:8',
                Rule::unique('users'),
            ],
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
            $user->gouvernorat = $request->gouvernorat;
            $user->delegation = $request->delegation;
            $user->localite = $request->localite;
            $user->address = $request->address;
            $user->prix_livraison = $request->prix_livraison;
            $user->prix_retour = $request->prix_retour;
            $user->phone=$request->phone;
            $user->password = Hash::make($request->password);
            $user->role=2;
            $user->save();

            $solde = new Solde();
            $solde->solde=0;
            $solde->expediteur_id=$user->id;
            $solde->save();


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
            'nullable',
            'email',
            'max:255',
            Rule::unique('users')->ignore($id),
        ],
        'entreprise' => 'required|string|max:255',
        'gouvernorat' => 'required|string|max:255',
        'delegation' => 'required|string|max:255',
        'localite' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'prix_livraison'=> 'required|numeric',
        'prix_retour'=> 'required|numeric',
        'phone' => [
            'required',
            'numeric',
            'digits:8',
            Rule::unique('users')->ignore($id),
        ],
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
        $user->gouvernorat = $request->gouvernorat;
        $user->delegation = $request->delegation;
        $user->localite = $request->localite;
        $user->address = $request->address;
        $user->prix_livraison = $request->prix_livraison;
        $user->prix_retour = $request->prix_retour;
        $user->phone=$request->phone;
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

    public function enableExpediteur($id)
    {
        $expediteur = User::find($id);
        $expediteur->disabled=false;
        $expediteur->save();
        return response()->json(['success'=> 'expediteur enabled successfully']);

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
                'nullable',
                'email',
                'max:255',
                Rule::unique('users'),
            ],
            'phone' => [
                'required',
                'numeric',
                'digits:8',
                Rule::unique('users'),
            ],
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
            $user->phone=$request->phone;
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
            'nullable',
            'email',
            'max:255',
            Rule::unique('users')->ignore($id),
        ],
        'phone' => [
            'required',
            'numeric',
            'digits:8',
            Rule::unique('users')->ignore($id),
        ],
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
        $user->phone=$request->phone;
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


    public function enableLivreur($id)
    {
        $expediteur = User::find($id);
        $expediteur->disabled=false;
        $expediteur->save();
        return response()->json(['success'=> 'livreur enabled successfully']);

    }

    public function verifyOldPassword( Request $request,$id)
{
    $this->validate($request, [
        'old_password' => 'required',
    ]);

    $user = User::find($id);

    if (!$user) {
        return response()->json(['error' => 'Utilisateur non trouvé.'], 404);
    }

    if (!Hash::check($request->old_password, $user->password)) {
        throw ValidationException::withMessages([
            'password' => ['Le mot de passe précédent est incorrect.'],
        ]);
    }

    return response()->json(['success' => true]);
}

public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'new_password'=>'required|string|min:8',
        ]);

        $user=User::find($id);
        $user->password = Hash::make($request->new_password);
        $user->update();
        return response()->json([
            'message'=>'User updated successfully'
        ]);
    }
}
