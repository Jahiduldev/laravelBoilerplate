<?php 
 
 
namespace App\Repositories\abc;

use App\Models\abc;
use App\Repositories\BaseRepository;

class abcRepository extends BaseRepository implements IabcRepository
{
    public function __construct(abc $model)
    {
        parent::__construct($model);
    }
}
