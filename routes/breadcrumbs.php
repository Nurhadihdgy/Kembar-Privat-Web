<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as Trail;


// Artikel Index
if (! app()->bound('breadcrumbs.generated.artikel')) {
    Breadcrumbs::for('artikel.index', function (Trail $trail) {
        $trail->parent('home');
        $trail->push('Artikel', route('artikel.index'));
    });

    Breadcrumbs::for('artikel.show', function (Trail $trail, $artikel) {
        $trail->parent('artikel.index');
        $trail->push($artikel->judul, route('artikel.show', $artikel->slug));
    });

    app()->instance('breadcrumbs.generated.artikel', true);
}
