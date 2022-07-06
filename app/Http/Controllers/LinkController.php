<?php

namespace App\Http\Controllers;

use App\Models\LinkGerado;
use App\Models\LinkRedirecionamento;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    private $link_gerado, $link_redirecionamento;

    public function __construct(LinkGerado $link_gerado, LinkRedirecionamento $link_redirecionamento)
    {
        $this->link_gerado = $link_gerado;
        $this->link_redirecionamento = $link_redirecionamento;
    }

    public function create(Request $request)
    {
        try {
            $filters = $request->only(['nome']);
            return $this->link_gerado->createLink($filters);
        } catch (\Throwable $exception) {
            response($exception->getMessage(), 500);
        }
    }

    public function createLinkRedirect(Request $request)
    {
        try {
            $filters = $request->only(['link', 'acesso_maximo',
                'link_default', 'link_gerado_id', 'data_validade']);
            return $this->link_redirecionamento->createLinkRedirecionamento($filters);
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

    public function editLinkRedirecionamento(Request $request)
    {
        try {
            return $this->link_redirecionamento->editLinkRedirect($request);
        } catch (\Throwable $exception) {
            dd($exception);
            response($exception->getMessage(), 500);
        }
    }
}
