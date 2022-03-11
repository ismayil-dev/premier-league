<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read string $name
 * @property-read string $logo
 * @property-read string $image_path
 */
class Team extends Model
{
    use HasFactory;

    /**
     * Fillable fields
     * @var string[]
     */
    protected $fillable = [
        'name',
        'logo',
    ];

    /**
     * Return image path
     * @return Attribute
     */
    public function imagePath(): Attribute
    {
        return new Attribute(
            fn($team) => asset("images/teams/{$this->logo}")
        );
    }
}
