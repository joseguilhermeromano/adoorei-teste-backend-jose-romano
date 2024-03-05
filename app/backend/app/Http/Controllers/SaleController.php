<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\SaleRequest;
use App\Interfaces\SaleRepositoryInterface;
use App\Http\Resources\SaleCollection;
use App\Models\Order;
use DB;
use Exception;

class SaleController extends Controller
{
    private SaleRepositoryInterface $saleRepository;

    public function __construct(SaleRepositoryInterface $saleRepository){
        $this->saleRepository = $saleRepository;
    }

    public function index(): JsonResponse
    {
        $sales = $this->saleRepository->getAll();
        $collection = new SaleCollection($sales);

        return response()->json($collection, 200);
    }

    public function show(int $id): JsonResponse
    {
        $sale = $this->saleRepository->getById($id);
        $collection = new SaleCollection([$sale]);

        if(!$sale) return response()->json(['message' => 'No Sale found'], 404);

        return response()->json($collection, 200);
    }

    public function store(SaleRequest $request):JsonResponse
    {
        DB::beginTransaction();

        $requestData = $request->only([
            'products'
        ]);

        $data = [
            'amount' => 0
        ];

        $sale = $this->saleRepository->create($data);

        foreach($requestData['products'] as $prod){
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

    public function update(int $id, SaleRequest $request): JsonResponse
    {
        DB::beginTransaction();

        $requestData = $request->only([
            'products'
        ]);

        $sale = $this->saleRepository->getById($id);

        if($sale->orders->isEmpty()){
            throw new Exception('Sale not found');
        }

        $sale->orders->each(function ($order) {
            $order->delete();
        });

        foreach($requestData['products'] as $prod){
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

    public function destroy(int $id) :JsonResponse
    {
        $sale =  $this->saleRepository->getById($id);
        $collection = new SaleCollection([$sale]);

        if(!$sale) return response()->json(['message' => 'No Sale found'], 404);

        $response = response()->json($collection, 200);

        $sale->delete();

        return $response;
    }

    public function addProduct(SaleRequest $request, $id)
    {
        $sale = $this->saleRepository->getById($id);

        if(!$sale) return response()->json(['message' => 'No Sale found'], 404);

        $requestData = $request->only([
            'products'
        ]);

        foreach($requestData['products'] as $prod){
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
