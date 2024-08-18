<?php 
 
 
namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository implements ICategoryRepository
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function getCategoryWithProductCounts(int $userId)
    {
        return $this->model::withCount('products')->where('user_id', $userId)
        ->paginate(10);
    }
}
