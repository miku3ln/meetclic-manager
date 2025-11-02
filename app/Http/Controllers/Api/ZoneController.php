<?php

namespace App\Http\Controllers\Api;


use App\Processes\ZoneProcess;
use App\Transformers\ZoneTransformer;
use App\Validators\ZoneValidator;

use Illuminate\Support\Facades\Request;
class ZoneController extends ApiBaseController
{
    /**
     * @var ZoneProcess
     */
    private $process;

    /**
     * @var ZoneValidator
     */
    private $validator;

    /**
     * @var ZoneTransformer
     */
    private $transformer;

    /**
     * ZoneController constructor.
     * @param ZoneProcess $process
     * @param ZoneValidator $validator
     * @param ZoneTransformer $transformer
     */
    public function __construct(ZoneProcess $process,
                                ZoneValidator $validator,
                                ZoneTransformer $transformer)
    {
        $this->process = $process;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    /**
     * @return mixed
     */
    public function showAreaInfo()
    {
        $data = Request::all();
        $process = $this->process->showInformationArea($data);
        return $this->response->array([
            'data' => $this->transformer->transform($process)
        ]);

    }

}
