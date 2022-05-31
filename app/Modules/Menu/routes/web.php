<?php

Route::group(['module' => 'Menu', 'middleware' => ['web'], 'namespace' => 'App\Modules\Menu\Controllers'], function() {

    /**
     * Read route:resource docs on laravel docs website
     * resourceController has common route and actions:
     * Index: {
     *  type: GET,
     *  URI: /menu,
     *  Action (Controller): index,
     *  Route Name: menu.index
     * },
     * Create: {
     *  type: GET,
     *  URI: /menu/create,
     *  Action (Controller): create,
     *  Route Name: menu.create
     * },
     * Store: {
     *  type: POST,
     *  URI: /menu,
     *  Action (Controller): store,
     *  Route Name: menu.store
     * },
     * Show: {
     *  type: GET,
     *  URI: /menu/{id},
     *  Action (Controller): show,
     *  Route Name: menu.show
     * },
     * Edit: {
     *  type: GET,
     *  URI: /menu/{id}/edit,
     *  Action (Controller): edit,
     *  Route Name: menu.edit
     * },
     * Update: {
     *  type: PUT/PATCH,
     *  URI: /menu/{id},
     *  Action (Controller): update,
     *  Route Name: menu.update
     * },
     * Destroy: {
     *  type: DELETE,
     *  URI: /menu/{id},
     *  Action (Controller): destroy,
     *  Route Name: menu.destroy
     * },
     */
    Route::resource('menu', 'MenuController');

});
