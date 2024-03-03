<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\SaleRequest;

class SaleController extends Controller
{
    private SaleRepositoryInterface $saleRepository;

    public function __construct(SaçeRepositoryInterface $saleRepository){
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
        //
    }

    public function update(int $id, SaleRequest $request): JsonResponse
    {
        //
    }

    public function destroy(int $id) :JsonResponse
    {
        DB::beginTransaction();

        $sale =  $this->saleRepository->getById($id);
        $collection = new SaleCollection([$sale]);

        if(!$sale) return response()->json(['message' => 'No Sale found'], 404);

        $sale->delete();

        DB::commit();
        return response()->json($collection, 200);
    }
}
