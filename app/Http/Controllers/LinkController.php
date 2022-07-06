<?php

namespace App\Http\Controllers;

use App\Models\LinkGerado;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    private $link_gerado;

    public function __construct(LinkGerado $link_gerado)
    {
        $this->link_gerado = $link_gerado;
    }

    public function create(Request $request)
    {
        try {
            $filters = $request->only(['nome', 'link_redirecionamento', 'acesso_maximo',
                'data_validade', 'link_default']);

            return $this->link_gerado->createLink($filters);
        } catch (\Throwable $exception) {
            response($exception->getMessage(), 500);
        }
    }

    public function editLinkGerado(Request $request)
    {
        try {
            return $this->link_gerado->editLink($request);
        } catch (\Throwable $exception) {
            response($exception->getMessage(), 500);
        }
    }
}
