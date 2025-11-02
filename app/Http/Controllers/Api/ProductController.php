<?php

namespace App\Http\Controllers\Api;

use App\Processes\ProductProcess;
use App\Transformers\ProductTransformer;
use App\Validators\ProductValidator;

use Illuminate\Support\Facades\Request;
/**
 * Class ProductController
 * @package App\Http\Controllers\Api
 */
class ProductController extends ApiBaseController
{
    /**
     * @var ProductProcess
     */
    private $productProcess;

    /**
     * @var ProductTransformer
     */
    private $productTransformer;

    /**
     * @var ProductValidator
     */
    private $productValidator;

    /**
     * ProductController constructor.
     * @param ProductProcess $productProcess
     * @param ProductTransformer $productTransformer
     * @param ProductValidator $productValidator
     */
    public function __construct(ProductProcess $productProcess, ProductTransformer $productTransformer, ProductValidator $productValidator)
    {
        $this->productProcess = $productProcess;
        $this->productTransformer = $productTransformer;
        $this->productValidator = $productValidator;
    }

    public function findAll()
    {
        $data = Request::all();
        $result = $this->productProcess->findAll($data);
        return $this->response->array(['data' => $result]);
    }
}
