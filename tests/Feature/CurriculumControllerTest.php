<?php

namespace Tests\Feature;


use App\Mail\SendCurriculoNotification;
use App\Models\Curriculo;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CurriculumControllerTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSubmittingFormSendsEmailAndSavesOnDataBase()
    {  
        
        Mail::fake();
        Storage::fake();

        $file = UploadedFile::fake()->create('document.pdf', 500);
        
        $formData = [
            'nome'  => 'Helder Macedo',
            'email' => 'heldr.macedo@gmail.com',
            'telefone' => '(84) 999999999',
            'cargo' => 'programador',
            'escolaridade' => 'Superior Completo',
            'observacao' => 'teste',
            'arquivo' => $file
        ];
        
        $this->post('/enviar', $formData)
            ->assertRedirect('/')
            ->assertSessionHas('success','Currículo enviado com sucesso!');


        $curriculo = Curriculo::first();
            
        
        Mail::to(config('mail.from.address'))->send(new SendCurriculoNotification(['nameFile' => 'teste']));

        Mail::assertSent(SendCurriculoNotification::class);
        
        
        $this->assertTrue(Storage::disk()->exists($curriculo->arquivo));
        
    }

    /**
     * @test
     * @dataProvider allowedDataDataProvider
     */
    public function validationFormData ($formData, $field)
    {
        $this->post('/enviar', $formData)
                        ->assertSessionHasErrors([$field]);
    }

    public function allowedDataDataProvider()
    {
        $file = UploadedFile::fake()->create('document.pdf', 500, 'application/pdf');
        return [
            'shouldNotSendTheName' => [
                'formData' => [
                    'nome' => '',
                    'email' => 'heldr.macedo@gmail.com',
                    'telefone' => '(84) 999999999',
                    'cargo' => 'programador',
                    'escolaridade' => 'Superior Completo',
                    'observacao' => 'teste',
                    'arquivo' => $file
                ],
                'field' => 'nome'              
            ],
            'shouldNotSendTheMail' => [
                'formData' => [
                    'nome' => 'Helder Macedo',
                    'email' => '',
                    'telefone' => '(84) 999999999',
                    'cargo' => 'programador',
                    'escolaridade' => 'Superior Completo',
                    'observacao' => 'teste',
                    'arquivo' => $file
                ],
                'field' => 'email'
            ],
            'shouldNotSendThePhone' => [
                'formData' => [
                    'nome' => 'Helder Macedo',
                    'email' => 'heldr.macedo@gmail.com',
                    'telefone' => '',
                    'cargo' => 'programador',
                    'escolaridade' => 'Superior Completo',
                    'observacao' => 'teste',
                    'arquivo' => $file
                ],
                'field' => 'telefone'
            ],
            'shouldNotSendTheDesiredJobTitle' => [
                'formData' => [
                    'nome' => 'Helder Macedo',
                    'email' => 'heldr.macedo@gmail.com',
                    'telefone' => '(84) 999999999',
                    'cargo' => '',
                    'escolaridade' => 'Superior Completo',
                    'observacao' => 'teste',
                    'arquivo' => $file
                ],
                'field' => 'cargo'
            ],
            'shouldNotSendTheSchooling' => [
                'formData' => [
                    'nome' => 'Helder Macedo',
                    'email' => 'heldr.macedo@gmail.com',
                    'telefone' => '(84) 999999999',
                    'cargo' => 'programador',
                    'escolaridade' => '',
                    'observacao' => 'teste',
                    'arquivo' => $file
                ],
                'field' => 'escolaridade'
            ],
            'shouldNotSendTheFileAndSholdWidthoutObservation' => [
                'formData' => [
                    'nome' => 'Helder Macedo',
                    'email' => 'heldr.macedo@gmail.com',
                    'telefone' => '(84) 999999999',
                    'cargo' => 'programador',
                    'escolaridade' => 'Superior Completo',
                    'observacao' => '',
                    'arquivo' => ''
                ],
                'field' => 'arquivo'
            ]
            
        ];
    }

    /**
     * @test
     * @dataProvider notAllowedFile
     */
    public function validationTypeFileAndNotAllowed($file){
        
        $formData = [
            'nome'  => 'Helder Macedo',
            'email' => 'heldr.macedo@gmail.com',
            'telefone' => '(84) 999999999',
            'cargo' => 'programador',
            'escolaridade' => 'Superior Completo',
            'observacao' => 'teste',
            'arquivo' => $file
        ];
        
        $this->post('/enviar',$formData)->assertSessionHasErrors();
        
    }

    public function notAllowedFile(){
        $files = [
            'filePdf'   => UploadedFile::fake()->create('document.pdf', 10500),
            'fileTxt'   => UploadedFile::fake()->create('document.txt', 500),
            'fileXml'   => UploadedFile::fake()->create('document.xml', 500)
        ];

        return [
            'shouldNotAllowedTxtFile' => [
                'file'  => $files['fileTxt']
                ],
            'shouldNotAllowedXmlFile' => [
                'file'  => $files['fileXml'] 
                ]
            ];
    }

    /**
     * @test
     * @dataProvider allowedFile
     */
    public function validationTypeFileAndAllowed($file){
        $formData = [
            'nome'  => 'Helder Macedo',
            'email' => 'heldr.macedo@gmail.com',
            'telefone' => '(84) 999999999',
            'cargo' => 'programador',
            'escolaridade' => 'Superior Completo',
            'observacao' => 'teste',
            'arquivo' => $file
        ];

        $this->post('/enviar',$formData)->assertSessionHasNoErrors();
    }

    public function allowedFile(){
        $files = [
            'filePdf'   => UploadedFile::fake()->create('document.pdf', 500),
            'fileDoc'   => UploadedFile::fake()->create('document.doc', 500),
            'fileDocx'  => UploadedFile::fake()->create('document.docx', 500)
        ];

        return [
            'shouldAllowedPdfFile' => [
                'file' => $files['filePdf']
            ],
            'shouldAllowedDocFile' => [
                'file' => $files['fileDoc']
            ],
            'shouldAllowedDocxFile' => [
                'file' => $files['fileDocx']
            ]
        ];


    }
}
