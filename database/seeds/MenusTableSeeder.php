<?php

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Models\Permission::insert([
            ['id' => 5, 'name' => 'home', 'display_name' => '首页', 'description' => '管理员可以添加店铺，管理店铺申请'],
            ['id' => 6, 'name' => 'roles', 'display_name' => '角色管理', 'description' => '管理员管理系统角色添加与修改角色'],
            ['id' => 7, 'name' => 'permissions', 'display_name' => '权限管理', 'description' => '管理员管理权限系统'],
            ['id' => 8, 'name' => 'menus', 'display_name' => '菜单管理', 'description' => '管理员管理菜单系统'],
            ['id' => 9, 'name' => 'stores', 'display_name' => '店铺管理', 'description' => '管理员可以添加店铺，管理店铺申请'],
            ['id' => 10, 'name' => 'categories', 'display_name' => '商品分类', 'description' => '管理员为系统添加分类'],
            ['id' => 11, 'name' => 'merchandises', 'display_name' => '商品管理', 'description' => '店铺管理员管理商品'],
            ['id' => 12, 'name' => 'orders', 'display_name' => '订单管理', 'description' => '店铺订单管理'],
            ['id' => 13, 'name' => 'group-coupons', 'display_name' => '团购管理', 'description' => '团购活动管理'],
            ['id' => 14, 'name' => 'setting', 'display_name' => '店铺设置', 'description' => '店主设置店铺信息'],
            ['id' => 15, 'name' => 'distribution', 'display_name' => '分销管理', 'description' => '商品分销管理']
        ]);
        \App\Models\Menu::insert([
            ['permission_id' => 5, 'text' => '首页', 'icon' => 'fa-tachometer', 'url' => '/', 'visible' => true, 'is_active' => true],
            ['permission_id' => 6, 'text' => '角色管理', 'icon' => 'fa-user', 'url' => '/roles', 'visible' => true, 'is_active' => false],
            ['permission_id' => 7, 'text' => '权限管理', 'icon' => 'fa-ban', 'url' => '/permissions', 'visible' => true, 'is_active' => false],
            ['permission_id' => 8, 'text' => '菜单管理', 'icon' => 'fa-bars', 'url' => '/menus', 'visible' => true, 'is_active' => false],
            ['permission_id' => 9, 'text' => '店铺管理', 'icon' => 'fa-bank', 'url' => '/stores', 'visible' => true, 'is_active' => false],
            ['permission_id' => 10, 'text' => '商品分类', 'icon' => 'fa-th', 'url' => '/categories', 'visible' => true, 'is_active' => false],
            ['permission_id' => 11, 'text' => '商品管理', 'icon' => 'fa-shopping-bag', 'url' => '/merchandises', 'visible' => true, 'is_active' => false],
            ['permission_id' => 12, 'text' => '订单管理', 'icon' => 'fa-shopping-cart', 'url' => '/orders', 'visible' => true, 'is_active' => false],
            ['permission_id' => 13, 'text' => '团购管理', 'icon' => 'fa-tag', 'url' => '/group/coupons', 'visible' => true, 'is_active' => false],
            ['permission_id' => 14, 'text' => '店铺设置', 'icon' => 'fa-cogs', 'url' => '/setting', 'visible' => true, 'is_active' => false],
            ['permission_id' => 15, 'text' => '分销管理', 'icon' => 'fa-clone', 'url' => '/distribution', 'visible' => true, 'is_active' => false],
        ]);
    }
}
