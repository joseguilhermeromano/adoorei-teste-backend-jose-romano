<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\SaleRequest;
use App\Interfaces\SaleRepositoryInterface;
use App\Http\Resources\SaleCollection;
use App\Models\Order;
use DB;
use Exception;

/**
 * @OA\Info(
 *     title="API ABC",
 *     version="1.0.0",
 *     description="Methods of sale endpoint",
 *     @OA\Contact(
 *         email="jose_guilherme_romano@hotmail.com",
 *         name="José G Romano"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 */
class SaleController extends Controller
{
    private SaleRepositoryInterface $saleRepository;

    public function __construct(SaleRepositoryInterface $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/sales",
     *     summary="Get all sales",
     *     @OA\Response(
     *         response=200,
     *         description="Return a collection of sales",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="sale_id",
     *                 type="string",
     *                 example="202403051"
     *             ),
     *             @OA\Property(
     *                 property="amount",
     *                 type="integer",
     *                 example="35000"
     *             ),
     *             @OA\Property(
     *                 property="products",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="product_id",
     *                         type="integer",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="Product 1"
     *                     ),
     *                     @OA\Property(
     *                         property="price",
     *                         type="string",
     *                         example="3.500"
     *                     ),
     *                     @OA\Property(
     *                         property="amount",
     *                         type="integer",
     *                         example="10"
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $sales = $this->saleRepository->getAll();
        $collection = new SaleCollection($sales);

        return response()->json($collection, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/sale/{id}",
     *     summary="Get a specific sale",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the sale",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Return a single sale",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="sale_id",
     *                 type="string",
     *                 example="202403051"
     *             ),
     *             @OA\Property(
     *                 property="amount",
     *                 type="integer",
     *                 example="35000"
     *             ),
     *             @OA\Property(
     *                 property="products",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="product_id",
     *                         type="integer",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="Product 1"
     *                     ),
     *                     @OA\Property(
     *                         property="price",
     *                         type="string",
     *                         example="3.500"
     *                     ),
     *                     @OA\Property(
     *                         property="amount",
     *                         type="integer",
     *                         example="10"
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No sale found"
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $sale = $this->saleRepository->getById($id);

        if (!$sale) {
            return response()->json(['error' => 'No sale found'], 404);
        }

        $collection = new SaleCollection([$sale]);

        return response()->json($collection, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/sale",
     *     summary="Create a new sale",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"products"},
     *             @OA\Property(
     *                 property="products",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     required={"product_id", "amount"},
     *                     @OA\Property(property="product_id", type="integer"),
     *                     @OA\Property(property="amount", type="integer")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Sale created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="success"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="Product 1"
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store(SaleRequest $request): JsonResponse
    {
        DB::beginTransaction();

        $requestData = $request->only([
            'products'
        ]);

        $data = [
            'amount' => 0
        ];

        $sale = $this->saleRepository->create($data);

        foreach ($requestData['products'] as $prod) {
            $order = new Order([
                'quantity' => $prod['amount'],
                'sale_id' => $sale->id,
                'product_id' => $prod['product_id']
            ]);

            $sale->orders()->save($order);
        }

        $sale->update(['amount' => $sale->amount()]);

        $collection = new SaleCollection([$sale]);

        DB::commit();

        return response()->json($collection, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/sale/{id}",
     *     summary="Update a sale",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the sale",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"products"},
     *             @OA\Property(
     *                 property="products",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     required={"product_id", "amount"},
     *                     @OA\Property(property="product_id", type="integer"),
     *                     @OA\Property(property="amount", type="integer")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sale updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="success"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="Product 1"
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No sale found"
     *     )
     * )
     */
    public function update(int $id, SaleRequest $request): JsonResponse
    {
        DB::beginTransaction();

        $requestData = $request->only([
            'products'
        ]);

        $sale = $this->saleRepository->getById($id);

        if ($sale->orders->isEmpty()) {
            throw new Exception('Sale not found');
        }

        $sale->orders->each(function ($order) {
            $order->delete();
        });

        foreach ($requestData['products'] as $prod) {
            $order = new Order([
                'quantity' => $prod['amount'],
                'sale_id' => $sale->id,
                'product_id' => $prod['product_id']
            ]);

            $sale->orders()->save($order);
        }

        $sale = $this->saleRepository->getById($id);

        $sale->update(['amount' => $sale->amount()]);

        $collection = new SaleCollection([$sale]);

        DB::commit();

        return response()->json($collection, 200);
    }

    /**
     * @OA\Delete(
     *     path="/sale/{id}",
     *     summary="Cancel a sale by ID (using SoftDeletes)",
     *     description="Deletes a sale from the database by its ID.",
     *     operationId="deleteSaleById",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the sale to delete",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sale deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="success"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="Product 1"
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sale not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="No Sale found"
     *             )
     *         )
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $sale =  $this->saleRepository->getById($id);
        $collection = new SaleCollection([$sale]);

        if (!$sale) {
            return response()->json(['error' => 'No Sale found'], 404);
        }

        $response = response()->json($collection, 200);

        $sale->delete();

        return $response;
    }

    /**
     * @OA\Post(
     *     path="/sale/{id}/products",
     *     summary="Add a product to a sale",
     *     description="Adds a product to an existing sale in the database.",
     *     operationId="addProductToSale",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the sale to which the product will be added",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Product data to be added to the sale",
     *         @OA\JsonContent(
     *             type="object",
     *             required={"products"},
     *             @OA\Property(
     *                 property="products",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="product_id",
     *                         type="integer",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="amount",
     *                         type="integer",
     *                         example="5"
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product added successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="success"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="Product 1"
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sale not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="No Sale found"
     *             )
     *         )
     *     )
     * )
     */
    public function addProduct(SaleRequest $request, $id)
    {
        $sale = $this->saleRepository->getById($id);

        if (!$sale) {
            return response()->json(['error' => 'No Sale found'], 404);
        }

        $requestData = $request->only([
            'products'
        ]);

        foreach ($requestData['products'] as $prod) {
            $order = new Order([
                'quantity' => $prod['amount'],
                'sale_id' => $sale->id,
                'product_id' => $prod['product_id']
            ]);

            $sale->orders()->save($order);
        }

        $sale->update(['amount' => $sale->amount()]);

        $sale = $this->saleRepository->getById($id);

        $collection = new SaleCollection([$sale]);

        return response()->json($collection, 200);
    }
}
