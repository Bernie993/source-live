<?php

namespace App\View\Composers;

use App\Models\Menu;
use Illuminate\View\View;

class MenuComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // Get active header menus
        $headerMenus = Menu::active()
            ->header()
            ->ordered()
            ->get();

        // Get active footer menus
        $footerMenus = Menu::active()
            ->footer()
            ->ordered()
            ->get();

        $view->with([
            'headerMenus' => $headerMenus,
            'footerMenus' => $footerMenus,
        ]);
    }
}


