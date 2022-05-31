<?php

use App\Models\Menu;

/**
 *	Menu Helper
 */
function getListMenu($selected="") {
    $html = "<select class='parent_id form-control' id='parent_id' name='parent_id'>";
    $data = Menu::where('is_section', '=', 0)->where('parent_id', '=', 0)->get();
    foreach($data as $key => $value) {
        $isSel = ($value->parent_id == $selected)?'selected':'';
        $html.= "<option value='".$value->id."'>".$value->title."</option>";
    }
    $html.= "</select>";
    return $html;
 }