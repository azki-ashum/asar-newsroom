<?php

namespace Botble\Mitra\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;

class Mitra extends BaseModel
{
    protected $table = 'mitras';

    protected $fillable = [
        'name',
        'slug',
        'id_cabang',
        'type',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];
}
