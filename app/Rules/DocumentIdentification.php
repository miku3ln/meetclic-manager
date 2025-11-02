<?php


namespace App\Rules;

use App\Models\PeopleTypeIdentification;
use Illuminate\Contracts\Validation\Rule;
use App\Rules\ValidateIdentification;

class DocumentIdentification implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public $params = [];
    public $typeError = null;
    public $msj = '';
    const TYPE_IDENTIFICATION_RUC = 1;
    const TYPE_IDENTIFICATION_CARD = 2;//CEDULA
    const TYPE_IDENTIFICATION_OTHERS = 3;
    const TYPE_IDENTIFICATION_PASSPORT = 4;
    const TYPE_IDENTIFICATION_FINAL_CONSUMER = 5;
    const TYPE_IDENTIFICATION_PL = 6;
    public $validateModel = null;

    public function __construct($params)
    {
        $this->params = $params;

    }

    public function passes($attribute, $value)
    {
        $result = true;
        $keyCompare = 'people_type_identification_id';

        $typeIdentification = isset($this->params[$keyCompare])?$this->params[$keyCompare]:self::TYPE_IDENTIFICATION_CARD;

        if ($typeIdentification == self::TYPE_IDENTIFICATION_CARD) {
            $validador = new ValidateIdentification();
            $result = $validador->validarCedula($value);
            if (!$result) {
                $msj = $validador->getError();
                $this->msj = $msj;
            }
        }else if ($typeIdentification == self::TYPE_IDENTIFICATION_RUC) {
            $validador = new ValidateIdentification();
            $result = $validador->validarRucPersonaNatural($value);
            if (!$result) {
                $msj = $validador->getError();
                $this->msj = $msj;
            }
        }else if ($typeIdentification == PeopleTypeIdentification::TYPE_OTHERS_ID) {

        }
        return $result;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $msj = ':attribute ' . $this->msj;
        return $msj;
    }
}
