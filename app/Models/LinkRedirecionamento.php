<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LinkRedirecionamento extends Model
{
    public $timestamps = false;

    protected $table = 'link_redirecionamento';

    protected $fillable = [
        'link', 'acesso_maximo', 'acessto_atual', 'data_validade', 'link_default', 'link_gerado_id'
    ];

    public static function createLinkRedirecionamento($filters)
    {
        $filters['link_default'] == 'true' ? $filters['link_default'] = true : $filters['link_default'] = false;
        if (!!$filters['link_default']) {
            $date = date('Y-m-d');
            $link_default = self::join('link_gerado', 'link_redirecionamento.link_gerado_id', 'link_gerado.id')
                ->where('link_redirecionamento.link_gerado_id', $filters['link_gerado_id'])
                ->whereRaw("(link_redirecionamento.data_validade > '$date' OR link_redirecionamento.data_validade = '1900-01-01')")
                ->where('link_gerado.valido', 1)
                ->where('link_redirecionamento.link_default', 1)
                ->whereRaw('link_redirecionamento.acessto_atual < link_redirecionamento.acesso_maximo')
                ->first();


            if ($link_default) {
                return response('Um link default já está cadastrado e válido! Para cadastrar outro default, destive esse link.', 500);
            }

        }

        $link_existente = self::join('link_gerado', 'link_redirecionamento.link_gerado_id', 'link_gerado.id')
            ->where('link_redirecionamento.link_gerado_id', $filters['link_gerado_id'])
            ->where('link_redirecionamento.link',  (string)$filters['link'])
            ->first();


        if ($link_existente) {
            return response('Link já cadastrado.', 500) ;
        }

        $link_redirecionamento = new LinkRedirecionamento();
        $link_redirecionamento->link = $filters['link'];
        $link_redirecionamento->acesso_maximo = (int)$filters['acesso_maximo'] ?? null;
        $link_redirecionamento->acessto_atual = 0;
        $link_redirecionamento->data_validade = $filters['data_validade'] ?? Carbon::createFromDate('1900','01', '01');
        $link_redirecionamento->link_default = $filters['link_default'];
        $link_redirecionamento->link_gerado_id = $filters['link_gerado_id'];
        $link_redirecionamento->save();

        return $link_redirecionamento;

    }

    public function editLinkRedirect($request)
    {
        //acesso_maximo - acessto_atual
        //link_default - link_gerado_id - data_validade

        if ($request->default) {
            $link_default = self::join('link_gerado', 'link_redirecionamento.link_gerado_id', 'linkgerado.id')
                ->where('link_redirecionamento.link_gerado_id', $request->link_gerado_id)
                ->where('link_gerado.valido', 1)
                ->where('link_redirecionamento.link_default', 1)
                ->whereRaw('link_redirecionamento.acessto_atual < link_redirecionamento.acesso_maximo')
                ->first();

            return response('Existe um li');
        }

    }
}
