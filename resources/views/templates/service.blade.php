
namespace App\Services;

use App\Contracts\Repositories\{{ $name  }}RepositoryInterface;
use App\Contracts\Services\{{ $name  }}ServiceInterface;
use App\Services\Attributes\{{ $name  }}Attributes;


class {{ $name  }}Service implements {{ $name  }}ServiceInterface
{
    private {{ $name  }}RepositoryInterface ${{  strtolower($name) }}Repository;

    /**
     * @var Application|\Illuminate\Foundation\Application|mixed
     */
    private {{ $name  }}Attributes ${{  strtolower($name) }}Attributes;

    public function __construct()
    {
        $this->{{  strtolower($name) }}Repository = app({{ $name  }}RepositoryInterface::class);
        $this->{{  strtolower($name) }}Attributes = app({{ $name  }}Attributes::class);
    }

    public function {{  strtolower($name) }}Create()
    {
        return $this->{{  strtolower($name) }}Repository->create($this->{{  strtolower($name) }}Attributes->toArray());
    }

    public function get{{ $name  }}Attributes(): {{ $name  }}Attributes
    {
        return $this->{{  strtolower($name) }}Attributes;
    }
}
