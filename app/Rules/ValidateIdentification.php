<?php

/**
 * MIT License
 * ===========
 *
 * Copyright (c) 2012 Ing. Mauricio Lopez <mlopez@dixian.info>
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
 * CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @package     ValidateIdentification
 * @subpackage
 * @author      Ing. Mauricio Lopez <mlopez@dixian.info>
 * @copyright   2012 Ing. Mauricio Lopez (diaspar)
 * @license     http://www.opensource.org/licenses/mit-license.php  MIT License
 * @link        http://www.dixian.info
 * @version     @@0.8@@
 */

/**
 * ValidateIdentification contiene metodos para validar cédula, RUC de persona natural, RUC de sociedad privada y
 * RUC de socieda pública en el Ecuador.
 *
 * Los métodos públicos para realizar validaciones son:
 *
 * validarCedula()
 * validarRucPersonaNatural()
 * validarRucSociedadPrivada()
 */
namespace App\Rules;

class ValidateIdentification
{

    public $someconfig = 'somedefault';

    /**
     * Error
     *
     * Contiene errores globales de la clase
     *
     * @var string
     * @access protected
     */
    protected $error = '';

    /**
     * Validar cédula
     *
     * @param string $numero Número de cédula
     *
     * @return Boolean
     */
    const tipo_identificacion_id_cedula = 1;
    const tipo_identificacion_id_ruc = 2;
    const tipo_identificacion_id_pasaporte = 3;
    const tipo_identificacion_id_cf = 4;
    const tipo_identificacion_id_placa = 5;
    const tipo_identificacion_id_sd = 6;

//------TIPOS DE RUC---
    const type_ruc_persona_natural = 1;
    const type_ruc_sociedad_privada = 2;
    const type_ruc_sociedad_publica = 3;
    const type_ruc_ninguna = 4;

    public function validarCedula($numero = '')
    {
        // fuerzo parametro de entrada a string
        $numero = (string)$numero;
        // borro por si acaso errores de llamadas anteriores.
        $this->setError('');
        // validaciones
        try {
            $resultManager = $this->validarInicial($numero, '10');
            if (!$resultManager['success']) {
                $this->setError($resultManager['msj']);
                return false;

            }
            $resultManager = $this->validarCodigoProvincia(substr($numero, 0, 2));
            if (!$resultManager['success']) {
                $this->setError($resultManager['msj']);
                return false;

            }
            $resultManager = $this->validarTercerDigito($numero[2], 'cedula');
            if (!$resultManager['success']) {
                $this->setError($resultManager['msj']);
                return false;

            }
            $resultManager = $this->algoritmoModulo10(substr($numero, 0, 9), $numero[9]);
            if (!$resultManager['success']) {
                $this->setError($resultManager['msj']);
                return false;

            }
        } catch (Exception $e) {

            $this->setError($e->getMessage());
            return false;
        }
        return true;
    }

    public function getDataTypeRuc()
    {
        $data_type_ruc = array();
        array_push($data_type_ruc, array("id" => 1, "text" => "Persona Natural"));
        array_push($data_type_ruc, array("id" => 2, "text" => "Sociedad Privada"));
        array_push($data_type_ruc, array("id" => 3, "text" => "Sociedad Pública"));
        return $data_type_ruc;
    }

    /**
     * Validar RUC persona natural
     *
     * @param string $numero Número de RUC persona natural
     *
     * @return Boolean
     */
    public function validarRucPersonaNatural($numero = '')
    {
        // fuerzo parametro de entrada a string
        $numero = (string)$numero;
        // borro por si acaso errores de llamadas anteriores.
        $this->setError('');
        // validaciones
        try {
            $resultManager = $this->validarInicial($numero, '13');
            if (!$resultManager['success']) {
                $this->setError($resultManager['msj']);
                return false;

            }
            $resultManager = $this->validarCodigoProvincia(substr($numero, 0, 2));
            if (!$resultManager['success']) {
                $this->setError($resultManager['msj']);
                return false;

            }
            $resultManager = $this->validarTercerDigito($numero[2], 'ruc_natural');
            if (!$resultManager['success']) {
                $this->setError($resultManager['msj']);
                return false;

            }
            $resultManager = $this->validarCodigoEstablecimiento(substr($numero, 10, 3));
            if (!$resultManager['success']) {
                $this->setError($resultManager['msj']);
                return false;

            }
            $resultManager = $this->algoritmoModulo10(substr($numero, 0, 9), $numero[9]);
            if (!$resultManager['success']) {
                $this->setError($resultManager['msj']);
                return false;

            }

        } catch (Exception $e) {
            $this->setError($e->getMessage());
            return false;
        }
        return true;
    }

    /**
     * Validar RUC sociedad privada
     *
     * @param string $numero Número de RUC sociedad privada
     *
     * @return Boolean
     */
    public function validarRucSociedadPrivada($numero = '')
    {
        // fuerzo parametro de entrada a string
        $numero = (string)$numero;
        // borro por si acaso errores de llamadas anteriores.
        $this->setError('');
        // validaciones
        try {
            $resultManager = $this->validarInicial($numero, '13');
            if (!$resultManager['success']) {
                $this->setError($resultManager['msj']);
                return false;

            }
            $resultManager = $this->validarCodigoProvincia(substr($numero, 0, 2));
            if (!$resultManager['success']) {
                $this->setError($resultManager['msj']);
                return false;

            }
            $resultManager = $this->validarTercerDigito($numero[2], 'ruc_privada');
            if (!$resultManager['success']) {
                $this->setError($resultManager['msj']);
                return false;

            }
            $resultManager = $this->validarCodigoEstablecimiento(substr($numero, 10, 3));
            if (!$resultManager['success']) {
                $this->setError($resultManager['msj']);
                return false;

            }
            $resultManager = $this->algoritmoModulo11(substr($numero, 0, 9), $numero[9], 'ruc_privada');
            if (!$resultManager['success']) {
                $this->setError($resultManager['msj']);
                return false;

            }
        } catch (Exception $e) {
            $this->setError($e->getMessage());
            return false;
        }
        return true;
    }

    /**
     * Validar RUC sociedad publica
     *
     * @param string $numero Número de RUC sociedad publica
     *
     * @return Boolean
     */
    public function validarRucSociedadPublica($numero = '')
    {
        // fuerzo parametro de entrada a string
        $numero = (string)$numero;
        // borro por si acaso errores de llamadas anteriores.
        $this->setError('');
        // validaciones
        try {
            $resultManager = $this->validarInicial($numero, '13');
            if (!$resultManager['success']) {
                $this->setError($resultManager['msj']);
                return false;

            }
            $resultManager = $this->validarCodigoProvincia(substr($numero, 0, 2));
            if (!$resultManager['success']) {
                $this->setError($resultManager['msj']);
                return false;

            }
            $resultManager = $this->validarTercerDigito($numero[2], 'ruc_publica');
            if (!$resultManager['success']) {
                $this->setError($resultManager['msj']);
                return false;

            }
            $resultManager = $this->validarCodigoEstablecimiento(substr($numero, 9, 4));
            if (!$resultManager['success']) {
                $this->setError($resultManager['msj']);
                return false;

            }
            $resultManager = $this->algoritmoModulo11(substr($numero, 0, 8), $numero[8], 'ruc_publica');
            if (!$resultManager['success']) {
                $this->setError($resultManager['msj']);
                return false;

            }
        } catch (Exception $e) {
            $this->setError($e->getMessage());
            return false;
        }
        return true;
    }

    /**
     * Validaciones iniciales para CI y RUC
     *
     * @param string $numero CI o RUC
     * @param integer $caracteres Cantidad de caracteres requeridos
     *
     * @return Boolean
     *
     * @throws exception Cuando valor esta vacio, cuando no es dígito y
     * cuando no tiene cantidad requerida de caracteres
     */
    protected function validarInicial($numero, $caracteres)
    {
        $success = true;
        $msj = '';
        if (empty($numero)) {
            $msj = ('Valor no puede estar vacio');
            $success = false;

        }
        if (!ctype_digit($numero)) {
            $success = false;
            $msj = ('Valor ingresado solo puede tener dígitos');

        }
        if (strlen($numero) != $caracteres) {
            $msj = ('Valor ingresado debe tener ' . $caracteres . ' caracteres');
            $success = false;

        }

        $result = [
            'success' => $success,
            'msj' => $msj
        ];
        return $result;
    }

    /**
     * Validación de código de provincia (dos primeros dígitos de CI/RUC)
     *
     * @param string $numero Dos primeros dígitos de CI/RUC
     *
     * @return boolean
     *
     * @throws exception Cuando el código de provincia no esta entre 00 y 24
     */
    protected function validarCodigoProvincia($numero)
    {
        $success = true;
        $msj = '';
        if ($numero < 0 OR $numero > 24) {
            $msj = ('Codigo de Provincia (dos primeros dígitos) no deben ser mayor a 24 ni menores a 0');
            $success = false;

        }

        $result = [
            'success' => $success,
            'msj' => $msj
        ];
        return $result;
    }

    /**
     * Validación de tercer dígito
     *
     * Permite validad el tercer dígito del documento. Dependiendo
     * del campo tipo (tipo de identificación) se realizan las validaciones.
     * Los posibles valores del campo tipo son: cedula, ruc_natural, ruc_privada
     *
     * Para Cédulas y RUC de personas naturales el terder dígito debe
     * estar entre 0 y 5 (0,1,2,3,4,5)
     *
     * Para RUC de sociedades privadas el terder dígito debe ser
     * igual a 9.
     *
     * Para RUC de sociedades públicas el terder dígito debe ser
     * igual a 6.
     *
     * @param string $numero tercer dígito de CI/RUC
     * @param string $tipo tipo de identificador
     *
     * @return boolean
     *
     * @throws exception Cuando el tercer digito no es válido. El mensaje
     * de error depende del tipo de Idenficiación.
     */
    protected function validarTercerDigito($numero, $tipo)
    {
        $success = true;
        $msj = '';

        switch ($tipo) {
            case 'cedula':
            case 'ruc_natural':
                if ($numero < 0 OR $numero > 5) {
                    $success = false;
                    $msj = ('Tercer dígito debe ser mayor o igual a 0 y menor a 6 para cédulas y RUC de persona natural');
                }
                break;
            case 'ruc_privada':
                if ($numero != 9) {
                    $success = false;
                    $msj = ('Tercer dígito debe ser igual a 9 para sociedades privadas');
                }
                break;
            case 'ruc_publica':
                if ($numero != 6) {
                    $success = false;
                    $msj = ('Tercer dígito debe ser igual a 6 para sociedades públicas');
                }
                break;
            default:
                $success = false;
                $msj = ('Tipo de Identificación no existe.');
                break;
        }

        $result = [
            'success' => $success,
            'msj' => $msj
        ];
        return $result;
    }

    /**
     * Validación de código de establecimiento
     *
     * @param string $numero tercer dígito de CI/RUC
     *
     * @return boolean
     *
     * @throws exception Cuando el establecimiento es menor a 1
     */
    protected function validarCodigoEstablecimiento($numero)
    {
        $success = true;
        $msj = '';
        if ($numero < 1) {
            $success = false;
            $msj = ('Código de establecimiento no puede ser 0');
        }

        $result = [
            'success' => $success,
            'msj' => $msj
        ];
        return $result;
    }

    /**
     * Algoritmo Modulo10 para validar si CI y RUC de persona natural son válidos.
     *
     * Los coeficientes usados para verificar el décimo dígito de la cédula,
     * mediante el algoritmo “Módulo 10” son:  2. 1. 2. 1. 2. 1. 2. 1. 2
     *
     * Paso 1: Multiplicar cada dígito de los digitosIniciales por su respectivo
     * coeficiente.
     *
     *  Ejemplo
     *  digitosIniciales posicion 1  x 2
     *  digitosIniciales posicion 2  x 1
     *  digitosIniciales posicion 3  x 2
     *  digitosIniciales posicion 4  x 1
     *  digitosIniciales posicion 5  x 2
     *  digitosIniciales posicion 6  x 1
     *  digitosIniciales posicion 7  x 2
     *  digitosIniciales posicion 8  x 1
     *  digitosIniciales posicion 9  x 2
     *
     * Paso 2: Sí alguno de los resultados de cada multiplicación es mayor a o igual a 10,
     * se suma entre ambos dígitos de dicho resultado. Ex. 12->1+2->3
     *
     * Paso 3: Se suman los resultados y se obtiene total
     *
     * Paso 4: Divido total para 10, se guarda residuo. Se resta 10 menos el residuo.
     * El valor obtenido debe concordar con el digitoVerificador
     *
     * Nota: Cuando el residuo es cero(0) el dígito verificador debe ser 0.
     *
     * @param string $digitosIniciales Nueve primeros dígitos de CI/RUC
     * @param string $digitoVerificador Décimo dígito de CI/RUC
     *
     * @return boolean
     *
     * @throws exception Cuando los digitosIniciales no concuerdan contra
     * el código verificador.
     */
    protected function algoritmoModulo10($digitosIniciales, $digitoVerificador)
    {
        $success = true;
        $msj = '';
        $arrayCoeficientes = array(2, 1, 2, 1, 2, 1, 2, 1, 2);
        $digitoVerificador = (int)$digitoVerificador;
        $digitosIniciales = str_split($digitosIniciales);
        $total = 0;
        foreach ($digitosIniciales as $key => $value) {
            $valorPosicion = ((int)$value * $arrayCoeficientes[$key]);
            if ($valorPosicion >= 10) {
                $valorPosicion = str_split($valorPosicion);
                $valorPosicion = array_sum($valorPosicion);
                $valorPosicion = (int)$valorPosicion;
            }
            $total = $total + $valorPosicion;
        }
        $residuo = $total % 10;
        if ($residuo == 0) {
            $resultado = 0;
        } else {
            $resultado = 10 - $residuo;
        }
        if ($resultado != $digitoVerificador) {
            $success = false;
            $msj = ('Dígitos iniciales no validan contra Dígito Idenficador');
        }

        $result = [
            'success' => $success,
            'msj' => $msj
        ];
        return $result;
    }

    /**
     * Algoritmo Modulo11 para validar RUC de sociedades privadas y públicas
     *
     * El código verificador es el decimo digito para RUC de empresas privadas
     * y el noveno dígito para RUC de empresas públicas
     *
     * Paso 1: Multiplicar cada dígito de los digitosIniciales por su respectivo
     * coeficiente.
     *
     * Para RUC privadas el coeficiente esta definido y se multiplica con las siguientes
     * posiciones del RUC:
     *
     *  Ejemplo
     *  digitosIniciales posicion 1  x 4
     *  digitosIniciales posicion 2  x 3
     *  digitosIniciales posicion 3  x 2
     *  digitosIniciales posicion 4  x 7
     *  digitosIniciales posicion 5  x 6
     *  digitosIniciales posicion 6  x 5
     *  digitosIniciales posicion 7  x 4
     *  digitosIniciales posicion 8  x 3
     *  digitosIniciales posicion 9  x 2
     *
     * Para RUC privadas el coeficiente esta definido y se multiplica con las siguientes
     * posiciones del RUC:
     *
     *  digitosIniciales posicion 1  x 3
     *  digitosIniciales posicion 2  x 2
     *  digitosIniciales posicion 3  x 7
     *  digitosIniciales posicion 4  x 6
     *  digitosIniciales posicion 5  x 5
     *  digitosIniciales posicion 6  x 4
     *  digitosIniciales posicion 7  x 3
     *  digitosIniciales posicion 8  x 2
     *
     * Paso 2: Se suman los resultados y se obtiene total
     *
     * Paso 3: Divido total para 11, se guarda residuo. Se resta 11 menos el residuo.
     * El valor obtenido debe concordar con el digitoVerificador
     *
     * Nota: Cuando el residuo es cero(0) el dígito verificador debe ser 0.
     *
     * @param string $digitosIniciales Nueve primeros dígitos de RUC
     * @param string $digitoVerificador Décimo dígito de RUC
     * @param string $tipo Tipo de identificador
     *
     * @return boolean
     *
     * @throws exception Cuando los digitosIniciales no concuerdan contra
     * el código verificador.
     */
    protected function algoritmoModulo11($digitosIniciales, $digitoVerificador, $tipo)
    {
        $success = true;
        $msj = '';
        switch ($tipo) {
            case 'ruc_privada':
                $arrayCoeficientes = array(4, 3, 2, 7, 6, 5, 4, 3, 2);
                break;
            case 'ruc_publica':
                $arrayCoeficientes = array(3, 2, 7, 6, 5, 4, 3, 2);
                break;
            default:
                $success = false;
                $msj =('Tipo de Identificación no existe.');

                break;
        }
        $digitoVerificador = (int)$digitoVerificador;
        $digitosIniciales = str_split($digitosIniciales);
        $total = 0;
        foreach ($digitosIniciales as $key => $value) {
            $valorPosicion = ((int)$value * $arrayCoeficientes[$key]);
            $total = $total + $valorPosicion;
        }
        $residuo = $total % 11;
        if ($residuo == 0) {
            $resultado = 0;
        } else {
            $resultado = 11 - $residuo;
        }
        if ($resultado != $digitoVerificador) {
            $success = false;
            $msj = ('Dígitos iniciales no validan contra Dígito Idenficador');
        }

        $result = [
            'success' => $success,
            'msj' => $msj
        ];
        return $result;
    }

    /**
     * Get error
     *
     * @return string Mensaje de error
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set error
     *
     * @param string $newError
     * @return object $this
     */
    public function setError($newError)
    {
        $this->error = $newError;
        return $this;
    }

    const TYPE_IDENTIFICATION_CARD = 1;//CEDULA
    const TYPE_IDENTIFICATION_RUC = 2;//RUC
    const TYPE_IDENTIFICATION_PASSPORT = 3;//PASAPORTE
    const TYPE_IDENTIFICATION_FINAL_CONSUMER = 4;//CONSUMIDOR FINAL
    const TYPE_IDENTIFICATION_PLATE_RMV = 5;//PLACA RMV
    const TYPE_IDENTIFICATION_NO_DOCUMENTATION = 6;//SIN DOCUMENTACION

    const TYPE_RUC_NATURAL_PEOPLE = 1;
    const TYPE_RUC_PRIVATE_SOCIETY = 2;
    const TYPE_RUC_PUBLIC_SOCIETY = 3;
    const TYPE_RUC_NO_DOCUMENTATION = 4;


    public static function managerOptionsValidate($params)
    {


        $typeIdentificationId = $params['typeIdentificationId'];//tipo_identificacion_id
        $typeRucId = $params['typeRucId'];
        $businessName = $params['businessName'];
        $businessReason = $params['businessReason'];
        if ($typeRucId == self::TYPE_RUC_NATURAL_PEOPLE) {

        } else if ($typeRucId == self::TYPE_RUC_NO_DOCUMENTATION) {
            $businessName = "SIN RUC RAZON SOCIAL";
            $businessReason = "SIN RUC RAZON COMERCIAL";
        } else if ($typeRucId == self::TYPE_RUC_PRIVATE_SOCIETY) {

        } else if ($typeRucId == self::TYPE_RUC_PUBLIC_SOCIETY) {

        }
        $result = [
            'typeIdentificationId' => $typeIdentificationId,
            'businessName' => $businessName,//razon social
            'businessReason' => $businessReason,//razon comercial
            'typeRucId' => $typeRucId,//razon comercial


        ];

        return $result;

    }
}

?>
