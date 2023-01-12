<?php

namespace Modules\Product\Http\Middleware;

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
        \Menu::make('admin_sidebar', function ($menu) {

            // Articles Dropdown
            $articles_menu = $menu->add('<i class="nav-icon fa fa-shopping-bag"></i> '.__('Products'), [
                'class' => 'nav-group',
            ])
            ->data([
                'order'         => 100,
                'activematches' => [
                    'admin/product*',
                ],
                'permission' => [],
            ]);
            $articles_menu->link->attr([
                'class' => 'nav-link nav-group-toggle',
                'href'  => '#',
            ]);

            // Submenu: Posts
            // $articles_menu->add('<i class="nav-icon fas fa fa-shopping-bag"></i> '.__('Product'), [
            //     'route' => 'backend.posts.index',
            //     'class' => 'nav-item',
            // ])
            // ->data([
            //     'order'         => 82,
            //     'activematches' => 'admin/posts*',
            //     'permission'    => ['edit_posts'],
            // ])
            // ->link->attr([
            //     'class' => 'nav-link',
            // ]);
            //Submenu: Products
            $articles_menu->add('<i class="nav-icon fa fa-shopping-bag"></i> '.__('Products'), [
                'route' => 'backend.product.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 101,
                'activematches' => 'admin/product*',
                'permission'    => [],
            ])
            ->link->attr([
                'class' => 'nav-link',
            ]);
            // Submenu: Categories
            $articles_menu->add('<i class="nav-icon fas fa-sitemap"></i> '.__('Categories'), [
                'route' => 'backend.product.category.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 101,
                'activematches' => 'admin/product/category*',
                'permission'    => [],
            ])
            ->link->attr([
                'class' => 'nav-link',
            ]);
        })->sortBy('order');

        return $next($request);
    }
}
