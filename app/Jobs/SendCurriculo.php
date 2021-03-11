<?php

namespace App\Jobs;

use App\Mail\SendCurriculoNotification;
use App\Models\Curriculo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail as FacadesMail;

class SendCurriculo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
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

        $enviarEmail = new SendCurriculoNotification($data);

        FacadesMail::to( 'helder.macedo@outlook.com')
            ->send( $enviarEmail );
    }
}
