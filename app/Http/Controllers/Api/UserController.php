<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Sanctum\NewAccessToken;

class UserController extends Controller
{
    public function createToken(string $name, array $abilities = [])
    {
        $token = $this->tokens()->create([
            'name' => $name,
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
            'abilities' => $abilities
        ]);

        return new NewAccessToken($token, $token->getKey().'|'.$plainTextToken);
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            $message = "Wrong input/s";

            return response()->json(compact('message'), 400);
        }

        $user = User::create([
            'first_name' => ucfirst(request('first_name')),
            'last_name' => ucfirst(request('last_name')),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['date' => $user, 'access_token' => $token, 'token_type' => 'Bearer']);
    }

    public function login(Request $request): JsonResponse
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $title = 'Error title unauthorized';
            $message = 'Error title unauthorized';
            return response()->json(compact('title', 'message'), 401);
        }

        $user = Auth::user();
        $token = $user->createToken('Login')->plainTextToken;
        $title = 'Success';
        $message = 'User login successful.';
        return response()->json(compact('title', 'message', 'token',),200);
    }

    public function logout(Request $request) {
//        auth()->logout();
//        $message = "Uspešno ste se odjavili sa sistema!";
//        return response()->json(compact('message'), 200);
        Auth::guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json([], 204);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            $message = "Wrong input/s";

            return response()->json(compact('message'), 400);
        }


//        $data = $userController->getAuthenticatedUser();
//        $user = $data['user'];
        $user = (new User)->find(1);
        $user->first_name = ucfirst(request('first_name'));
        $user->last_name = ucfirst(request('last_name'));
        $user->email = request('email');
        $this->storeProfileImage($user, $request->file("image"));
        $user->save();

        $message = "Uspešno ste izmenili informacije o korisniku.";

        return response()->json(compact('user', 'message'), 200);
    }

    public function destroy(Request $request)
    {
        User::where('email', $request->email)->delete();

        $message = "Uspešno ste izbrisali informacije o korisniku.";

        return response()->json(compact('message'), 200);
    }

    private function storeProfileImage(User $user, UploadedFile $user_image = null)
    {
        if ($user_image) {
            $imageName = 'user-image_' . $user->id . '_' . round(microtime(true) * 1000) . "." .
                $user_image->getClientOriginalExtension();

            $user->image = $imageName;
            $user->save();

            $user_image->move('assets/img/users/', $imageName);
        }

        return $user;
    }

}
