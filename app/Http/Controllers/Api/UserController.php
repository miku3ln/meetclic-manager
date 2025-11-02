<?php
/**
 * Created by PhpStorm.
 * User: alexi5h
 * Date: 3/3/2018
 * Time: 15:23
 */

namespace App\Http\Controllers\Api;


use App\Processes\UserProcess;

use Illuminate\Support\Facades\Request;
class UserController extends ApiBaseController
{
    private $userProcess;

    function __construct(UserProcess $userProcess)
    {
        $this->userProcess = $userProcess;
    }

    public function loginToken()
    {
        try {
            $input = Request::all();
            $process = $this->userProcess->loginToken($input);

            if (!isset($process['status_code'])) {
                return $this->response->array([
                    'data' => $process
                ])->setStatusCode(200);
            }
            return $this->response->array($process)->setStatusCode($process['status_code']);
        } catch (\Exception $e) {
            return $this->response->array(
                ['status_code' => 400, 'message' => $e->getMessage()]
            )->setStatusCode(400);
        }

    }

}
