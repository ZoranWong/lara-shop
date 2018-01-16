<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Models\User::class, 50)->create(['nickname'=> 'Json', 'head_image_url' => 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1514880198770&di=8d766ce2261f5a93ab97ac1045961f38&imgtype=0&src=http%3A%2F%2Fimgsrc.baidu.com%2Fimgad%2Fpic%2Fitem%2Fc2cec3fdfc039245ccdf7c248c94a4c27d1e25b6.jpg','mobile' => '18516688076', 'password' => bcrypt('123456')]);

    }
}
