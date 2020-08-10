<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2020/5/2
 * Time: 3:47 PM
 */

namespace Modules\Admin\Models;


use App\Models\BaseModel;
use Laravel\Scout\Searchable;


class Test extends BaseModel
{
    use Searchable;
}
