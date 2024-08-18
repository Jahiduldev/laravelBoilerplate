<?php 
 
 
namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository implements IProductRepository
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function getAllProductWithCategoryAndFeature(int $userId)
    {
        return $this->model::where('user_id', $userId)->with(['categories', 'features'])->paginate(10);
    }
}
