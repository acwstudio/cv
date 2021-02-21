<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PostTranslation
 *
 * @package App
 */
class PostTranslation extends Model
{
    protected $fillable  = ['title', 'body'];
}
