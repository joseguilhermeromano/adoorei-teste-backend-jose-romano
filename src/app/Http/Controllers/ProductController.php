<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Interfaces\ProductRepositoryInterface;
use App\Http\Resources\ProductCollection;

class ProductController extends Controller
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository){
        $this->productRepository = $productRepository;
    }

        /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Get all products",
     *     @OA\Response(
     *         response=200,
     *         description="Return a collection of products",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 example="Celular 1"
     *             ),
     *             @OA\Property(
     *                 property="price",
     *                 type="string",
     *                 example="1.800"
     *             ),
     *             @OA\Property(
     *                 property="description",
     *                 type="string",
     *                 example="Aparelho dual chip na cor branca"
     *             ),
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $products = $this->productRepository->getAll();
        $collection = new ProductCollection($products);

        return response()->json($collection, 200);
    }
}
