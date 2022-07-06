<?php

namespace App\Models;

use Carbon\Carbon;
use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\This;

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
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $link_random = (string)rand(111111, 999999);
        $link_gerado = new LinkGerado();
        $link_gerado->nome = $filters['nome'];
        $link_gerado->link_gerado = 'http://localhost:8080/api/'.$link_random;
        $link_gerado->valido = true;
        $link_gerado->save();

        return response($dataRest = [
            'message' => 'Link criado com sucesso',
            'nome_link' => $filters['nome'],
            'link_gerado' => 'http://localhost:8080/api/'.$link_random,
            'ativo' => $link_gerado->valido
        ], 200);
    }

    public function editLink($request)
    {
        $link = self::where('link_gerado.id', $request->id)->first();

        if (is_null($link)) {
            return response('Link não encontrado, tente um id válido', 500);
        }

        $link->nome = $request->nome;
        $link->valido = $request->ativo;
        $link->save();

        return  response($link, 200);
    }
}
