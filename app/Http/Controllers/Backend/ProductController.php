<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Services\ProductService;
use App\Repositories\Category\ICategoryRepository;
use App\Repositories\Feature\IFeatureRepository;
use App\Repositories\Product\IProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct(private IProductRepository $productRepository,
                                private readonly ICategoryRepository $categoryRepository,
                                private readonly IFeatureRepository $featureRepository,
                                private ProductService $productService
    ) {
    }
    public function allProduct()
    {
        $products = $this->productRepository->getAllProductWithCategoryAndFeature(Auth::id());
        return view('backend.product.product_all', compact('products'));
    }

    public function addProduct()
    {
        $categories = $this->categoryRepository->getAll();
        $features = $this->featureRepository->getAll();
        return view('backend.product.product_add', compact('categories', 'features'));
    }

    public function storeProduct(Request $request)
    {
        $isStoreProduct = $this->productService->storeProduct($request);
        if($isStoreProduct)
        {
            return redirect()->back()->with('success', 'Product added successfully.');
        }
        else{
            return redirect()->back()->with('error', 'Failed to add product. Please try again.');
        }
    }
}
