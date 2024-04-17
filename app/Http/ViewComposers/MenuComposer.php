<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Models\Menu;
use App\Models\User;
use App\Models\Submenu;

class MenuComposer
{
    
    public function compose(View $view)
    {
        if (!auth()->check()) {
            return false;
        }
        $usuario_id = auth()->user()->id;
        $usuario = User::where('id', $usuario_id)->first();

        $submenus_id = $usuario->permisos->pluck('sub_menus_id')->toArray();

        $menu = Menu::where('estado','1')->orderBy('nivel', 'asc')->get();
        $menuFilter = $menu->map(function($item, $key) use($submenus_id){
            
            $menu_id = \App\Models\Submenu::WhereIn('id',$submenus_id)->pluck('menus_id')->toArray();
            
            if(in_array($item->id, $menu_id)){

                $submenus = $item->submenus;
                $menu_permitido = new \stdClass();

                $submenu_permitidos = $submenus->map(function ($submenu, $submenu_key) use ($submenus_id) {
                    if(in_array($submenu->id, $submenus_id)){
                        return $submenu;
                    }
                });

                $menu_permitido->id = $item->id;
                $menu_permitido->nombre_menu = $item->nombre_menu;
                $menu_permitido->nivel = $item->nivel;
                $menu_permitido->icons = $item->icons;
                $menu_permitido->estado = $item->estado;
                $menu_permitido->submenus = $submenu_permitidos; // $submenu_permitidos;
                return $menu_permitido;
            }
        });
        $view->with('menu',$menuFilter);
    }

   
}
