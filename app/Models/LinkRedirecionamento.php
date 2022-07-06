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

    public static function createLinkRedirecionamento($filters, $link_gerado_id)
    {
        $link_redirecionamento = new LinkRedirecionamento();
        $link_redirecionamento->link = $filters['link_redirecionamento'];
        $link_redirecionamento->acesso_maximo = (int)$filters['acesso_maximo'] ?? null;
        $link_redirecionamento->acessto_atual = 0;
        $link_redirecionamento->data_validade = $filters['data_validade'] ?? Carbon::createFromDate('1900','01', '01');
        $link_redirecionamento->link_default = $filters['link_default']  == 'true' ? true : false;
        $link_redirecionamento->link_gerado_id = $link_gerado_id;
        $link_redirecionamento->save();

        return $link_redirecionamento;

    }
}
