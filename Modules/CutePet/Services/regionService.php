<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2019/4/12
 * Time: 10:12 PM
 */

namespace Modules\CutePet\Services;

use Modules\Core\Models\region;
use Modules\User\Models\User;

class regionService
{

    public function getRegions()
    {
        return Region::all();
    }
    
    /**
     * 根据用户获取地区
     * @param User $user 用户模型
     */
    public function getRegionByUser(User $user)
    {
        $province = $city = $zone = null;

        $regions = Region
            ::whereIn('id', [$user->province_id, $user->city_id, $user->zone_id])
            ->select(['level', 'name'])
            ->get();

        foreach ($regions as $region) {
            switch ($region->level) {
                case 1:
                    $province = $region->name;
                    break;
                case 2:
                    $city = $region->name;
                    break;
                case 3:
                    $zone = $region->name;
                    break;
                default:
                    break;
            }
        }

        $user->province = $province;
        $user->city = $city;
        $user->zone = $zone;
    }

}