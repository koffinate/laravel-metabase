<?php

namespace Koffinate\Metabase\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

class EmbedController extends Controller
{
    /**
     * @param  int  $id
     * @param  array<string>  $params
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(int $id, array $params = []): View
    {
        return view('metabase::embed.show', compact('id', 'params'));
    }
}
