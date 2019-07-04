<?php

namespace App;

use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Post
 *
 * @package App
 */
class Post extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['title', 'body'];
    protected $fillable = ['user_id'];
}
