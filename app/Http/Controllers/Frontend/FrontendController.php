<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\FrontendBaseController;
use App\Models\FrontendManager;
use App;
use App\Models\Products\Product;
use Auth;
use App\Models\TemplateInformation;
use App\Utils\Util;


use App\Utils\FrontendMenu;

use App\Components\EmailUtil;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailContactUs;
use App\Models\TemplateConfigMailingByEmails;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class FrontendController extends FrontendBaseController
{
    const LAYOUT_MAIN = 'frontend';

    public $modelInit = null;
    public $modelInitLanguage = null;
    public $typeTemplate = null;

    public function __construct()
    {
        $this->modelInit = new FrontendManager();

        $this->modelInitLanguage = new App\Models\LanguageConfigManager();

    }

    public function translateKichwa($language = 'es', $type = 1)
    {
        $renderView = self::LAYOUT_MAIN . '.web.translateKichwa';
        $paramsSend = [
            'managerOptions ' => []
        ];

        return view($renderView, $paramsSend);
    }

    public function index($language = 'es', $type = 1)//MAIN HOME CMS-TEMPLATE-home
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;
        $project = "managerSystemTest";


        if (env('allowRoutes')) {
            $renderView = self::LAYOUT_MAIN . '.web.homeRoutes';
        } elseif (env('allowBusinessOwner')) {
            $renderView = self::LAYOUT_MAIN . '.web.homeArquitechos';

        } elseif (env('allowAllInOne')) {
            $renderView = 'cityBook.web.homePage';
            $modelPage = new \App\Models\FrontendCityBookManager();

        }

        $renderView = self::LAYOUT_MAIN . '.web.' . $project . '.homePage';
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'home',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);

    }

    public function aboutUs($language = 'es')
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];


        $renderView = self::LAYOUT_MAIN . '.web.aboutUs';
        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;

        $paramsSend = $modelPage->getParamsPage([
            'page' => 'aboutUs',
            'paramsRequest' => $paramsRequest

        ]);
        return view($renderView, $paramsSend);
    }

    public function services($language = 'es')
    {
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $renderView = self::LAYOUT_MAIN . '.web.services';
        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'services',
            'paramsRequest' => $paramsRequest
        ]);
        return view($renderView, $paramsSend);

    }

    public function shop($language = 'es')
    {
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $renderView = env('allowRoutes') ? self::LAYOUT_MAIN . '.web.shopEvents' : self::LAYOUT_MAIN . '.web.shop';

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $dataPost = Request::all();

        $paramsRequest['language'] = $language;
        $categoryId = isset($dataPost['category']) ? $dataPost['category'] : -1;
        $subcategoryId = isset($dataPost['subcategory']) ? $dataPost['subcategory'] : -1;

        $search = isset($dataPost['search']) ? $dataPost['search'] : null;
        if ($categoryId != -1 || $search != null || $subcategoryId != null) {
            if ($search != null) {

                $paramsRequest['search'] = $search;
            }
            if ($categoryId != -1) {

                $paramsRequest['categoryId'] = $categoryId;

            }
            if ($subcategoryId != -1) {

                $paramsRequest['subCategoryId'] = $subcategoryId;

            }
        }
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'shop',
            'paramsRequest' => $paramsRequest

        ]);
        return view($renderView, $paramsSend);

    }

    public function shopBalances($language = 'es')
    {
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $renderView = self::LAYOUT_MAIN . '.web.shopBalances';

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $dataPost = Request::all();

        $paramsRequest['language'] = $language;
        $categoryId = isset($dataPost['category']) ? $dataPost['category'] : -1;
        $subcategoryId = isset($dataPost['subcategory']) ? $dataPost['subcategory'] : -1;

        $search = isset($dataPost['search']) ? $dataPost['search'] : null;
        if ($categoryId != -1 || $search != null || $subcategoryId != null) {
            if ($search != null) {

                $paramsRequest['search'] = $search;
            }
            if ($categoryId != -1) {

                $paramsRequest['categoryId'] = $categoryId;

            }
            if ($subcategoryId != -1) {

                $paramsRequest['subCategoryId'] = $subcategoryId;

            }
        }
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'shopBalances',
            'paramsRequest' => $paramsRequest

        ]);
        return view($renderView, $paramsSend);

    }

    public function ourStores($language = 'es')
    {
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $renderView = self::LAYOUT_MAIN . '.web.ourStores';

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $dataPost = Request::all();
        $paramsRequest['language'] = $language;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'ourStores',
            'paramsRequest' => $paramsRequest

        ]);
        return view($renderView, $paramsSend);

    }

    public function orderService($language = 'es')
    {
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $renderView = self::LAYOUT_MAIN . '.web.orderService';

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $dataPost = Request::all();
        $paramsRequest['language'] = $language;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'orderService',
            'paramsRequest' => $paramsRequest

        ]);
        return view($renderView, $paramsSend);

    }

    public function shopOutlets($language = 'es')
    {
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $renderView = self::LAYOUT_MAIN . '.web.shopOutlets';

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $dataPost = Request::all();

        $paramsRequest['language'] = $language;
        $categoryId = isset($dataPost['category']) ? $dataPost['category'] : -1;
        $subcategoryId = isset($dataPost['subcategory']) ? $dataPost['subcategory'] : -1;

        $search = isset($dataPost['search']) ? $dataPost['search'] : null;
        if ($categoryId != -1 || $search != null || $subcategoryId != null) {
            if ($search != null) {

                $paramsRequest['search'] = $search;
            }
            if ($categoryId != -1) {

                $paramsRequest['categoryId'] = $categoryId;

            }
            if ($subcategoryId != -1) {

                $paramsRequest['subCategoryId'] = $subcategoryId;

            }
        }
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'shopOutlets',
            'paramsRequest' => $paramsRequest

        ]);
        return view($renderView, $paramsSend);

    }

    public function terms($language = 'es')
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $renderView = self::LAYOUT_MAIN . '.web.terms';
        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'terms',
            'paramsRequest' => $paramsRequest
        ]);
        return view($renderView, $paramsSend);

    }

    public function policies($language = 'es')
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $renderView = self::LAYOUT_MAIN . '.web.policies';
        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'policies',
            'paramsRequest' => $paramsRequest
        ]);
        return view($renderView, $paramsSend);

    }

    public function productDetails($language = 'es', $id = null)
    {
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        if ($id == null) {

            $renderView = "errors.modelsView.404";
            return view($renderView, ['error' => 'Parametros mal enviados.!']);

        } else {

            $renderView = self::LAYOUT_MAIN . '.web.productDetails';
            $modelPage = $this->modelInit;
            $paramsRequest = [];
            $paramsRequest['language'] = $language;
            $paramsRequest['id'] = $id;

            $paramsSend = $modelPage->getParamsPage([
                'page' => 'productDetails',
                'productId' => $id,
                'paramsRequest' => $paramsRequest

            ]);
            return view($renderView, $paramsSend);
        }

    }

    public function wishList($language = 'es')
    {
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $renderView = self::LAYOUT_MAIN . '.web.wishList';
        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;

        $paramsSend = $modelPage->getParamsPage([
            'page' => 'wishList',
            'paramsRequest' => $paramsRequest

        ]);
        return view($renderView, $paramsSend);


    }

    public function checkout($language = 'es')
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];


        $renderView = env('allowRoutes') ? self::LAYOUT_MAIN . '.web.checkoutEvents' : self::LAYOUT_MAIN . '.web.checkout';

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'checkout',
            'paramsRequest' => $paramsRequest
        ]);
        return view($renderView, $paramsSend);
    }

    public function cart($language = 'es')
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $renderView = self::LAYOUT_MAIN . '.web.cart';
        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'cart',
            'paramsRequest' => $paramsRequest
        ]);
        return view($renderView, $paramsSend);
    }

    public function contactUs($language = 'es')
    {
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $renderView = self::LAYOUT_MAIN . '.web.contactUs';
        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'contactUs',
            'paramsRequest' => $paramsRequest
        ]);

        return view($renderView, $paramsSend);
    }


    public function manager($id = null, $typeManager = null)//FRONTEND-MANAGER-PROCESS-ROOT
    {
        if ($id == null) {
            $renderView = "errors.modelsView.404";
            return view($renderView, ['error' => 'Parametros mal enviados.!']);

        } else {
            $modelDataManager = TemplateInformation::find($id);
            $menuConfigByRole = [];
            if ($modelDataManager) {

                $renderView = self::LAYOUT_MAIN . '.backend.index';
                $moduleMain = "frontend";
                $moduleResource = "manager";
                $moduleFolder = "backend";
                $pathCurrent = "$moduleMain/$moduleFolder";
                $user = Auth::user();
                $modelCurrent = $modelDataManager;
                /*----MENU MANAGER--*/
                $managerViewMain = FrontendMenu::getManagerViewMainFrontend(array(
                    'model' => $modelCurrent,
                    'user' => $user,
                ));
                //Menu
                $paramsMenu = array(
                    'managerViewMain' => $managerViewMain,
                    'id' => $id,
                    'user' => $user,
                    'dataManager' => $modelDataManager,
                    'typeManager' => $typeManager,

                );
                $menuConfigByRole = FrontendMenu::getMenuConfigByRoleFrontend($paramsMenu);
                $paramsMenu['menuConfigByRole'] = $menuConfigByRole;

                $menuCurrentConfig = Util::getMenuManager(
                    $paramsMenu);
                $menuCurrent = $menuCurrentConfig['menu'];
                $menuItems = Util::getMenuFormat($menuCurrent);
                $menuHtml = Util::getStructureMenuCurrent($menuItems);

                $rootView = "$moduleMain." . $moduleFolder . "." . $moduleFolder;
                $typeManager = $typeManager == null ? ('manager' . $menuCurrentConfig['managerViewMain']['viewMain']) : $typeManager;


                $paramsSend = array(
                    "configPartial" => array(
                        "moduleMain" => $moduleMain,
                        "moduleFolder" => $moduleFolder,
                        "moduleResource" => $moduleResource,
                        'pathCurrent' => $pathCurrent,
                        'menuCurrent' => $menuCurrentConfig,
                        'typeManager' => $typeManager,
                        'user' => $user,
                        'menuHtml' => $menuHtml
                    ),
                    "modelDataManager" => $modelDataManager,
                    "rootView" => $rootView,
                    'managerViewMain' => $managerViewMain,
                    'model' => $modelCurrent,
                    "pathCurrent" => $pathCurrent,
                    "user" => $user,
                );


                $modelUtilManager = new \App\Utils\FrontendManager();
                $configManagementPage = $modelUtilManager->getDataManager([
                    'id' => $id, 'typeManager' => $typeManager,
                    'modelDataManager' => $modelDataManager
                ]);
                $paramsSend['configManagementPage'] = $configManagementPage;
            } else {
                $renderView = "errors.modelsView.404";
                $paramsSend = ['error' => 'No existe informacion con aquel id.!'];

            }

            return view($renderView, $paramsSend);
        }

    }

    public function sendMail()
    {
        $mail = new EmailUtil();
        $dataPost = Request::all();
        $data = $dataPost;
        $mail = new EmailUtil();

        $dataPost = Request::all();
        $data = $dataPost;

        $typePage = $data['typePage'];
        $business_id = $data['business_id'];
        $result = [];
        if ($typePage == 3) {
            $contactBusiness = $data['stores-service'];
            $customerDate = $data['date-service'] . ' ' . $data['hour-service'];
            $customerName = $data['full-name-service'];
            $customerPhone = $data['phone-service'];
            $dataMessage = [
                'contactBusiness' => $contactBusiness,
                'customerDate' => $customerDate,
                'customerName' => $customerName,
                'customerPhone' => $customerPhone,

            ];
            $result = $mail->sendMailBySchedule([
                'typePage' => $typePage,
                'business_id' => $business_id,
                'dataMessage' => $dataMessage,
                'typeTemplate' => 'contactUsForm'

            ]);
        } else {
            $result = $mail->sendMailByPages([
                'typePage' => $typePage,
                'business_id' => $business_id,
                'dataMessage' => $data,
                'typeTemplate' => 'contactUsForm'

            ]);
        }


        return $result;

    }

    public function paymentSend()
    {


        $renderView = self::LAYOUT_MAIN . '.web.paymentSend';
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'paymentSend'
        ]);
        return view($renderView, $paramsSend);
    }

    public function addWishListProduct()
    {
        $dataPost = Request::all();
        $model = new FrontendManager();
        $inputData['attributesPost'] = $dataPost;
        $result = $model->addWishListProduct($inputData);
        return Response::json(
            $result
        );
    }

    public function checkoutDetails($language = 'es', $id = null, $checkout = null)
    {
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        if ($id == null) {

            $renderView = "errors.modelsView.404";
            return view($renderView, ['error' => 'Parametros mal enviados.!']);

        } else {


            $renderView = env('allowRoutes') ? self::LAYOUT_MAIN . '.web.checkoutDetailsEvent' : self::LAYOUT_MAIN . '.web.checkoutDetails';

            $modelPage = $this->modelInit;
            $paramsRequest = [];
            $paramsRequest['language'] = $language;
            $paramsRequest['id'] = $id;
            $paramsRequest['checkout'] = $checkout;

            $paramsSend = $modelPage->getParamsPage([
                'page' => 'checkoutDetails',
                'id' => $id,
                'paramsRequest' => $paramsRequest

            ]);
            return view($renderView, $paramsSend);
        }

    }

    public function activitiesGame($language = 'es')
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $renderView = self::LAYOUT_MAIN . '.web.activitiesGame';
        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'activitiesGame',
            'paramsRequest' => $paramsRequest

        ]);
        return view($renderView, $paramsSend);
    }

    public function rewardsGame($language = 'es')
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $renderView = self::LAYOUT_MAIN . '.web.rewardsGame';
        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'rewardsGame',
            'paramsRequest' => $paramsRequest

        ]);
        return view($renderView, $paramsSend);
    }

    public function refundCreditCard($language = 'es')
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $renderView = self::LAYOUT_MAIN . '.web.refundTest';
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'refundCreditCard',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);

    }


    public function eventDetails($language = 'es', $id = null)
    {
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        if ($id == null) {
            $renderView = "errors.modelsView.404";
            return view($renderView, ['error' => 'Parametros mal enviados.!']);

        } else {

            $renderView = self::LAYOUT_MAIN . '.web.eventDetails';
            $modelPage = $this->modelInit;
            $paramsRequest = [];
            $paramsRequest['language'] = $language;
            $paramsRequest['id'] = $id;

            $paramsSend = $modelPage->getParamsPage([
                'page' => 'eventDetails',
                'eventsId' => $id,
                'paramsRequest' => $paramsRequest

            ]);
            return view($renderView, $paramsSend);
        }

    }

    public function indexOne($language = 'es')
    {
        $this->layout = $this->modelInit::getLayoutByTypeTemplate($this->modelInit::TEMPLATE_VARKALA);
        $this->resourcesPathManager = env('APP_IS_SERVER') ? "public/" : '';

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $renderView = self::LAYOUT_MAIN . '.web.templates.varkala.index';
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'indexOne',
            "templateInitType" => $modelPage::TEMPLATE_VARKALA,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);

    }

    public function listingOne($language = 'es')
    {
        $this->layout = $this->modelInit::getLayoutByTypeTemplate($this->modelInit::TEMPLATE_VARKALA);
        $this->resourcesPathManager = env('APP_IS_SERVER') ? "public/" : '';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $id = $this->modelInit::getBusinessMainId($this->modelInit::TEMPLATE_VARKALA);
        $paramsRequest['language'] = $language;
        $paramsRequest['id'] = $id;
        $paramsRequest['type'] = $id;

        $renderView = self::LAYOUT_MAIN . '.web.templates.varkala.listingOne';
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'listingOne',
            "templateInitType" => $modelPage::TEMPLATE_VARKALA,
            'paramsRequest' => $paramsRequest
        ]);

        return view($renderView, $paramsSend);

    }

    public function getAdminFrontend($language="es")
    {
        $dataPost = Request::all();
        $model = new Product();

        $data = $model->getAdminFrontend($dataPost);
        $result=Response::json(
            $data
        );

        return $result;
    }
    public function signPdf(Request $request)
    {
        $result=[
            "success"=>false,
            "data"=>[],

        ];
        // Validar entrada
        $request->validate([
            'pdf' => 'required|file|mimes:pdf',
            'certificate' => 'required|file|mimes:p12',
            'password' => 'required|string',
            'reason' => 'nullable|string',
        ]);

        try {
            // Cargar PDF y certificado
            $pdfPath = $request->file('pdf')->getRealPath();
            $certPath = $request->file('certificate')->getRealPath();
            $password = $request->input('password');
            $reason = $request->input('reason', 'Document signed digitally');

            // Leer certificado P12
            $certData = file_get_contents($certPath);
            openssl_pkcs12_read($certData, $certs, $password);

            $privateKey = $certs['pkey'];
            $certificate = $certs['cert'];

            // Inicializar FPDI
            $pdf = new Fpdi();
            $pageCount = $pdf->setSourceFile($pdfPath);

            // Importar páginas
            for ($i = 1; $i <= $pageCount; $i++) {
                $tplIdx = $pdf->importPage($i);
                $pdf->addPage();
                $pdf->useTemplate($tplIdx);
            }

            // Agregar la firma (simple, no visible en este caso)
            $pdf->SetFont('Helvetica', '', 10);
            $pdf->SetXY(10, 10);
            $pdf->Write(10, "Digitally signed: $reason");

            // Crear firma digital (resumen SHA256)
            $digest = hash('sha256', $pdf->Output('S'), true);
            $signature = '';

            openssl_sign($digest, $signature, $privateKey, OPENSSL_ALGO_SHA256);

            // Guardar PDF firmado
            $signedPdfPath = 'signed_' . uniqid() . '.pdf';
            Storage::put($signedPdfPath, $pdf->Output('S'));

            // return response()->download(storage_path('app/' . $signedPdfPath));
        } catch (\Exception $e) {
            // return response()->json(['error' => $e->getMessage()], 500);
        }
        return Response::json($result);
    }
    public function signPdfLocal()
    {
        $result = [
            "success" => false,
            "data" => [],
        ];


        try {
            // Ruta del PDF a firmar
            $pdfName = "Catalogo Navideño EL ARTE 24.pdf";
            $pathProcess="app/public/documents-manager";
            $pdfPath = storage_path($pathProcess.'/pdf_files/' . $pdfName);

            // Verificar si el archivo existe
            if (!file_exists($pdfPath)) {
                return response()->json(['error' => 'El archivo PDF no existe.'], 404);
            }

            // Ruta del certificado
            $certPath = storage_path($pathProcess.'/certificates/my_certificate.p12');
            $password = "St963852";
            $reason ="RAZON PARA FIRMAR";

            // Leer certificado P12
            $certData = file_get_contents($certPath);
            openssl_pkcs12_read($certData, $certs, $password);

            $privateKey = $certs['pkey'];
            $certificate = $certs['cert'];

            // Inicializar FPDI
            $pdf = new Fpdi();
            $pageCount = $pdf->setSourceFile($pdfPath);

            // Importar páginas
            for ($i = 1; $i <= $pageCount; $i++) {
                $tplIdx = $pdf->importPage($i);
                $pdf->addPage();
                $pdf->useTemplate($tplIdx);
            }

            // Agregar la firma (simple, no visible en este caso)
            $pdf->SetFont('Helvetica', '', 10);
            $pdf->SetXY(10, 10);
            $pdf->Write(10, "Digitally signed: $reason");

            // Crear firma digital (resumen SHA256)
            $digest = hash('sha256', $pdf->Output('S'), true);
            $signature = '';
            openssl_sign($digest, $signature, $privateKey, OPENSSL_ALGO_SHA256);

            // Guardar PDF firmado
            $signedPdfName = 'signed_' . uniqid() . '.pdf';
            $signedPdfPath = storage_path($pathProcess.'/signed_pdfs/' . $signedPdfName);

            file_put_contents($signedPdfPath, $pdf->Output('S'));

            // Resultado exitoso
            $result['success'] = true;
            $result['data'] = [
                'signed_pdf_path' => $signedPdfPath,
                'signed_pdf_url' => url('storage/signed_pdfs/' . $signedPdfName),
            ];
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json($result);
    }
}
