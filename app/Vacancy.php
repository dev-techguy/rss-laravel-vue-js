<?php

namespace App;

use App\Listeners\SlugListener;
use App\Uuids\Uuids;
use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    use Uuids;

    // stop autoincrement
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'company',
        'description',
    ];

    /**
     * trigger this to create a slug before
     * any save happens
     */
    protected $dispatchesEvents = [
        'saving' => SlugListener::class,
        'creating' => SlugListener::class,
        'updating' => SlugListener::class,
    ];
}
