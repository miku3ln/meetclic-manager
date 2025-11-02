<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\MyBaseController;
use App\Models\Customer;
use Illuminate\Support\Facades\Request;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use App\Models\PeopleProfession as PeopleProfession;
use App\Models\PeopleNationality as PeopleNationality;
use App\Models\PeopleTypeIdentification as PeopleTypeIdentification;
use App\Models\RucType as RucType;

class CustomerController extends MyBaseController
{


    public function getManager()
    {

        $model = new Customer();
        $modelPTI = new PeopleTypeIdentification();
        $modelPN = new PeopleNationality();
        $modelPP = new PeopleProfession();
        $modelRT = new RucType();

        $moduleMain = "crm";
        $moduleResource = "customer";
        $moduleFolder = "customer";
        $renderView = "$moduleMain.$moduleFolder.index";
        $model_entity = "customer";
        $pathCurrent = "$moduleMain/$moduleFolder";
        $rootView = "$moduleMain." . $moduleFolder . "." . $moduleFolder;

        $peopleTypeIdentification = $modelPTI->getDataListAll();

        $peopleProfession = $modelPP->getDataListAll();
        $peopleNationality = $modelPN->getDataListAll();
        $rucType = $modelRT->getDataListAll();

        $dataCatalogue = array(
            "peopleTypeIdentification" => $peopleTypeIdentification,
            "peopleProfession" => $peopleProfession,
            "peopleNationality" => $peopleNationality,
            "rucType" => $rucType,

        );
        $paramsSend = [
            "configPartial" => array(
                "moduleMain" => $moduleMain,
                "moduleFolder" => $moduleFolder,
                "moduleResource" => $moduleResource,
                "dataCatalogue" => $dataCatalogue
            ),
            "rootView" => $rootView,
            "model_entity" => $model_entity,
            'model' => $model,
            "pathCurrent" => $pathCurrent,

        ];


        $this->layout->content = View::make($renderView, $paramsSend);
    }

    public function getAdmin()
    {
        $dataPost =Request::all();
        $model = new Customer();
        $result = $model->getAdmin($dataPost);
        return Response::json(
            $result
        );
    }
    public function getDataAdmin()
    {
        $dataPost = Request::all();
        $model = new Customer();
        $result = $model->getAdminRegisters($dataPost);
        return Response::json(
            $result
        );
    }
    public function getAdminEmails()
    {
        $dataPost = Request::all();
        $model = new Customer();
        $result = $model->getAdminEmails($dataPost);
        return Response::json(
            $result
        );
    }
    public function getAdminEmailsRegisters()
    {
        $dataPost = Request::all();
        $model = new Customer();
        $result = $model->getAdminEmailsRegisters($dataPost);
        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new Customer();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }
    public function saveDataData()
    {

        $attributesPost = Request::all();
        $model = new Customer();
        $result = $model->saveDataData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }
    public function getListSelect2NotLodging()
    {

        $attributesPost =Request::all();
        $model = new Customer();
        $result = $model->getListSelect2NotLodging($attributesPost);
        return Response::json($result);
    }

    public function getListAllInformationAddress()
    {

        $attributesPost = Request::all();
        $model = new Customer();
        $result = $model->getListAllInformationAddress($attributesPost);
        return Response::json($result);
    }

    public function getListS2InformationAddress()
    {

        $attributesPost = Request::all();
        $model = new Customer();
        $result = $model->getListS2InformationAddress($attributesPost);
        return Response::json($result);
    }

    public function manager($typeManagerSuccess = null, $typeManagerMsj = null)
    {


        $moduleMain = "crm";
        $moduleResource = "customerManager";
        $moduleFolder = "customerManager";
        $renderView = "$moduleMain.$moduleFolder.index";
        $paramsSend = [
            "configPartial" => array(
                'typeManagerSuccess'=>$typeManagerSuccess,
                'typeManagerMsj'=>$typeManagerMsj

            ),
        ];

        $this->layout->content = View::make($renderView, $paramsSend);


    }

    public function getListRepair()
    {

        $attributesPost = Request::all();
        $model = new Customer();
        $result = $model->getListRepair($attributesPost);
        return Response::json($result);
    }
    public function saveDataFix()
    {

        $attributesPost =Request::all();
        $model = new Customer();
        $result = $model->saveDataFix(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }
    public function saveDataProfile()//CMS-TEMPLATE-MY-PROFILE-ACTION
    {

        $attributesPost = Request::all();
        $model = new Customer();
        $result = $model->saveDataProfile(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

    public function getListCustomers()
    {

        $attributesPost = Request::all();
        $model = new Customer();
        $result = $model->getListCustomersManager($attributesPost);
        return Response::json($result);
    }
    public function getListCustomersMikrotiks()
    {

        $attributesPost = Request::all();
        $model = new Customer();
        $result = $model->getListCustomersMikrotiksManager($attributesPost);
        return Response::json($result);
    }
    public function getListS2Customer()
    {

        $attributesPost = Request::all();
        $model = new Customer();
        $result = $model->getListS2Customer($attributesPost);
        return Response::json($result);
    }
}
