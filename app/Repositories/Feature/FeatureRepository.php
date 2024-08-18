<?php 
 
 
namespace App\Repositories\Feature;

use App\Models\Feature;
use App\Repositories\BaseRepository;

class FeatureRepository extends BaseRepository implements IFeatureRepository
{
    public function __construct(Feature $model)
    {
        parent::__construct($model);
    }

    public function getAllFeatures()
    {
        return $this->model::paginate(10);
    }
}
