<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 15);
        $perPage = $perPage > 0 && $perPage <= 100 ? $perPage : 15;

        $query = Products::query();
        // Filtros básicos iniciales (más adelante se ampliarán): búsqueda por nombre y categoría
        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }
        if ($category = $request->get('category')) {
            $query->where('category', $category);
        }

        $products = $query->paginate($perPage);
        return ProductResource::collection($products)->additional([
            'meta' => [
                'version' => 'v1'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = Products::create($request->validated());
        return (new ProductResource($product))
            ->additional(['meta' => ['version' => 'v1']])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Products::findOrFail($id);
        return (new ProductResource($product))->additional(['meta' => ['version' => 'v1']]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Products::findOrFail($id);
        $product->update($request->validated());
        return (new ProductResource($product))->additional(['meta' => ['version' => 'v1']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Products::findOrFail($id);
        $product->delete();
        return response()->json([], 204);
    }
}
