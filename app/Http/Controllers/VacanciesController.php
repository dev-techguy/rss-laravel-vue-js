<?php

namespace App\Http\Controllers;

use App\Events\VacancyEvent;
use App\Http\Requests\VacancyRequest;
use App\Http\Resources\API;
use App\Vacancy;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VacanciesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|object
     */
    public function index()
    {
        //fetch vacancies
        $articles = Vacancy::query()->latest('updated_at')->paginate(50);


        //return vacancies as collection of resource
        return API::collection($articles)->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param VacancyRequest $request
     * @return JsonResponse|object
     */
    public function store(VacancyRequest $request)
    {
        //here check if the method is put else create new vacancy
        $vacancy = $request->isMethod('put') ? Vacancy::query()->findOrFail($request->vacancy_id) : new Vacancy();

        //get article_id
        $vacancy->name = $request->name;
        $vacancy->company = $request->company;
        $vacancy->description = $request->description;

        if ($vacancy->save())
            if ($request->isMethod('put')) {
                return (new API($vacancy))->response()->setStatusCode(Response::HTTP_OK);
            } else {
                // trigger vacancy alert
                event((new VacancyEvent(
                    $request->name,
                    $request->company,
                    $request->description
                )));

                return (new API($vacancy))->response()->setStatusCode(Response::HTTP_CREATED);
            }

        return (new API([
            'Bad GateWay',
        ]))->response()->setStatusCode(Response::HTTP_BAD_GATEWAY);
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return JsonResponse|object
     */
    public function show(string $id)
    {
        //fetch single vacancy
        $vacancy = Vacancy::query()->findOrFail($id);

        //return the vacancy as a resource
        return (new API($vacancy))->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return JsonResponse|object
     * @throws Exception
     */
    public function destroy(string $id)
    {
        //fetch single article
        $vacancy = Vacancy::query()->findOrFail($id);

        if ($vacancy->delete())
            return (new API($vacancy))->response()->setStatusCode(Response::HTTP_OK);

        return (new API([
            'Bad GateWay',
        ]))->response()->setStatusCode(Response::HTTP_BAD_GATEWAY);
    }
}
