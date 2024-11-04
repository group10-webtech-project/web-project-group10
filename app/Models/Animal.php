<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class Animal
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $size
 * @property string $habitat
 * @property string $diet
 * @property string $region
 * @property string $lifespan
 * @property int $category_id
 * @property string|null $description
 * @property string|null $image_url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Animal extends Model
{

    protected $table = 'animals';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'size',
        'habitat',
        'diet',
        'region',
        'lifespan',
        'category_id',
        'description',
        'image_url',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        //
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'category_id' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // Define the relationship with the Category model
    public function category(): BelongsTo
    {
        return $this->belongsTo(Categories::class);
    }
    public function getDescription(): string
    {
        return ucfirst($this->attributes['description']);
    }

    public function setDescription(string $value): void
    {
        $this->attributes['description'] = strtolower($value);
    }

    public function setDiet(string $value): void
    {
        // TODO: update/expand on the diet types
        if (!in_array($value, ['Herbivore', 'Carnivore', 'Omnivore'])) {
            throw new \InvalidArgumentException('Invalid diet type.');
        }
        $this->attributes['diet'] = $value;
    }
}
