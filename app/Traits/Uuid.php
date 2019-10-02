<?php

namespace App\Traits;

use Ramsey\Uuid\Uuid as RamseyUuid;

trait Uuid
{
    public static function bootUuid()
    {
        static::creating(function ($model) {
            $model->uuid = RamseyUuid::uuid4();
        });
    }

    public static function findUuid($uuid)
    {
        return static::where('uuid', $uuid)->first();
    }
}
