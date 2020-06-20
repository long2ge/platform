<?php
/**
 * Created by PhpStorm.
 * User: Long
 * Date: 2020/5/28
 * Time: 22:00
 */

namespace App\Repositories;


class CutePetUserRepository extends AbstractUserRepository
{
    public function getProviderClass(): string
    {
        $provider = config('auth.guards.cute_pet_api.provider');

        return config('auth.providers.'.$provider.'.model');
    }


}