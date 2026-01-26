<?php

namespace Botble\Mitra\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class MitraRequest extends Request
{
    public function rules(): array
    {
        return [
            'name'      => 'required',
            'slug'      => 'required',
            'id_cabang' => 'required',
            'type'      => 'required',
            'status'    => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
