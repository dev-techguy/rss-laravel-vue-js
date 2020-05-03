<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscribeRequest;
use App\Http\Resources\API;
use App\Subscribe;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * subscribe the user
     * @param SubscribeRequest $request
     * @return JsonResponse|object
     */
    public function subscribe(SubscribeRequest $request)
    {
        $subscribe = Subscribe::query()->create($request->validated());
        if ($subscribe)
            return (new API($subscribe))->response()->setStatusCode(Response::HTTP_OK);

        return (new API([
            'Bad GateWay',
        ]))->response()->setStatusCode(Response::HTTP_BAD_GATEWAY);
    }
}
