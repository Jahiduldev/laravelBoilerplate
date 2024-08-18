<?php

namespace App\Http\Services;

use App\Repositories\Product\IProductRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function __construct(
        private IProductRepository $productRepository,
    )
    {

    }

    public function storeProduct($request)
    {
        try {
            DB::beginTransaction();
            $data = [
                'name' => $request->input('product_name'),
                'price' => $request->input('price'),
                'user_id' => Auth::id(),
            ];
            $product = $this->productRepository->create($data);
            // Attach categories to the product
            if ($request->has('categories')) {
                $product->categories()->attach($request->input('categories'));
            }

            // Attach features to the product
            if ($request->has('features')) {
                $product->features()->attach($request->input('features'));
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
