<?php 
 
 
namespace App\Repositories\Category;

use App\Repositories\IBaseRepository;

interface ICategoryRepository extends IBaseRepository
{
    public function getCategoryWithProductCounts(int $userId);
}
