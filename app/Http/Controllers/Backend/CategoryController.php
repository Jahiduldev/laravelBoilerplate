<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\Category\ICategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function __construct(private ICategoryRepository $categoryRepository) {
    }

    public function allCategory()
    {
        $categories = $this->categoryRepository->getCategoryWithProductCounts(Auth::id());
        return view('backend.category.category_all', compact('categories'));
    }

    public function addCategory()
    {
        return view('backend.category.category_add');
    }

    public function storeCategory(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = [
                'name' => $request->input('category_name'),
                'user_id' => Auth::id(),
            ];
            $this->categoryRepository->create($data);
            DB::commit();
            return redirect()->back()->with('success', 'Category added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to add category. Please try again.');
        }
    }
}
