<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ArquivoTipo implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $types = ['doc', 'docx', 'pdf'];

        return in_array($value->extension(), $types);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Somente arquivos com as extensões: .doc, .docx ou .pdf .';
    }
}
