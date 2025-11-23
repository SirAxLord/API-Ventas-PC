<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 15);
        $perPage = $perPage > 0 && $perPage <= 100 ? $perPage : 15;

        $query = Products::query();

        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }
        if ($category = $request->get('category')) {
            $query->where('category', $category);
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
        if ($minStock = $request->get('min_stock')) {
            if (is_numeric($minStock)) {
                $query->where('stock', '>=', (int) $minStock);
            }
        }

        // Ordenación segura
        $allowedSorts = ['name','price','created_at'];
        $sort = $request->get('sort');
        $direction = strtolower($request->get('direction','desc')) === 'asc' ? 'asc' : 'desc';
        if ($sort && in_array($sort, $allowedSorts, true)) {
            $query->orderBy($sort, $direction);
        } else {
            $query->orderBy('created_at', 'desc');
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
        $this->authorize('create', Products::class);
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
        $this->authorize('update', $product);
        $product->update($request->validated());
        return (new ProductResource($product))->additional(['meta' => ['version' => 'v1']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Products::findOrFail($id);
        $this->authorize('delete', $product);
        $product->delete();
        return response()->json([], 204);
    }
}
