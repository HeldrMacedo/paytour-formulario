<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\Curriculo;
use Illuminate\Support\Facades\Mail as FacadesMail;

class SendCurriculo extends Controller
{
    private $nome;
    private $email;
    private $telefone;
    private $cargo;
    private $escolaridade;
    private $observacao;
    private $ip;
    private $nameFile;

   
    public function __construct(Curriculo $curriculo, $nameFile)
    {
        $this->nome         = $curriculo->nome;         
        $this->email        = $curriculo->email;
        $this->telefone     = $curriculo->telefone;
        $this->cargo        = $curriculo->cargo;
        $this->escolaridade = $curriculo->escolaridade;
        $this->observacao   = $curriculo->observacao;
        $this->ip           = $curriculo->ip;
        $this->nameFile     = $nameFile;
    }

     /**
     * Método para enviar email
     */

    public function sendMail()
    {
        $data = array(
            'nome'          => $this->nome,
            'email'         => $this->email,
            'telefone'      => $this->telefone,
            'cargo'         => $this->cargo,
            'escolaridade'  => $this->escolaridade,
            'observacao'    => $this->observacao,
            'ip'            => $this->ip,
            'nameFile'      => $this->nameFile 
        );

        $enviarEmail = new SendMail($data);

        FacadesMail::to( config('mail.from.address'))
            ->send( $enviarEmail );
        
        
    }
}
