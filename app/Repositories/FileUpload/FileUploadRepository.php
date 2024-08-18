<?php 
 
 
namespace App\Repositories\FileUpload;

use App\Models\FileUpload;
use App\Repositories\BaseRepository;

class FileUploadRepository extends BaseRepository implements IFileUploadRepository
{
    public function __construct(FileUpload $model)
    {
        parent::__construct($model);
    }
}
