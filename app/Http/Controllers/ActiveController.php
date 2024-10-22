<?php

namespace App\Http\Controllers;

use App\Models\Active;
use Illuminate\Http\Request;
use App\Services\ActiveService;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ActiveResource;
use App\Http\Requests\{
    Active\ActiveStoreRequest,
    Active\ActiveListRequest
};
use App\Http\Resources\ActiveResourceCollection;

class ActiveController extends Controller
{

    public function __construct(public ActiveService $service)
    {

    }

    /**
     * List all actives
     *
     * @param ActiveListRequest $request
     * @return JsonResponse
     */
    public function index(ActiveListRequest $request): JsonResponse
    {
        $actives = $this->service->list(data: $request->all());
        return $this->ok(new ActiveResourceCollection($actives));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ActiveStoreRequest $request)
    {
       $active = $this->service->create($request->all());
       return $this->ok(ActiveResource::make($active));
    }

    /**
     * Display the specified resource.
     */
    public function show(Active $active): JsonResponse
    {
        return $this->ok(ActiveResource::make($active));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
