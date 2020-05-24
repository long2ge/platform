<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2019/4/12
 * Time: 10:16 PM
 */

namespace Modules\CutePet\Http\Controllers\V1\Region;


use Modules\Core\Http\Controllers\BaseCoreController;
use Modules\Core\Models\region;
use Modules\Core\Services\regionService;
use Modules\Core\Transformers\RegionTransformer;

class RegionController extends BaseCoreController
{
    /**
     * @var RegionService 地区服务
     */
    private $regionService;

    /**
     * 构造函数
     * RegionService constructor.
     * @param RegionService $regionService
     */
    public function __construct(RegionService $regionService)
    {
        $this->regionService = $regionService;
    }

    /**
     * 地区列表
     * @param int $provinceId 省份id
     * @param int $cityId   城市id
     * @return \Dingo\Api\Http\Response
     */
    public function index(int $provinceId, int $cityId)
    {
        if ( 0 == $provinceId) {
            $pid = 0;
        } else if ( 0 == $cityId) {
            $pid = $provinceId;
        } else {
            $pid = $cityId;
        }

        $region = Region::where('enable', 1)->where('pid', $pid)->get();

        return $this->response
            ->collection($region, new RegionTransformer())
            ->setStatusCode(200);
    }

}