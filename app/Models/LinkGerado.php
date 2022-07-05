<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class LinkGerado extends Model
{
    public $timestamps = false;
    protected $table = 'link_gerado';

    protected $fillable = [
        'nome', 'link_gerado', 'valido'
    ];

    public function createLink($filters)
    {
        $validator = Validator::make($filters,
        [
            'nome' => 'required',
            'link_redirecionamento' => 'required',
            'acesso_maximo' => 'required'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $date = Carbon::now();
        $link_valido = self::join('link_redirecionamento', 'link_gerado.id', 'link_redirecionamento.link_gerado_id')
                ->where('link_redirecionamento.acessto_atual', '<', 'link_redirecionamento.acesso_maximo')
                ->whereRaw("link_redirecionamento.data_validade > $date OR link_redirecionamento.data_validade = null")
                ->where('link_gerado.valido', 1)
                ->dd();

        if ($link_valido) {
            return 'Um link default já está cadastrado';
        }

        $link_gerado = new LinkGerado();
        $link_gerado->nome = $filters['nome'];
        $link_gerado->link_gerado = (string)rand(111111, 999999);
        $link_gerado->valido = true;
        $link_gerado->save();

        $link_redirecionamento = LinkRedirecionamento::createLinkRedirecionamento($filters, $link_gerado->id);

        return 'ok';
    }
}
