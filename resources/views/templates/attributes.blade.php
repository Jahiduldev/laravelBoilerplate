namespace App\Services\Attributes;

/**
* Class {{ $name }}Attributes
*
* @package App\Services\Attributes
*/
class {{ $name }}Attributes
{
    private array $attributes = [];

    public function toArray(): array
    {
        return $this->attributes;
    }
}
