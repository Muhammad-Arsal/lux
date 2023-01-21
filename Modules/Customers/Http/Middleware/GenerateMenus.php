<?php

namespace Modules\Customers\Http\Middleware;

use Closure;

class GenerateMenus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*
         *
         * Module Menu for Admin Backend
         *
         * *********************************************************************
         */
        \Menu::make('admin_sidebar', function ($menu) {

            // comments
            $menu->add('<i class="nav-icon fas fa-comments"></i> Customers', [
                'route' => 'backend.customer.view',
                'class' => 'nav-item',
            ])
                ->data([
                    'order'         => 101,
                    'activematches' => ['admin/customers*'],
                    'permission'    => [],
                ])
                ->link->attr([
                    'class' => 'nav-link',
                ]);
        })->sortBy('order');

        return $next($request);
    }
}
