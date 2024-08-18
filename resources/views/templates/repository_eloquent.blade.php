namespace App\Repositories;

use App\Contracts\Repositories\{{ $name }}RepositoryInterface;
use App\Models\{{ $name }};

class {{ $name }}RepositoryEloquent extends BaseRepository implements {{ $name }}RepositoryInterface
{
    public function __construct({{ $name }} $model)
    {
        parent::__construct($model::query());
    }
}
