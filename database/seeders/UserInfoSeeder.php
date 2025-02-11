<?php

namespace Database\Seeders;

use App\Models\UserInfo;
use Illuminate\Database\Seeder;

class UserInfoSeeder extends Seeder
{
    const COUNT = 10 ^ 1;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserInfo::factory()->count(self::COUNT)->create();
    }
}
