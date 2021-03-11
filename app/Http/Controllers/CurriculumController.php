<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCurriculoRequest;
use App\Jobs\SendCurriculo;
use App\Models\Curriculo;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;


class CurriculumController extends Controller
{
    
    /**
     * Método que recebe os dados do formulário
     * 
     */
    public function store(StoreCurriculoRequest $request)
    {
        $array_dados    =  $this->saveFile($request);

        
        $curriculo = new Curriculo();
        $curriculo->fill($request->all());
        $curriculo->ip          = $request->ip();
        $curriculo->arquivo     = $array_dados['caminho'];
        $curriculo->save();

        \App\Jobs\SendCurriculo::dispatch($curriculo, $array_dados['nameFile'])->delay(now()->addSeconds(2));

        return redirect('/')->with('success', 'Currículo enviado com sucesso!');
    }


    /**
     * Método para guardar o anexo na pasta currículo
     */
    public function saveFile($request)
    {
        $nameFile   = md5(time().rand(0, 1000)).'.'.$request->arquivo->extension();
        $caminho    = 'app/storage/app/curriculo/'.$nameFile;
        $request->file('arquivo')->storeAs('curriculo', $nameFile);
        
        $array_dados_arquivo = ['nameFile' => $nameFile, 'caminho' => $caminho];
        
        return $array_dados_arquivo;
    }

}
