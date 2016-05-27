<?php

namespace App\Http\Controllers\Api;

use App\Appointment;
use Carbon\Carbon;
use Hash;
use JWTAuth;
use App\{Doctor, Patient};
use App\Http\{Requests, Controllers\Controller};
use Illuminate\Http\{Request, JsonResponse};

class AppointmentsController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => []]);
    }

    /**
     * Display a listing of patients for the authenticated doctor.
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        try {
            if (! $doctor = JWTAuth::parseToken()->authenticate())
                return response()->json(['error' => 'doctor_not_found'], 404);

            $appointments = $doctor->appointments->load('patient');

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['error' => 'token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['error' => 'token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['error' => 'token_absent'], $e->getStatusCode());

        }
        return response()->json(compact('appointments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request) : JsonResponse
    {
        try {
            if (! $doctor = JWTAuth::parseToken()->authenticate())
                return response()->json(['error' => 'user_not_found'], 404);

            $appointment = new Appointment();
            $appointment->at = Carbon::parse(trim($request->input('at')));

            $patient = Patient::find((int)trim($request->input('id')));

            $patient->appointments($doctor)->save($appointment);

            $appointment->with = $patient;

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['error' => 'token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['error' => 'token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['error' => 'token_absent'], $e->getStatusCode());

        }
        return response()->json(compact('appointments'), 201)
            ->header('Location', route('api.v1.appointments.show', [$appointment->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id) : JsonResponse
    {
        try {
            if (! $doctor = JWTAuth::parseToken()->authenticate())
                return response()->json(['error' => 'user_not_found'], 404);

            if (! $appointment = Appointment::with('patient')->find($id))
                return response()->json(['error' => 'appointment_not_found'], 404);

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['error' => 'token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['error' => 'token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['error' => 'token_absent'], $e->getStatusCode());

        }
        return response()->json(compact('appointment'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id) : JsonResponse
    {
        try {
            if (! $doctor = JWTAuth::parseToken()->authenticate())
                return response()->json(['error' => 'user_not_found'], 404);

            $appointment = Appointment::with('patient')->find($id);
            $appointment->at = Carbon::parse(trim($request->input('at')));
            $appointment->save();

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['error' => 'token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['error' => 'token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['error' => 'token_absent'], $e->getStatusCode());
        }
        return response()->json(compact('appointment'), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id) : JsonResponse
    {
        try {
            if (! $doctor = JWTAuth::parseToken()->authenticate())
                return response()->json(['error' => 'user_not_found'], 404);

            $appointment = Appointment::with('patient')->find($id);
            $appointment->delete();

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['error' => 'token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['error' => 'token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['error' => 'token_absent'], $e->getStatusCode());
        }
        return response()->json(null, 204);
    }
}
