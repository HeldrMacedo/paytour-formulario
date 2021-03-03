<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCurriculoRequest;
use Illuminate\Http\Request;

use App\Models\Curriculo;
use Illuminate\Support\Facades\Http;
use Mail;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail as FacadesMail;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    
    /**
     * Método que recebe os dados do formulário
     * 
     */
    public function store(StoreCurriculoRequest $request)
    {
        $nameFile = md5(time().rand(0, 1000)).'.'.$request->arquivo->extension();
        $caminho = 'app/storage/app/curriculo/'.$nameFile;
        $request->file('arquivo')->storeAs('curriculo', $nameFile);
        
        $ip = $this->getIp();

        //dd(storage_path('app/curriculo/'.$nameFile));
        
        $curriculo = new Curriculo;
        $curriculo->nome            = $request->nome;
        $curriculo->email           = $request->email;
        $curriculo->telefone        = $request->telefone;
        $curriculo->cargo           = $request->cargo;
        $curriculo->escolaridade    = $request->escolaridade;
        $curriculo->observacao      = $request->observacao ?? '';
        $curriculo->arquivo         = $caminho;
        $curriculo->ip              = $ip;
        $curriculo->save();
        
        $this->sendMail($curriculo, $nameFile);
        return redirect('/')->with('success', 'Currículo enviado com sucesso!');
    }


    /**
     * Método para enviar email
     */

    public function sendMail($dadosCurriculo, $nameFile)
    {
        $data = array(
            'nome'          => $dadosCurriculo->nome,
            'email'         => $dadosCurriculo->email,
            'telefone'      => $dadosCurriculo->telefone,
            'cargo'         => $dadosCurriculo->cargo,
            'escolaridade'  => $dadosCurriculo->escolaridade,
            'observacao'    => $dadosCurriculo->observacao,
            'ip'            => $dadosCurriculo->ip,
            'nameFile'      => $nameFile 
        );

        FacadesMail::to( config('mail.from.address'))
            ->send( new SendMail($data));
        
        
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
