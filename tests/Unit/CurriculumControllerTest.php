<?php

namespace Tests\Unit;

use App\Http\Controllers\CurriculumController;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use WithoutMiddleware;
class CurriculumControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        
        Storage::fake('app'); 

        $file = UploadedFile::fake()->create('document.pdf', 10000);
        $form = [
            'nome'  => 'Helder Macedo',
            'email' => 'telefone',
            'cargo' => 'programador',
            'escolaliridade' => 'Superior Completo',
            'observacao' => 'teste',
            'arquivo' => $file
        ];
        
        $request = new Request($form);

        $curriculo = new CurriculumController;
        $curriculo->saveFile($request);
        //Storage::disk('avatars')->assertExists('');

       
    }
}
