<?php

namespace App\Http\Controllers\Api;

use App\Processes\CountryProcess;
use App\Transformers\CountryTransformer;
use Illuminate\Support\Facades\Request;

class CountryController extends ApiBaseController
{
    /**
     * @var CountryProcess
     */
    private $countryProcess;

    /**
     * @var CountryTransformer
     */
    private $countryTransformer;

    /**
     * CountryController constructor.
     * @param CountryProcess $countryProcess
     * @param CountryTransformer $countryTransformer
     */
    public function __construct(CountryProcess $countryProcess, CountryTransformer $countryTransformer)
    {
        $this->countryProcess = $countryProcess;
        $this->countryTransformer = $countryTransformer;
    }

    public function findAll()
    {
        $countries = $this->countryProcess->findAll();
        return $this->response->collection($countries, $this->countryTransformer);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $country = $this->countryProcess->create($data);
        return $this->response->item($country, $this->countryTransformer);
    }
}
