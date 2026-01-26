<?php

namespace Botble\Mitra;

use Illuminate\Support\Facades\Schema;
use Botble\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {
        Schema::dropIfExists('mitras');
        Schema::dropIfExists('mitras_translations');
    }
}
