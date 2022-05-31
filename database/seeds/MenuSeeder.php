<?php

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Menu Seeder
         * table = 'menu'
         * column = {
         *  id,
         *  parent_id, /* for defining if menu is child or parent, if parent_id = 0 then the menu is parent
         *  is_section, /* for defining the menu is below what section, if null then its not have section
         *  title,
         *  bullet, /* default null, if wanna show icon in submenu then just give null, but if u won't to show icon in submenu just give 'dot' or 'line'
         *  icon,
         *  has_submenu,
         *  page (route),
         *  order, /* order to render menu
         *  is_active,
         *  created_at,
         *  updated_at,
         *  deleted_at
         * }
         */
        $menus = [
            [1, 0, 0, 'Dashboard', 'dot', 'media/svg/icons/Design/Layers.svg', 0, 'dashboard', 0, 1, '2021-08-10 14:19:26', '2021-08-10 14:19:26', null],
            [2, 0, 1, 'Admin', 'dot', 'media/svg/icons/Design/Layers.svg', 0, '', 3, 1, '2021-08-10 14:19:26', '2021-08-10 14:19:26', null],
            [3, 0, 0, 'Settings', null, 'fa fa-cog', 1, null, 4, 1, '2021-08-10 14:19:26', '2021-08-10 14:19:26', null],
            [4, 3, 0, 'User Management', null, 'media/svg/icons/General/User.svg', 0, 'user', 0, 1, '2021-08-10 14:19:26', '2021-08-10 14:19:26', null],
            [5, 3, 0, 'Menu', null, 'media/svg/icons/Text/Menu.svg', 0, 'menu', 1, 1, '2021-08-10 14:19:26', '2021-08-10 14:19:26', null],
            [6, 3, 0, 'Roles', null, 'fas fa-user-cog', 0, 'roles', 2, 1, '2021-08-10 14:19:26', '2021-08-10 14:19:26', null],
        ];

        foreach ($menus as $key => $row) {
            Menu::create([
                'parent_id' => $row[1],
                'is_section' => $row[2],
                'title' => $row[3],
                'bullet' => $row[4],
                'icon' => $row[5],
                'has_submenu' => $row[6],
                'page' => $row[7],
                'order' => $row[8],
                'is_active' => $row[9],
                'created_at' => $row[10],
                'updated_at' => $row[11],
                'deleted_at' => $row[12],
            ]);
        }
    }
}
