<?php

namespace App\Http\Controllers\Auth;

use JWTAuth;
use App\Doctor;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\{Request, JsonResponse};
use App\Http\Controllers\Controller;

/**
 * Class TokenAuthController
 * @package App\Http\Controllers
 */
class TokenAuthController extends Controller
{
    /**
     * Authenticate a user
     * @param Request $request
     * @return JsonResponse
     */
    public function authenticate(Request $request) : JsonResponse
    {
        // grab credentials from the request
        $credentials = array_map('trim', $request->only('email', 'password'));

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }

    /**
     * @return JsonResponse
     */
    public function getAuthenticatedUser() : JsonResponse
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate())
                return response()->json(['error' => 'user_not_found'], 404);

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['error' => 'token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => 'token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'token_absent'], $e->getStatusCode());
        }

        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }

    /**
     * Register a new user
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request) : JsonResponse
    {
        if(!$request->has('email'))
            return response()->json(['error' => 'email is required'], 400);

        if(!$request->has('password'))
            return response()->json(['error' => 'password is required'], 400);

        $user = Doctor::where('email', trim($request->input('email')))->first();

        // user already exist
        if($user !== null) {
            return response()->json([
                'error' => sprintf(
                    'email "%s" already taken',
                    trim($request->input('email'))
                )
            ], 422);
        }

        $data = $request->all();
        $data['password'] = Hash::make(trim($request->input('password')));

        $user = Doctor::create($data);

        return response()
            ->json(compact('user'), 201)
            ->header('Location', route('api.v1.me.show'));
    }
}