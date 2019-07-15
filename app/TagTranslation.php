<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TagTranslation
 *
 * @package App
 */
class TagTranslation extends Model
{
    public $timestamps = false;
    public $fillable = ['name'];
}
