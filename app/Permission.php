<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission
 *
 * @package App
 */
class Permission extends \Spatie\Permission\Models\Permission
{
    /**
     * @return array
     */
    public static function defaultPermissions():array
    {

    }
}
