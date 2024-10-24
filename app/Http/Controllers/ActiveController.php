<?php

namespace App\Http\Controllers;

use App\Models\Active;
use App\Services\ActiveService;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ActiveResource;
use App\Http\Requests\{
    Active\ActiveStoreRequest,
    Active\ActiveListRequest,
    Active\ActiveUpdateRequest,
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
        $actives = $this->service->list(data: $request->validated());
        return $this->ok(ActiveResourceCollection::make($actives));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ActiveStoreRequest $request
     * @return JsonResponse
     */
    public function store(ActiveStoreRequest $request): JsonResponse
    {
       $active = $this->service->create($request->validated());
       return $this->ok(ActiveResource::make($active));
    }
    public function update(Active $active, ActiveUpdateRequest $request): JsonResponse
    {
        $active = $this->service->update($active, $request->validated());
        return $this->ok(ActiveResource::make($active));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $tiker): JsonResponse
    {
        return $this->ok(ActiveResource::make($this->service->find($tiker)));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Active $active): JsonResponse
    {
        return $this->noContent($this->service->delete($active));
    }
}
