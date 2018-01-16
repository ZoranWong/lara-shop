<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Models\Role::insert([
            ['id' => 1, 'name' => 'root', 'display_name' => '超级管理员', 'description' => ''],
            ['id' => 2, 'name' => 'admin', 'display_name' => '系统管理员', 'description' => ''],
            ['id' => 3, 'name' => 'store.owner', 'display_name' => '店铺拥有者', 'description' => ''],
            ['id' => 4, 'name' => 'store.manager', 'display_name' => '店铺管理员', 'description' => '']
        ]);
        \App\Models\Permission::insert([
            ['id' => 1, 'name' => '*', 'display_name' => '所用权限', 'description' => '用户所用操作权限'],
            ['id' => 2, 'name' => 'admin.home', 'display_name' => '管理员首页', 'description' => '管理员登录后自动定向的页面'],
            ['id' => 3, 'name' => 'store.owner.home', 'display_name' => '店铺老板首页', 'description' => '店铺老板登录后首页'],
            ['id' => 4, 'name' => 'store.manager.home', 'display_name' => '店铺管理员首页', 'description' => '店铺管理员登录后首页'],
        ]);
        \App\Models\UserRole::insert([
            ['user_id' => 1, 'role_id' => 1]
        ]);
        \App\Models\PermissionRole::insert([
            'role_id' => 1,
            'permission_id' => 1
        ]);
    }
}
