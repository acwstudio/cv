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
    public $timestamps = false;
    protected $fillable  = ['title', 'body'];
}
