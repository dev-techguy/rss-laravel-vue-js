<?php

namespace App;

use App\Uuids\Uuids;
use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
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
        'email',
    ];
}
