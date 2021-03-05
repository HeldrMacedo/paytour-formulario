<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCurriculoRequest;
use App\Models\Curriculo;
use Illuminate\Support\Facades\Http;


class EventController extends Controller
{
    
    /**
     * Método que recebe os dados do formulário
     * 
     */
    public function store(StoreCurriculoRequest $request)
    {
        $array_dados    =  $this->saveFile($request);        
        $ip             = $this->getIp();

        
        $curriculo = new Curriculo;
        $curriculo->nome            = $request->nome;
        $curriculo->email           = $request->email;
        $curriculo->telefone        = $request->telefone;
        $curriculo->cargo           = $request->cargo;
        $curriculo->escolaridade    = $request->escolaridade;
        $curriculo->observacao      = $request->observacao ?? '';
        $curriculo->arquivo         = $array_dados['caminho'];
        $curriculo->ip              = $ip;
        $curriculo->save();

        $sendCurriculo = new SendCurriculo($curriculo, $array_dados['nameFile']);
        $sendCurriculo->sendMail();

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

    /**
     * Método para pegar o ip
     */
    public function getIp()
    {
        $response = Http::get('http://meuip.com/api/meuip.php');
        return $response->__toString();
    }
}
