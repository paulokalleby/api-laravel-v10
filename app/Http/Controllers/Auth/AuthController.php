<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Traits\UserAuthTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use UserAuthTrait;
    
    protected $model;
    
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function register(RegisterRequest $request)
    {

        $data = $request->validated();

        $data['password'] = bcrypt($data['password']);

        $user = $this->model->create($data);

        return (new UserResource($user))->additional([
            'token' => $user->createToken($request->device)->plainTextToken
        ]);

    }

    public function login(LoginRequest $request)
    {

        $user = $this->model->where('email', $request->email)->first();
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            
            throw ValidationException::withMessages([
    
                'message' => ['As credenciais fornecidas estão incorretas.'],
            
            ]);
            
        }

        if($user->active == false) {

            throw ValidationException::withMessages([
    
                'message' => ['A conta do usuário está inativa.'],
            
            ]);
        }

        $user->tokens()->delete();
        
        return (new UserResource($user))->additional([
            'token' => $user->createToken($request->device)->plainTextToken
        ]);

    }

    public function me()
    {
        return new UserResource(
            $this->getUser()
        );
    }

    public function logout()
    {
        $this->getUser()->tokens()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso!'
        ]);
    }

}
