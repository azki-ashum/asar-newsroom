<?php

namespace Database\Seeders;

use Botble\Setting\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::whereIn('key', ['media_random_hash'])->delete();

        Setting::insertOrIgnore([
            [
                'key' => 'media_random_hash',
                'value' => md5(time()),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
