<?php

namespace App\Http\Controllers\Api;

use Hash;
use JWTAuth;
use App\{Doctor, Patient};
use App\Http\{Requests, Controllers\Controller};
use Illuminate\Http\{Request, JsonResponse};

/**
 * Class MeController
 * @package App\Http\Controllers\Api
 */
class MeController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => []]);
    }

    /**
     * Display the authenticated resource.
     *
     * @return JsonResponse
     */
    public function show() : JsonResponse
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
        return response()->json(compact('user'));
    }
}
