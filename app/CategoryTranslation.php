<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CategoryTranslation
 * @package App
 */
class CategoryTranslation extends Model
{
    public $timestamps = false;
    protected $fillable  = ['locale', 'name'];
}
