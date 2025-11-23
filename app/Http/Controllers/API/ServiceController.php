<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Services;
use App\Http\Resources\ServiceResource;
use Illuminate\Http\Request;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ServiceController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 15);
        $perPage = $perPage > 0 && $perPage <= 100 ? $perPage : 15;

        $query = Services::query();
        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }
        if ($type = $request->get('type')) {
            $query->where('type', $type);
        }
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }
        if ($minPrice = $request->get('min_price')) {
            if (is_numeric($minPrice)) {
                $query->where('price', '>=', (float) $minPrice);
            }
        }
        if ($maxPrice = $request->get('max_price')) {
            if (is_numeric($maxPrice)) {
                $query->where('price', '<=', (float) $maxPrice);
            }
        }
        if ($minTime = $request->get('min_time')) {
            if (is_numeric($minTime)) {
                $query->where('estimated_time', '>=', (int) $minTime);
            }
        }
        if ($maxTime = $request->get('max_time')) {
            if (is_numeric($maxTime)) {
                $query->where('estimated_time', '<=', (int) $maxTime);
            }
        }

        // Ordenación segura
        $allowedSorts = ['name','price','estimated_time','created_at'];
        $sort = $request->get('sort');
        $direction = strtolower($request->get('direction','desc')) === 'asc' ? 'asc' : 'desc';
        if ($sort && in_array($sort, $allowedSorts, true)) {
            $query->orderBy($sort, $direction);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $services = $query->paginate($perPage);
        return ServiceResource::collection($services)->additional([
            'meta' => [
                'version' => 'v1'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        $this->authorize('create', Services::class);
        $service = Services::create($request->validated());
        return (new ServiceResource($service))
            ->additional(['meta' => ['version' => 'v1']])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = Services::findOrFail($id);
        return (new ServiceResource($service))->additional(['meta' => ['version' => 'v1']]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, string $id)
    {
        $service = Services::findOrFail($id);
        $this->authorize('update', $service);
        $service->update($request->validated());
        return (new ServiceResource($service))->additional(['meta' => ['version' => 'v1']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Services::findOrFail($id);
        $this->authorize('delete', $service);
        $service->delete();
        return response()->json([], 204);
    }
}
