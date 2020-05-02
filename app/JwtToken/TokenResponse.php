<?php


namespace App\JwtToken;


use App\Http\Resources\API;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

trait TokenResponse
{
    /**
     * -------------------------
     * generate the jwt token
     * to be used for access
     * ------------------------
     * @param $token
     * @return JsonResponse|object
     */
    protected function respondWithToken($token)
    {
        return (new API([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60 // token expires in 1hr
        ]))->response()->setStatusCode(Response::HTTP_OK);
    }
}
