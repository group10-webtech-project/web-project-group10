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
 * @property string $short_name
 * @property string|null $initial_hint
 * @property string $size
 * @property string $habitat
 * @property string $diet
 * @property string $region
 * @property string $lifespan
 * @property bool $has_legs
 * @property bool $has_fur
 * @property bool $can_swim
 * @property bool $can_fly
 * @property bool $is_carnivore
 * @property int $category_id
 * @property string|null $description
 * @property string|null $image_url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Animal extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'animals';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'short_name',
        'initial_hint',
        'size',
        'habitat',
        'diet',
        'region',
        'lifespan',
        'has_legs',
        'has_fur',
        'can_swim',
        'can_fly',
        'is_carnivore',
        'category_id',
        'description',
        'image_url',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'has_legs' => 'boolean',
        'has_fur' => 'boolean',
        'can_swim' => 'boolean',
        'can_fly' => 'boolean',
        'is_carnivore' => 'boolean',
        'category_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getId(): int
    {
        return $this->id;
    }
    /**
     * Define the relationship with the Category model.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Categories::class);
    }

    /**
     * Accessor for the description attribute.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return ucfirst($this->attributes['description']);
    }

    /**
     * Mutator for the description attribute.
     *
     * @param string $value
     * @return void
     */
    public function setDescription(string $value): void
    {
        $this->attributes['description'] = strtolower($value);
    }

    /**
     * Mutator for the diet attribute.
     *
     * @param string $value
     * @return void
     * @throws \InvalidArgumentException
     */
    public function setDiet(string $value): void
    {
        if (!in_array($value, ['Herbivore', 'Carnivore', 'Omnivore'])) {
            throw new \InvalidArgumentException('Invalid diet type.');
        }
        $this->attributes['diet'] = $value;
    }

    /**
     * Accessor for the name attribute.
     *
     * @return string
     */
    public function getName(): string
    {
        return strtoupper($this->attributes['name']);
    }

    /**
     * Accessor for the short_name attribute.
     *
     * @return string
     */
    public function getShortName(): string
    {
        return strtoupper($this->attributes['short_name']);
    }

    /**
     * Accessor for the initial_hint attribute.
     *
     * @return string
     */
    public function getInitialHint(): string
    {
        return ucfirst($this->attributes['initial_hint']);
    }

    /**
     * Relationship with game sessions (example provided in original code).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gameSessions()
    {
        return $this->hasMany(GameSessions::class, 'animal_id');
    }
}
