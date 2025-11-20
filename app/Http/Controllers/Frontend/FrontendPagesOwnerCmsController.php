<?php


namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\Models\Business;
use App\Models\BusinessByRoutesMap;
use App\Models\RouteMapByAdventureTypes;
use App\Models\RoutesMap;
use App\Models\RoutesMapByRoutesDrawing;
use Illuminate\Http\Request;

class FrontendPagesOwnerCmsController extends Controller
{
    public function businessOwner(Request $request)
    {
        $slug = $request->route('slug');
        $section = $request->route('section');

        return view('cityBook.web.businessOwner.mikuy-yachak', [
            'slug' => $slug,
            'section' => $section
        ]);
    }

    public function chasqui($id = null)
    {
        $slug = "";
        $section = "";

        $dataModelBRR = BusinessByRoutesMap::find($id);

        $business_id = null;
        $routes_map_id = null;
        $allow = false;
        $dataBusiness = null;
        $dataRoute = null;
        if ($dataModelBRR) {
            $business_id = $dataModelBRR->business_id;
            $routes_map_id = $dataModelBRR->routes_map_id;
            $allow = true;
            $model = new Business();
            $dataBusiness = $model->getBusinessData(array("id" => $business_id));
            $modelRMBRD = new RoutesMapByRoutesDrawing();
            $routes_drawing_data = $modelRMBRD->getRoutesDrawing(array("routes_map_id" => $routes_map_id));
            $business_by_routes_map_id = $id;
            $modelRMBAT = new RouteMapByAdventureTypes();
            $adventure_type_data = $modelRMBAT->getAdventureTypes(array("business_by_routes_map_id" => $business_by_routes_map_id));
            $modelInformation = RoutesMap::find($routes_map_id);
            $information = array();
            if ($modelInformation) {
                $information = $modelInformation->getAttributes();
            }


            $modelManager = new \App\Models\InformationSocialNetwork();
            $entity_id = $business_id;
            $resultCurrentData = $modelManager->getInformationData([
                'filters' => [
                    'state' => $modelManager::STATE_ACTIVE,
                    'main' => $modelManager::MAIN,
                    'entity_type' => $modelManager::ENTITY_TYPE_BUSINESS,
                //    'information_social_network_type_id' => \App\Models\InformationSocialNetworkType::TYPE_FACEBOOK_ID,
                    'entity_id' => $entity_id,
                ]
            ]);
            $dataRoute = array(
                "information" => $information,
                'socialNetwork'=>$resultCurrentData,
                "routes_drawing_data" => $routes_drawing_data,
                "adventure_type_data" => $adventure_type_data
            );
        }



        return view('cityBook.web.businessOwner.muelle-catalina', [
            'slug' => $slug,
            'section' => $section,
            'dataManager' => [
                'allow' => $allow,
                'business' => $dataBusiness,
                'dataRoute' => $dataRoute,

            ]
        ]);
    }
}
