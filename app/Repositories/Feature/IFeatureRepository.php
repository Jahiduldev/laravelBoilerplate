<?php 
 
 
namespace App\Repositories\Feature;

use App\Repositories\IBaseRepository;

interface IFeatureRepository extends IBaseRepository
{
    public function getAllFeatures();
}
