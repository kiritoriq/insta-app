<?php
namespace App\Classes\Theme;

use App\Classes\Theme\Metronic;
use App\Models\Permission;
use App\Models\RolePermission;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class Menu
{
    /**
     * Aside menu
     * @param $item
     * @param null $parent
     * @param int $rec
     * @param bool $singleItem
     *
     * @return string
     */
    public static function renderVerMenu($item,  $parent = null, $rec = 0, $singleItem = false)
    {
        self::checkRecursion($rec);
        if (isset($item['separator'])) {
            echo '<li class="menu-separator"><span></span></li>';
        } elseif (isset($item['section'])) {
            $sectionPermission = strtolower(str_replace(" ", "", $item['title']));
            if(self::hasSectionPermission('section-'.$sectionPermission.'-show')) {
                echo '<li class="menu-section ' . ($rec === 0 ? 'menu-section--first' : '') . '">
                    <h4 class="menu-text">' . $item['section'] . '</h4>
                    <i class="menu-icon flaticon-more-v2"></i>
                </li>';
            }
        } elseif (isset($item['title'])) {
            $menuPermission = strtolower(str_replace(" ", "", $item['title']));
            if(self::hasPermission('menu-'.$menuPermission.'-show')) {
                $item_class = '';
                $item_attr = '';
                        if (isset($item['submenu'])) {
                            $item_class .= ' menu-item-submenu'; // m-menu__item--active
            
                            if (isset($item['toggle']) && $item['toggle'] == 'click') {
                                $item_attr .= ' data-menu-toggle="click"';
                            } else {
                                $item_attr .= ' data-menu-toggle="hover"';
                            }
            
                            if (isset($item['mode'])) {
                                $item_attr .= ' data-menu-mode="' . $item['mode'] . '"';
                            }
            
                            if (isset($item['dropdown-toggle-class'])) {
                                $item_attr .= ' data-menu-toggle-class="' . $item['dropdown-toggle-class'] . '"';
                            }
                        }
            
                        if (@$item['redirect'] === true) {
                            $item_attr .= ' data-menu-redirect="1"';
                        }
            
                        // parent item for hoverable submenu
                        if (isset($item['parent'])) {
                            $item_class .= ' menu-item-parent'; // m-menu__item--active
                        }
            
                        // custom class for menu item
                        if (isset($item['custom-class'])) {
                            $item_class .= ' ' . $item['custom-class'];
                        }
            
                        if (isset($item['submenu']) && self::isActiveVerMenuItem($item, request()->path())) {
                            $item_class .= ' menu-item-open menu-item-here'; // m-menu__item--active
                        } elseif (self::isActiveVerMenuItem($item, request()->path())) {
                            $item_class .= ' menu-item-active';
                        }
            
                        echo '<li class="menu-item ' . $item_class . '" aria-haspopup="true" ' . $item_attr . '>';
                        if (isset($item['parent'])) {
                            echo '<span class="menu-link">';
                        } else {
                            $url = '#';
            
                            if (isset($item['page'])) {
                                $url = url($item['page']);
                            }
            
                            $target = '';
                            if (isset($item['new-tab']) && $item['new-tab'] == true) {
                                $target = 'target="_blank"';
                            }
            
                            echo '<a ' . $target . ' href="' . $url . '" class="menu-link ' . (isset($item['submenu']) ? 'menu-toggle' : '') . '">';
                        }
            
                        // Menu arrow
                        if (@$item['here'] === true) {
                            echo '<span class="menu-item-here"></span>';
                        }
            
                        // bullet
                        $bullet = '';
            
                        if ($parent != null && isset($parent['bullet']) && $parent['bullet'] == 'dot') {
                            $bullet = 'dot';
                        } elseif ($parent != null && isset($parent['bullet']) && $parent['bullet'] == 'line') {
                            $bullet = 'line';
                        }
            
                        // Menu icon OR bullet
                        if ($bullet == 'dot') {
                            echo '<i class="menu-bullet menu-bullet-dot"><span></span></i>';
                        } elseif ($bullet == 'line') {
                            echo '<i class="menu-bullet menu-bullet-line"><span></span></i>';
                        } elseif (config('layout.aside.menu.hide-root-icons') !== true && isset($item['icon']) && !empty($item['icon'])) {
                            self::renderIcon($item['icon'], isset($item['class-icon']) ? $item['class-icon'] : 'menu-icon');
                        }
            
                        // Badge
                        echo '<span class="menu-text">' . $item['title'] . '</span>';
                        if (isset($item['label'])) {
                            echo '<span class="menu-badge"><span class="label ' . $item['label']['type'] . '">' . $item['label']['value'] . '</span></span>';
                        }
            
                        if ($singleItem == true) {
                            if (isset($item['parent'])) {
                                echo '</span>';
                            } else {
                                echo '</a>';
                            }
            
                            echo '</li>';
                            return;
                        }
            
                        if (isset($item['submenu'])) {
                            if (isset($item['root']) == false && config('layout.menu.aside.submenu.arrow') == 'plus-minus') {
                                echo '<i class="menu-arrow menu-arrow-pm"><span><span></span></span></i>';
                            } elseif (isset($item['root']) == false && config('layout.menu.aside.submenu.arrow') == 'plus-minus-square') {
                                echo '<i class="menu-arrow menu-arrow-pm-square"><span><span></span></span></i>';
                            } elseif (isset($item['root']) == false && config('layout.menu.aside.submenu.arrow') == 'plus-minus-circle') {
                                echo '<i class="menu-arrow menu-arrow-pm-circle"><span><span></span></span></i>';
                            } else {
                                if (@$item['arrow'] !== false && config('layout.aside.menu.root-arrow') !== false) {
                                    echo '<i class="menu-arrow"></i>';
                                }
                            }
                        }
            
                        if (isset($item['parent'])) {
                            echo '</span>';
                        } else {
                            echo '</a>';
                        }
            
                        if (isset($item['submenu'])) {
                            $submenu_dir = '';
                            if (isset($item['submenu-up']) && $item['submenu-up'] === true) {
                                $submenu_dir = 'menu-submenu-up';
                            }
                            echo '<div class="menu-submenu ' . $submenu_dir . '">';
                            echo '<span class="menu-arrow"></span>';
            
                            if (isset($item['custom-class']) && ($item['custom-class'] === 'menu-item-submenu-stretch' || $item['custom-class'] === 'menu-item-submenu-scroll')) {
                                echo '<div class="menu-wrapper">';
                            }
            
                            if (isset($item['scroll'])) {
                                echo '<div class="menu-scroll" data-scroll="true" style="height: ' . $item['scroll'] . '">';
                            }
            
                            echo '<ul class="menu-subnav">';
                            if (isset($item['root'])) {
                                $parent_item = $item;
                                $parent_item['parent'] = true;
                                unset($parent_item['icon']);
                                unset($parent_item['submenu']);
                                self::renderVerMenu($parent_item, null, 0, true); // single item render
                            }
                            foreach ($item['submenu'] as $submenu_item) {
                                self::renderVerMenu($submenu_item, $item, 0);
                            }
                            echo '</ul>';
            
                            if (isset($item['scroll']) || isset($item['custom-class']) && $item['custom-class'] === 'menu-item-submenu-stretch') {
                                echo '</div>';
                            }
                            echo '</div>';
                        }
            
                        echo '</li>';
            }
        } else {
            foreach ($item as $each) {
                self::renderVerMenu($each, $parent, 0);
            }
        }   
    }

    /**
     * Header menu
     * @param $item
     * @param null $parent
     * @param int  $rec
     */
    public static function renderHorMenu($item, $parent = null, $rec = 0)
    {
        self::checkRecursion($rec);
        if (!$item) { return 'menu misconfiguration'; }

        // render separator
        if (isset($item['separator'])) {
            echo '<li class="menu-separator"><span></span></li>';
        } elseif (isset($item['title']) || isset($item['code'])) {
            $item_class = '';
            $item_attr = '';

            if (isset($item['submenu']) && self::isActiveHorMenuItem($item, request()->path())) {
                $item_class .= ' menu-item-open menu-item-here'; // m-menu__item--active

                if (@$item['submenu']['type'] == 'tabs') {
                    $item_class .= ' menu-item-active-tab ';
                }
            } elseif (self::isActiveHorMenuItem($item, request()->path())) {
                $item_class .= ' menu-item-active ';

                if (@$item['submenu']['type'] == 'tabs') {
                    $item_class .= ' menu-item-active-tab ';
                }
            }

            if (isset($item['submenu'])) {
                $item_class .= ' menu-item-submenu'; // m-menu__item--active

                if (isset($item['toggle']) && $item['toggle'] == 'click') {
                    $item_attr .= ' data-menu-toggle="click"';
                } elseif (@$item['submenu']['type'] == 'tabs') {
                    $item_attr .= ' data-menu-toggle="tab"';
                } else {
                    $item_attr .= ' data-menu-toggle="hover"';
                }
            }

            if (@$item['redirect'] === true) {
                $item_attr .= ' data-menu-redirect="1"';
            }

            if (isset($item['submenu'])) {
                if (!isset($item['submenu']['type'])) {
                    // default option
                    $item['submenu']['type'] = 'classic';
                    $item['submenu']['alignment'] = 'right';
                }
                if (($item['submenu']['type'] == 'classic') && isset($item['root'])) {
                    $item_class .= ' menu-item-rel';
                }

                if (($item['submenu']['type'] == 'mega') && isset($item['root']) && @$item['align'] != 'center') {
                    $item_class .= ' menu-item-rel';
                }

                if ($item['submenu']['type'] == 'tabs') {
                    $item_class .= ' menu-item-tabs';
                }
            }

            if (isset($item['submenu']['items']) && self::isActiveHorMenuItem($item['submenu'], request()->path())) {
                $item_class .= ' menu-item-open menu-item-here'; // m-menu__item--active
            }

            if (isset($item['custom-class'])) {
                $item_class .= ' ' . $item['custom-class'];
            }

            if (@$item['icon-only'] == true) {
                $item_class .= ' menu-item-icon-only';
            }

            if (isset($item['heading']) == false) {
                echo '<li class="menu-item ' . $item_class . '" ' . $item_attr .  ' aria-haspopup="true">';
            }

            // check if code is provided instead of link
            if (isset($item['code'])) {
                echo $item['code'];
            } else {
                // insert title or heading
                if (isset($item['heading']) == false) {
                    $url = '#';

                    if (isset($item['page'])) {
                        $url = url($item['page']);
                    }

                    $target = '';
                    if (isset($item['new-tab']) && $item['new-tab'] == true) {
                        $target = 'target="_blank"';
                    }

                    echo '<a '.$target.' href="'.$url.'" class="menu-link '.(isset($item['submenu']) ? 'menu-toggle' : '') .' '.(isset($item['class']) ? $item['class'] : '').'">';
                } else {
                    echo '<h3 class="menu-heading menu-toggle">';
                }

                // put root level arrow
                if (@$item['here'] === true) {
                    echo '<span class="menu-item-here"></span>';
                }

                // bullet
                $bullet = '';

                if ((@$item['heading'] && @$item['bullet'] == 'dot') || @$parent['bullet'] == 'dot') {
                    $bullet = 'dot';
                } elseif ((@$item['heading'] && @$item['bullet'] == 'line') || @$parent['bullet'] == 'line') {
                    $bullet = 'line';
                }

                // Menu icon OR bullet
                if ($bullet == 'dot') {
                    echo '<i class="menu-bullet menu-bullet-dot"><span></span></i>';
                } elseif ($bullet == 'line') {
                    echo '<i class="menu-bullet menu-bullet-line"><span></span></i>';
                } elseif (isset($item['icon']) && !empty($item['icon'])) {
                    self::renderIcon($item['icon'], isset($item['class-icon']) ? $item['class-icon'] : 'menu-icon');
                }

                // Badge
                echo '<span class="menu-text">' . $item['title'] . '</span>';
                if (isset($item['label'])) {
                    echo '<span class="menu-badge"><span class="label ' . $item['label']['type'] . '">' . $item['label']['value'] . '</span></span>';
                }
                // Arrow
                if (isset($item['submenu']) && (!isset($item['arrow']) || $item['arrow'] != false)) {
                    // root down arrow
                    if (isset($item['root'])) {
                        // enable/disable root arrow
                        if (config('layout.header.menu.self.root-arrow') !== false) {
                            echo '<i class="menu-hor-arrow"></i>';
                        };
                    } else {
                        // inner menu arrow
                        echo '<i class="menu-hor-arrow"></i>';
                    }
                    echo '<i class="menu-arrow"></i>';
                }

                // closing title or heading
                if (isset($item['heading']) == false) {
                    echo '</a>';
                } else {
                    echo '<i class="menu-arrow"></i></h3>';
                }

                if (isset($item['submenu'])) {
                    if (in_array($item['submenu']['type'], array('classic', 'tabs'))) {
                        if (isset($item['submenu']['alignment'])) {
                            $submenu_class = ' menu-submenu-' . $item['submenu']['alignment'];

                            if (isset($item['submenu']['pull']) && $item['submenu']['pull'] == true) {
                                $submenu_class .= ' menu-submenu-pull';
                            }
                        }

                        if ($item['submenu']['type'] == 'tabs') {
                            $submenu_class .= ' menu-submenu-tabs';
                        }

                        echo '<div class="menu-submenu menu-submenu-classic' . $submenu_class . '">';

                        echo '<ul class="menu-subnav">';
                        $items = array();
                        if (isset($item['submenu']['items'])) {
                            $items = $item['submenu']['items'];
                        } else {
                            if($item['title'] == "Naskah Dinas") {
                            echo '<li class="menu-item">
                                <div class="quick-search quick-search-dropdown" id="cari-menu">
                                    <form method="get" class="quick-search-form">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <span class="svg-icon svg-icon-lg">
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                                <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                                <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Cari Nota Dinas...">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="quick-search-close ki ki-close icon-sm text-muted" style="display: none;"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </li><hr />';
                            }
                            $items = $item['submenu'];
                        }
                        foreach ($items as $submenu_item) {
                            self::renderHorMenu($submenu_item, $item, $rec++);
                        }
                        echo '</ul>';
                        echo '</div>';
                    } elseif ($item['submenu']['type'] == 'mega') {
                        $submenu_fixed_width = '';

                        if (intval(@$item['submenu']['width']) > 0) {
                            $submenu_class = ' menu-submenu-fixed';
                            $submenu_fixed_width = 'style="width:' . $item['submenu']['width'] . '"';
                        } else {
                            $submenu_class = ' menu-submenu-' . $item['submenu']['width'];
                        }

                        if (isset($item['submenu']['alignment'])) {
                            $submenu_class .= ' menu-submenu-' . $item['submenu']['alignment'];

                            if (isset($item['submenu']['pull']) && $item['submenu']['pull'] == true) {
                                $submenu_class .= ' menu-submenu-pull';
                            }
                        }

                        echo '<div class="menu-submenu ' . $submenu_class  . '" ' . ($submenu_fixed_width) . '>';

                        echo '<div class="menu-subnav">';
                        echo '<ul class="menu-content">';
                        foreach ($item['submenu']['columns'] as $column) {
                            $item_class = '';
                            // mega menu column header active
                            if (isset($column['items']) && self::isActiveVerMenuItem($column, request()->path())) {
                                $item_class .= ' menu-item-open menu-item-here'; // m-menu__item--active
                            }

                            echo '<li class="menu-item '.$item_class.'">';
                            if (isset($column['heading'])) {
                                self::renderHorMenu($column['heading'], null, $rec++);
                            }
                            echo '<ul class="menu-inner">';
                            foreach ($column['items'] as $column_submenu_item) {
                                self::renderHorMenu($column_submenu_item, $column, $rec++);
                            }
                            echo '</ul>';
                            echo '</li>';
                        }
                        echo '</ul>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
            }

            if (isset($item['heading']) == false) {
                echo '</li>';
            }
        } elseif (is_array($item)) {
            foreach ($item as $each) {
                self::renderHorMenu($each, $parent, $rec++);
            }
        }
    }

    // Check for active Vertical Menu item
    public static function isActiveVerMenuItem($item, $page, $rec = 0)
    {
        if (@$item['redirect'] === true) {
            return false;
        }

        self::checkRecursion($rec);

        if (isset($item['page']) && $item['page'] == $page) {
            return true;
        }

        if (is_array($item)) {
            foreach ($item as $each) {
                if (self::isActiveVerMenuItem($each, $page, $rec++)) {
                    return true;
                }
            }
        }

        return false;
    }

    // Check for active Horizontal Menu item
    public static function isActiveHorMenuItem($item, $page, $rec = 0)
    {
        if (@$item['redirect'] === true) {
            return false;
        }

        self::checkRecursion($rec);

        if (isset($item['page']) && $item['page'] == $page) {
            return true;
        }

        if (is_array($item)) {
            foreach ($item as $each) {
                if (self::isActiveHorMenuItem($each, $page, $rec++)) {
                    return true;
                }
            }
        }

        return false;
    }

    // Checks recursion depth
    public static function checkRecursion($rec, $max = 10000)
    {
        if ($rec > $max) {
            echo 'Too many recursions!!!';
            exit;
        }
    }

    // Render icon or bullet
    public static function renderIcon($icon, $class)
    {

        if (Metronic::isSVG($icon)) {
            echo Metronic::getSVG($icon,  $class);
        } else {
            echo '<i class="menu-icon '.$icon.'"></i>';
        }

    }

    public static function getMenu()
    {
        $parent_menu = DB::table('menu')
                    ->select('id','is_section','title','bullet','icon','has_submenu','page')
                    ->where('parent_id', '=', 0)
                    ->where('is_active', '=', 1)
                    ->orderBy('order', 'asc')
                    ->orderBy('id', 'asc')
                    ->get()->toArray();
        foreach($parent_menu as $key => $item) {
            $parent_menu[$key] = array();
            if($item->has_submenu == 1) {
                foreach($item as $index => $val) {
                    $parent_menu[$key][$index] = $val;
                }
                $parent_menu[$key]['submenu'] = array();
                $submenu = DB::table('menu')->where('parent_id', '=', $item->id)->orderBy('order', 'asc')->get();
                foreach($submenu as $row => $value) {
                    $parent_menu[$key]['submenu'][$row]['title'] = $value->title;
                    // if($value->bullet === 'dot') {
                    //     $parent_menu[$key]['submenu'][$row]['bullet'] = $value->bullet;
                    // }
                    $parent_menu[$key]['submenu'][$row]['page'] = $value->page;
                    $parent_menu[$key]['submenu'][$row]['icon'] = $value->icon;
                }
            } else {
                if($item->bullet === 'dot') {
                    $parent_menu[$key]['bullet'] = $item->bullet;
                }
                if($item->is_section == 1) {
                    $parent_menu[$key]['section'] = $item->title;
                    // $arrMenu['section'] = $item->title; 
                }
                foreach($item as $index => $val) {
                    $parent_menu[$key][$index] = $val;
                }
            }
        }
        return $parent_menu;
    }

    public static function hasPermission($permission)
    {
        $roles = Session::get('role_id');
        $result = RolePermission::with('permission', 'roles')
                ->where('role_id', $roles)
                ->whereHas('permission', function($q) use ($permission) {
                    $q->where('permission_name', $permission);
                })
                ->get();
        
        if(!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    public static function hasSectionPermission($permission)
    {
        $roles = Session::get('role_id');
        
        $result = RolePermission::with('permission', 'roles')
                ->where('role_id', $roles)
                ->whereHas('permission', function($q) use ($permission) {
                    $q->where('permission_name', $permission);
                })
                ->get();
        
        if(!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    public static function canAdd($moduleName)
    {
        $roles = Session::get('role_id');
        $permission = 'menu-'.$moduleName.'-create';
        $result = RolePermission::with('permission', 'roles')
                ->where('role_id', $roles)
                ->whereHas('permission', function($q) use ($permission) {
                    $q->where('permission_name', $permission);
                })
                ->get();
        if(count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function canEdit($moduleName)
    {
        $roles = Session::get('role_id');
        $permission = 'menu-'.$moduleName.'-edit';
        $result = RolePermission::with('permission', 'roles')
                ->where('role_id', $roles)
                ->whereHas('permission', function($q) use ($permission) {
                    $q->where('permission_name', $permission);
                })
                ->get();
        if(count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function canDelete($moduleName)
    {
        $roles = Session::get('role_id');
        $permission = 'menu-'.$moduleName.'-delete';
        $result = RolePermission::with('permission', 'roles')
                ->where('role_id', $roles)
                ->whereHas('permission', function($q) use ($permission) {
                    $q->where('permission_name', $permission);
                })
                ->get();
        if(count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

}
