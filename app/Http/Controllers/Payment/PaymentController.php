<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\FrontendBaseController;
use App\Models\FrontendManager;

use App\Models\OrderPaymentsManager;
use App\Models\TemplatePayments;
use Auth;
use App\Models\TemplateInformation;
use App\Utils\Util;
use App\Utils\UtilUser;

use App\Components\EmailUtil;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailContactUs;
use App\Models\TemplateConfigMailingByEmails;
use Illuminate\Support\Facades\Response;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\InputFields;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\WebProfile;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use App\Models\Multimedia;
use URL;


use App\Models\Pa;

use Paymentez\Paymentez;
use Paymentez\Exceptions\PaymentezErrorException;

class PaymentController extends FrontendBaseController
{
    const ALLOW_PRODUCTION_PAY_PAL = true;
    const ALLOW_PRODUCTION_PAYMENTEZ = true;

    const CURRENCY = 'USD';

    const SAND_BOX_CLIENT_ID = 'AczLXF5IQeldkXWigGE4gwrvOk8iBcBN7Ghh0jHQS4BqmOHUqV61I5nFyJzKQJY7TT50GU6o2fzfk7ER';
    const SAND_BOX_SECRET = 'ECfs2I6gGgyl_8xkJ7hsatW7Q8-fwePON9JBcVFclY364Qxm7N-RfQ-txa0PaByvc3re6r30MxdSq2U3';
    const API_LIVE_CLIENT_ID = 'AaVfUBg5Frcy7wnsvGTYHWa1X0nrTQnDE7Gq1F6L5TjkHhYnvB2N43LgId97HVDei3FwXYpbsoZq2X2A';
    const API_LIVE_SECRET = 'EAyjZC3i-jIWKwPDqcvn8TwM-GnztlF-bQbaDn95MYt6mzJLbjpXM6egn7X0K80NN8V8R2q_FQfuqUCb';
    const BUSINESS_MANAGER_ID = 1;

    public function _callApi(array $params)
    {

        $curl = curl_init();
        curl_setopt_array($curl, $params);
        curl_setopt($curl, 42, 0);
        curl_setopt($curl, 19913, 1);
        curl_setopt($curl, 78, 10);
        $response = curl_exec($curl);
        return json_decode($response, true);
    }

    public function createPaymentPayPal(Request $request)
    {
        $otherFetch = false;
        $credential = self::ALLOW_PRODUCTION_PAY_PAL ? self::API_LIVE_CLIENT_ID : self::SAND_BOX_CLIENT_ID;
        $requestId = self::ALLOW_PRODUCTION_PAY_PAL ? self::API_LIVE_SECRET : self::SAND_BOX_SECRET;
        $modelT = new TemplateInformation();
        $templateInformation = $modelT->getTemplateMainFrontend(array('business_id' => self::BUSINESS_MANAGER_ID));
        $ALLOW_PRODUCTION_PAYMENT = self::ALLOW_PRODUCTION_PAY_PAL;
        if ($templateInformation != false) {
            $template_information_id = $templateInformation->id;
            $modelTP = new TemplatePayments();
            $paramsCurrent['filters'] = [
                'template_information_id' => $template_information_id,
                'type_payment' => $modelTP::TYPE_PAYMENT_PAYPAL, 'status' => 'ACTIVE'
            ];

            $resultData = $modelTP->getTypesPayments($paramsCurrent);
            if ($resultData != false) {
                $ALLOW_PRODUCTION_PAYMENT = $resultData->type_manager == 1 ? true : false;
                $credential = $ALLOW_PRODUCTION_PAYMENT ? $resultData->live_id : $resultData->test_id;
                $requestId = $ALLOW_PRODUCTION_PAYMENT ? $resultData->live_secret : $resultData->test_secret;
            }
        }

        $aut = new OAuthTokenCredential(
            $credential,
            $requestId
        );
        $apiContext = new ApiContext($aut);
        if ($ALLOW_PRODUCTION_PAYMENT) {
            $apiContext->setConfig(
                array(
                    'mode' => 'live',

                )
            );
        }
        $dataPost = Request::all();
        if ($otherFetch) {
            $paramsPost = $request->getContent();
            $paramsRequest = json_decode($paramsPost);
            $dataPost['params'] = $paramsRequest->params;
        }
        $paramsRequest = $dataPost['params'];
        $paramsRequest = json_decode($paramsRequest);

        $OrderShopping = $paramsRequest->OrderShopping;
        $OrderBillingDetails = json_decode($paramsRequest->OrderBillingDetails);
        $OrderBillingCustomer = $paramsRequest->OrderBillingCustomer;
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $itemsData = [];

        /*CUSTOMER*/
        if (self::ALLOW_PRODUCTION_PAY_PAL) {
            if (false) {

                $inputFields = new InputFields();
                $inputFields->setNoShipping(1);
                $addressSend = $OrderBillingCustomer->address_main . ' , ' . $OrderBillingCustomer->address_secondary . '.';
                $inputFields->setAddressOverride($addressSend);
                $webProfile = new WebProfile();
                $nameProfile = $OrderBillingCustomer->first_name . ' ' . $OrderBillingCustomer->last_name;
                $webProfile->setName($nameProfile)->setInputFields($inputFields);
                $webProfileId = $webProfile->create($apiContext)->getId();
            }
        }
        foreach ($OrderBillingDetails as $key => $row) {
            $itemCurrent = new Item();
            $nameProduct = $row->name . ' - ' . $row->code;
            $priceProduct = $row->price;
            $countProduct = $row->count;

            $itemCurrent->setName($nameProduct)
                ->setCurrency(self::CURRENCY)
                ->setQuantity($countProduct)
                ->setSku($row->id)
                ->setPrice($priceProduct);
            $itemsData[] = $itemCurrent;
        }
        $itemList = new ItemList();
        $itemList->setItems($itemsData);

        $details = new Details();
        $details->setShipping($OrderShopping->shipping)
            ->setTax(0)
            ->setSubtotal($OrderShopping->subtotal);
        $total = $OrderShopping->subtotal;
        $amount = new Amount();
        $amount->setTotal($total)
            ->setCurrency(self::CURRENCY)
            ->setDetails($details);
        $invoiceNumber = uniqid();
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription($OrderShopping->description)
            ->setInvoiceNumber($invoiceNumber);
        $urlEnd = URL('paymentSend');
        $urlCancel = URL('shop');

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($urlEnd)
            ->setCancelUrl($urlCancel);

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));
        $result = [];
        try {
            $payment->create($apiContext);
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            exit(1);
        }


        return $payment;
    }

    public function executePaymentPayPal()
    {
        $credential = null;
        $requestId = null;
        $ALLOW_PRODUCTION_PAYMENT = null;
        $modelT = new TemplateInformation();
        $templateInformation = $modelT->getTemplateMainFrontend(array('business_id' => self::BUSINESS_MANAGER_ID));
        $success = false;
        $data = [];
        $msg = '';
        $message = '';
        if ($templateInformation != false) {
            $template_information_id = $templateInformation->id;
            $modelTP = new TemplatePayments();
            $paramsCurrent['filters'] = [
                'template_information_id' => $template_information_id,
                'type_payment' => $modelTP::TYPE_PAYMENT_PAYPAL, 'status' => 'ACTIVE'
            ];

            $resultData = $modelTP->getTypesPayments($paramsCurrent);
            if ($resultData != false) {
                $ALLOW_PRODUCTION_PAYMENT = $resultData->type_manager == 1 ? true : false;
                $credential = $ALLOW_PRODUCTION_PAYMENT ? $resultData->live_id : $resultData->test_id;
                $requestId = $ALLOW_PRODUCTION_PAYMENT ? $resultData->live_secret : $resultData->test_secret;
                $dataPost = Request::all();
                $paramsRequest = $dataPost['params'];


                $paramsRequest = json_decode($paramsRequest);
                $User = $paramsRequest->User;
                $manager_user_new = $User->create_account == 'true';
                $manager_id = $User->id == 'null' ? null : $User->id;

                //STEP 1  MANAGER USER CURRENT
                //a) Not user login
                try {

                    $allowManagerNext = true;
                    $resultUser = null;
                    if ($manager_id == null && $manager_user_new) { //new user
                        $modelUserUtil = new UtilUser();
                        $resultUser = $modelUserUtil->managerUserCheckout([
                            'typePayment' => UtilUser::TYPE_PAYMENT_PAYPAL,
                            'dataCheckout' => $paramsRequest,
                            'userData'
                        ]);
                        $allowManagerNext = $resultUser['success'];
                        $userSave = $resultUser['data']['User'];
                        $manager_id = $userSave->id;
                    }
                    if ($allowManagerNext) {
                        //STEP MANAGER CHECKOUT
                        $OrderShopping = $paramsRequest->OrderShopping;
                        $OrderBillingDetails = json_decode($paramsRequest->OrderBillingDetails);
                        $OrderBillingCustomer = $paramsRequest->OrderBillingCustomer;
                        $aut = new OAuthTokenCredential(
                            $credential,
                            $requestId
                        );
                        $apiContext = new ApiContext($aut);
                        $Payment = $paramsRequest->Payment;

                        $amount = new Amount();
                        $transaction = new Transaction();
                        $details = new Details();
                        $details->setShipping($OrderShopping->shipping)
                            ->setTax(0)
                            ->setSubtotal($OrderShopping->subtotal);
                        $total = $OrderShopping->subtotal;
                        $amount->setTotal($total)
                            ->setCurrency(self::CURRENCY)
                            ->setDetails($details);
                        $transaction->setAmount($amount);
                        $paymentId = $Payment->id;
                        $PayerID = $Payment->payerID;
                        $execution = new \PayPal\Api\PaymentExecution();
                        $payment = Payment::get($paymentId, $apiContext);
                        $execution->setPayerId($PayerID);
                        $execution->addTransaction($transaction);
                        $data = [];
                        $success = false;
                        $msg = 'Error';
                        try {

                            $resultExecutePayPal = $payment->execute($execution, $apiContext);

                            try {
                                $payment = Payment::get($paymentId, $apiContext);
                                $data['payment'] = $payment;
                                $msg = 'Se realizo correctamente el pago.';
                                $success = true;
                                $modelOrderShipping = new OrderPaymentsManager();
                                $paramsOrderShipping = [
                                    'user_id' => $manager_id,
                                    'OrderShopping' => $OrderShopping,
                                    'OrderBillingDetails' => $OrderBillingDetails,
                                    'OrderBillingCustomer' => $OrderBillingCustomer,
                                    'Payments' => [
                                        'resultExecutePayPal' => $resultExecutePayPal,
                                        'PaymentPost' => $Payment,
                                        'PaymentResult' => $payment,
                                        'type' => OrderPaymentsManager::TYPE_PAYMENT_CUSTOMER_PAYPAL
                                    ],
                                    'BUSINESS_MANAGER_ID' => self::BUSINESS_MANAGER_ID
                                ];
                                try {

                                    $managerOrderShipping = $modelOrderShipping->saveDataManagerOrderShipping($paramsOrderShipping);
                                    $success = $managerOrderShipping['success'];
                                    if (!$success) {
                                        $data['errors'] = $managerOrderShipping['errors'];
                                        /*  $msg = $managerOrderShipping['msj'];*/
                                        $msg = $this->getDataMessageString([
                                            'data' => $data['errors']
                                        ]);

                                        $data = ['typeError' => 7]; //saveDataManagerOrderShipping
                                    } else {

                                        $data = $managerOrderShipping['data'];
                                        $msg = $managerOrderShipping['msj'];
                                        $dataResult = $managerOrderShipping['data'];
                                        $modelOPM = $dataResult['OrderPaymentsManager'];
                                        $contactSubject = 'Información de Orden';
                                        $customerName = $OrderBillingCustomer->first_name . ' ' . $OrderBillingCustomer->last_name;
                                        $customerEmail = $OrderBillingCustomer->payer_email;
                                        $contactMessage = '<p>Se realizo correctamente el pago ,la orden se entregara luego de 1 dia laborable</p>';
                                        $contactOrderTitle = '<h1> Orden #' . $modelOPM->manager_id . ' o codigo de registro #' . $modelOPM->id . '</h1>';
                                        if ($OrderBillingCustomer->same_billing_address == false) {
                                            $customerName = $OrderBillingCustomer->billing_first_name . ' ' . $OrderBillingCustomer->billing_last_name;
                                            $customerEmail = $OrderBillingCustomer->billing_payer_email;
                                        }
                                        $checkoutId = $data['ManagerCheckout']['OrderShoppingCart']->id;
                                        $locationCheckout = route("checkoutDetails", app()->getLocale()) . '/' . $checkoutId;
                                        $contactMessage .= '<a href="' . $locationCheckout . '">Link para ver el detalle de su Pedido </a>';
                                        $dataMessage = [

                                            'contactSubject' => $contactSubject,
                                            'customerName' => $customerName,
                                            'customerEmail' => $customerEmail,
                                            'contactMessage' => $contactMessage,
                                            'contactOrderTitle' => $contactOrderTitle,
                                        ];
                                        $emailUtil = new  EmailUtil();
                                        $typeTemplate = 'checkout';
                                        $data['email-customer'] = $emailUtil->sendMailCustomerShop(
                                            [
                                                'mailSend' => $customerEmail,
                                                'typeTemplate' => $typeTemplate,
                                                'dataMessage' => $dataMessage
                                            ]
                                        );
                                        $typeTemplate = 'checkoutForm';
                                        $contactSubject = 'Información de Orden';
                                        $customerName = $OrderBillingCustomer->first_name . ' ' . $OrderBillingCustomer->last_name;
                                        $customerEmail = $OrderBillingCustomer->payer_email;
                                        if ($OrderBillingCustomer->same_billing_address == false) {
                                            $customerName = $OrderBillingCustomer->billing_first_name . ' ' . $OrderBillingCustomer->billing_last_name;
                                            $customerEmail = $OrderBillingCustomer->billing_payer_email;
                                        }
                                        $contactMessage = '<p>Entrega de Productos .</p>';
                                        $contactOrderTitle = '<h1> Orden #' . $modelOPM->manager_id . ' o codigo de registro #' . $modelOPM->id . '</h1>';
                                        $dataMessage = [
                                            'contactSubject' => $contactSubject,
                                            'customerName' => $customerName,
                                            'customerEmail' => $customerEmail,
                                            'contactMessage' => $contactMessage,
                                            'contactOrderTitle' => $contactOrderTitle,
                                        ];
                                        $data['email-supervisor'] = $emailUtil->sendMailByPages(
                                            [
                                                'mailSend' => $customerEmail,
                                                'typeTemplate' => $typeTemplate,
                                                'dataMessage' => $dataMessage,
                                                'typePage' => 4,
                                                'business_id' => self::BUSINESS_MANAGER_ID
                                            ]
                                        );
                                    }
                                } catch (\Exception $ex) {

                                    $success = false;
                                    $msg = 'No se gestiono los pagos.' . $ex->getMessage();
                                    $typeError = 6;
                                    $data = ['typeError' => $typeError]; //Save Order Checkout
                                    $data['errors'] = $ex;
                                    $message = $msg . ' error: ' . $typeError;
                                }
                            } catch (\Exception $ex) {
                                $success = false;
                                $msg = 'Get Paymentez :' . $ex->getMessage();
                                $typeError = 5;
                                $data = ['typeError' => $typeError]; //Api Get
                                $data['errors'] = $ex;
                                $message = $msg . ' error: ' . $typeError;
                            }
                        } catch (\Exception $ex) {
                            $success = false;
                            $msg = 'Error No realizo el pago Api :' . $ex->getMessage();
                            $typeError = 4;

                            $data = ['typeError' => $typeError]; //Api
                            $data['errors'] = $ex;
                            $message = $msg . ' error: ' . $typeError;
                        }
                    } else {
                        $success = false;
                        $msg = 'Error Not manager User';
                        $msg = $this->getDataMessageString([
                            'data' => $resultUser['errors']
                        ]);
                        $typeError = 3;
                        $data = ['typeError' => $typeError]; //User
                        $data['errors'] = $resultUser['errors'];
                        $message = $msg . ' error: ' . $typeError;
                    }
                } catch (Exception $e) {
                    $typeError = 2;
                    $data = ['typeError' => $typeError]; //server
                    $msj = 'Error Server' . $e->getMessage();
                    $success = false;
                    $message = $msg . ' error: ' . $typeError;
                }
            } else { //Not manager Payment
                $success = false;
                $typeError = 1;
                $data = ['typeError' => $typeError];
                $msg = 'Not manager Payment';
                $message = $msg . ' error: ' . $typeError;
            }
        } else { //Not manager Template
            $success = false;
            $typeError = 0;
            $data = ['typeError' => $typeError];
            $msg = 'Not manager Template';
            $message = $msg . ' error: ' . $typeError;
        }


        return $params = [
            'success' => $success,
            'data' => $data,
            'msg' => $msg,
            'message' => $message
        ];
    }


    public function executePaymentBank2()
    {


        $modelT = new TemplateInformation();
        $templateInformation = $modelT->getTemplateMainFrontend(array('business_id' => self::BUSINESS_MANAGER_ID));
        $account_bank = '';
        $number_bank = '';
        if ($templateInformation != false) {
            $template_information_id = $templateInformation->id;
            $modelTP = new TemplatePayments();
            $paramsCurrent['filters'] = [
                'template_information_id' => $template_information_id,
                'type_payment' => $modelTP::TYPE_PAYMENT_BANK_DEPOSIT, 'status' => 'ACTIVE'
            ];

            $resultData = $modelTP->getTypesPayments($paramsCurrent);
            if ($resultData != false) {
                $account_bank = $resultData->user;
                $number_bank = $resultData->password;
            }
        }

        $dataPost = Request::all();
        $paramsRequest = $dataPost['params'];
        $manager_id = $dataPost['manager_id'];
        $type_payment = $dataPost['type_payment'];
        $source = null;
        if ($type_payment == 'bank-deposit') { //bank deposit
            $source = $dataPost['source'];
        }
        $paramsRequest = json_decode($paramsRequest);
        $OrderShopping = $paramsRequest->OrderShopping;
        $OrderBillingDetails = json_decode($paramsRequest->OrderBillingDetails);
        $OrderBillingCustomer = $paramsRequest->OrderBillingCustomer;
        $data = [];
        $success = false;
        $msg = 'Error';
        $msg = 'Se realizo correctamente el pago.';
        $success = true;
        $modelOrderShipping = new OrderPaymentsManager();
        $paramsOrderShipping = [
            'user_id' => $manager_id,
            'OrderShopping' => $OrderShopping,
            'OrderBillingDetails' => $OrderBillingDetails,
            'OrderBillingCustomer' => $OrderBillingCustomer,
            'Payments' => [
                'type' => OrderPaymentsManager::TYPE_PAYMENT_CUSTOMER_BANK_DEPOSIT
            ],
            'BUSINESS_MANAGER_ID' => self::BUSINESS_MANAGER_ID,
            'OrderPaymentsDocument' => [
                'source' => $source,
                'account_bank' => $account_bank,
                'number_bank' => $number_bank,

            ]
        ];
        try {

            $managerOrderShipping = $modelOrderShipping->saveDataManagerOrderShipping($paramsOrderShipping);
            $success = $managerOrderShipping['success'];
            if (!$success) {
                $data['errors'] = $managerOrderShipping['errors'];
                $msg = $managerOrderShipping['msj'];
            } else {


                $msg = $managerOrderShipping['msj'];
                $dataResult = $managerOrderShipping['data'];
                $modelOPM = $dataResult['OrderPaymentsManager'];
                $contactSubject = 'Información de Orden';
                $customerName = $OrderBillingCustomer->first_name . ' ' . $OrderBillingCustomer->last_name;
                $customerEmail = $OrderBillingCustomer->payer_email;
                $contactMessage = '<p>Para poder realizar el envio debemos verificar el deposito realizado a la empresa, aproximadamente el tiempo de verificacion es 2 horas ,todo dependiendo del banco.<br> Al realizar la verificacion si es valida se enviara un correo al cliente para el envio.</p>';
                $contactOrderTitle = '<h1> Orden #' . $modelOPM->manager_id . ' o codigo de registro #' . $modelOPM->id . '</h1>';

                if ($OrderBillingCustomer->same_billing_address == false) {
                    $customerName = $OrderBillingCustomer->billing_first_name . ' ' . $OrderBillingCustomer->billing_last_name;
                    $customerEmail = $OrderBillingCustomer->billing_payer_email;
                }
                $dataMessage = [
                    'contactSubject' => $contactSubject,
                    'customerName' => $customerName,
                    'customerEmail' => $customerEmail,
                    'contactMessage' => $contactMessage,
                    'contactOrderTitle' => $contactOrderTitle,
                ];
                $emailUtil = new  EmailUtil();
                $typeTemplate = 'checkout';
                $data['email-customer'] = $emailUtil->sendMailCustomerShop(
                    [
                        'mailSend' => $customerEmail,
                        'typeTemplate' => $typeTemplate,
                        'dataMessage' => $dataMessage
                    ]
                );
                $typeTemplate = 'checkoutForm';
                $contactSubject = 'Información de Orden';
                $customerName = $OrderBillingCustomer->first_name . ' ' . $OrderBillingCustomer->last_name;
                $customerEmail = $OrderBillingCustomer->payer_email;
                $contactMessage = '<p>Verificar el documento de deposito Orden .</p><p>' . $modelOPM->manager_id . ' o codigo de registro #' . $modelOPM->id . '</p>';
                $contactOrderTitle = '<h1> Orden #' . $modelOPM->manager_id . ' o codigo de registro #' . $modelOPM->id . '</h1>';
                $dataMessage = [
                    'contactSubject' => $contactSubject,
                    'customerName' => $customerName,
                    'customerEmail' => $customerEmail,
                    'contactMessage' => $contactMessage,
                    'contactOrderTitle' => $contactOrderTitle,
                ];
                $data['email-supervisor'] = $emailUtil->sendMailByPages(
                    [
                        'mailSend' => $customerEmail,
                        'typeTemplate' => $typeTemplate,
                        'dataMessage' => $dataMessage,
                        'typePage' => 4,
                        'business_id' => self::BUSINESS_MANAGER_ID
                    ]
                );
            }
        } catch (\Exception $ex) {

            $success = false;
            $data['error'] = $ex;
            $msg = 'No se gestiono los pagos.' . $ex->getMessage();
            return $params = [
                'success' => $success,
                'data' => $data,
                'msg' => $msg
            ];
        }


        return $params = [
            'success' => $success,
            'data' => $data,
            'msg' => $msg
        ];
    }

    public function executePaymentBank()
    {


        $credential = null;
        $requestId = null;
        $ALLOW_PRODUCTION_PAYMENT = null;
        $modelT = new TemplateInformation();
        $templateInformation = $modelT->getTemplateMainFrontend(array('business_id' => self::BUSINESS_MANAGER_ID));
        $success = false;
        $data = [];
        $msg = '';
        $allowSaveSales = false;
        DB::beginTransaction();
        try {
            if ($templateInformation != false) {
                $template_information_id = $templateInformation->id;
                $modelTP = new TemplatePayments();
                $paramsCurrent['filters'] = [
                    'template_information_id' => $template_information_id,
                    'type_payment' => $modelTP::TYPE_PAYMENT_BANK_DEPOSIT, 'status' => 'ACTIVE'
                ];

                $resultData = $modelTP->getTypesPayments($paramsCurrent);

                if ($resultData != false) {
                    $ALLOW_PRODUCTION_PAYMENT = $resultData->type_manager == 1 ? true : false;
                    $credential = $resultData->user;
                    $requestId = $resultData->password;
                    $dataPost = Request::all();
                    $paramsRequest = $dataPost['params'];


                    $paramsRequest = json_decode($paramsRequest);
                    $User = $paramsRequest->User;
                    $manager_user_new = $User->create_account == 'true';
                    $manager_id = $User->id == 'null' ? null : $User->id;
                    //STEP 1  MANAGER USER CURRENT
                    //a) Not user login
                    $allowManagerNext = true;
                    $resultUser = null;

                    if ($manager_id == null && $manager_user_new) { //new user
                        $modelUserUtil = new UtilUser();

                        $resultUser = $modelUserUtil->managerUserCheckout([
                            'typePayment' => UtilUser::TYPE_PAYMENT_PAYPAL,
                            'dataCheckout' => $paramsRequest,
                            'userData'
                        ]);

                        $allowManagerNext = $resultUser['success'];
                        if ($allowManagerNext) {
                            $userSave = $resultUser['data']['User'];
                            $manager_id = $userSave->id;
                        } else {

                            $msgCurrent = "";
                            foreach ($resultUser["errors"] as $key => $value) {
                                $msgCurrent .= $value;
                            }
                            $success = false;
                            $msg = $resultUser["msj"] ." ". $msgCurrent;
                            throw new \Exception($msg);
                        }

                    }
                    if ($allowManagerNext) {
                        //STEP MANAGER CHECKOUT
                        $OrderShopping = $paramsRequest->OrderShopping;
                        $OrderBillingDetails = json_decode($paramsRequest->OrderBillingDetails);
                        $OrderBillingCustomer = $paramsRequest->OrderBillingCustomer;
                        $data = [];
                        $success = false;
                        $msg = 'Error';
                        $msg = 'Se realizo correctamente el pago.';
                        $success = true;
                        $modelOrderShipping = new OrderPaymentsManager();
                        $source = $dataPost['source'];
                        $account_bank = $credential;
                        $number_bank = $requestId;

                        $paramsOrderShipping = [
                            'user_id' => $manager_id,
                            'OrderShopping' => $OrderShopping,
                            'OrderBillingDetails' => $OrderBillingDetails,
                            'OrderBillingCustomer' => $OrderBillingCustomer,
                            'Payments' => [
                                'type' => OrderPaymentsManager::TYPE_PAYMENT_CUSTOMER_BANK_DEPOSIT
                            ],
                            'BUSINESS_MANAGER_ID' => self::BUSINESS_MANAGER_ID,
                            'OrderPaymentsDocument' => [
                                'source' => $source,
                                'account_bank' => $account_bank,
                                'number_bank' => $number_bank,
                            ]
                        ];
                        try {

                            $managerOrderShipping = $modelOrderShipping->saveDataManagerOrderShipping($paramsOrderShipping);

                            $success = $managerOrderShipping['success'];
                            $allowSaveSales = $success;
                            if (!$success) {
                                $data['errors'] = $managerOrderShipping['errors'];
                                $msg = $this->getDataMessageString([
                                    'data' => $data['errors']
                                ]);
                                $data = ['typeError' => 7]; //saveDataManagerOrderShipping
                            } else {


                                $data = $managerOrderShipping['data'];
                                $msg = $managerOrderShipping['msj'];
                                $dataResult = $managerOrderShipping['data'];
                                $modelOPM = $dataResult['OrderPaymentsManager'];
                                $contactSubject = 'Información de Orden';
                                $customerName = $OrderBillingCustomer->first_name . ' ' . $OrderBillingCustomer->last_name;
                                $customerEmail = $OrderBillingCustomer->payer_email;
                                $contactMessage = '<p>Para poder realizar el envio debemos verificar el deposito realizado a la empresa, aproximadamente el tiempo de verificacion es 2 horas ,todo dependiendo del banco.<br> Al realizar la verificacion si es valida se enviara un correo al cliente para el envio.</p>';

                                $checkoutId = $data['ManagerCheckout']['OrderShoppingCart']->id;
                                $locationCheckout = route("checkoutDetails", app()->getLocale()) . '/' . $checkoutId;

                                $contactMessage .= '<a href="' . $locationCheckout . '">Link para ver el detalle de su Pedido </a>';
                                $contactOrderTitle = '<h1> Orden #' . $modelOPM->manager_id . ' o codigo de registro #' . $modelOPM->id . '</h1>';

                                if ($OrderBillingCustomer->same_billing_address == false) {
                                    $customerName = $OrderBillingCustomer->billing_first_name . ' ' . $OrderBillingCustomer->billing_last_name;
                                    $customerEmail = $OrderBillingCustomer->billing_payer_email;
                                }
                                $checkoutId = $data['ManagerCheckout']['OrderShoppingCart']->id;
                                $locationCheckout = route("checkoutDetails", app()->getLocale()) . '/' . $checkoutId;

                                $contactMessage .= '<a href="' . $locationCheckout . '">Link para ver el detalle de su Pedido </a>';
                                $dataMessage = [
                                    'contactSubject' => $contactSubject,
                                    'customerName' => $customerName,
                                    'customerEmail' => $customerEmail,
                                    'contactMessage' => $contactMessage,
                                    'contactOrderTitle' => $contactOrderTitle,
                                ];
                                if (env('allowSendMailSaleOnline')) {
                                    $emailUtil = new  EmailUtil();
                                    $typeTemplate = 'checkout';
                                    $data['email-customer'] = $emailUtil->sendMailCustomerShop(
                                        [
                                            'mailSend' => $customerEmail,
                                            'typeTemplate' => $typeTemplate,
                                            'dataMessage' => $dataMessage
                                        ]
                                    );
                                    $typeTemplate = 'checkoutForm';
                                    $contactSubject = 'Información de Orden';
                                    $customerName = $OrderBillingCustomer->first_name . ' ' . $OrderBillingCustomer->last_name;
                                    $customerEmail = $OrderBillingCustomer->payer_email;
                                    if ($OrderBillingCustomer->same_billing_address == false) {
                                        $customerName = $OrderBillingCustomer->billing_first_name . ' ' . $OrderBillingCustomer->billing_last_name;
                                        $customerEmail = $OrderBillingCustomer->billing_payer_email;
                                    }
                                    $contactMessage = '<p>Entrega de Productos .</p>';
                                    $contactOrderTitle = '<h1> Orden #' . $modelOPM->manager_id . ' o codigo de registro #' . $modelOPM->id . '</h1>';
                                    $dataMessage = [
                                        'contactSubject' => $contactSubject,
                                        'customerName' => $customerName,
                                        'customerEmail' => $customerEmail,
                                        'contactMessage' => $contactMessage,
                                        'contactOrderTitle' => $contactOrderTitle,
                                    ];
                                    $data['email-supervisor'] = $emailUtil->sendMailByPages(
                                        [
                                            'mailSend' => $customerEmail,
                                            'typeTemplate' => $typeTemplate,
                                            'dataMessage' => $dataMessage,
                                            'typePage' => 4,
                                            'business_id' => self::BUSINESS_MANAGER_ID
                                        ]
                                    );
                                } else {
                                    $msg = "Advertencia no se configuro para enviar Correo.";
                                }

                            }
                        } catch (\Exception $ex) {
                            $success = false;
                            $errorMessage = "";
                            if ($allowSaveSales) {
                                $success = $allowSaveSales;
                            } else {
                                $errorMessage = "Error de Envio  de Correo consulte al Administrador";
                            }

                            $msg = $errorMessage . $ex->getMessage();
                            $data = ['typeError' => 6]; //Save Order Checkout
                            $data['errors'] = $ex;
                        }
                    } else {
                        $success = false;
                        $msg = 'Not manager User';
                        $msg = $this->getDataMessageString([
                            'data' => $resultUser['errors']
                        ]);
                        $data = ['typeError' => 3]; //User
                        $data['errors'] = $resultUser['errors'];
                    }
                } else { //Not manager Payment
                    $success = false;
                    $data = ['typeError' => 1];
                    $msg = 'Not manager Payment';
                }
            } else { //Not manager Template
                $success = false;
                $data = [];
                $msg = 'Not manager Template';
            }

            if (!$success) {
                DB::rollBack();

            } else {
                DB::commit();
            }
        } catch (Exception $e) {
            DB::rollBack();
            $msj = $e->getMessage();
            $success = false;


        }


        return $params = [
            'success' => $success,
            'data' => $data,
            'msg' => $msg
        ];
    }

    public function executePaymentCreditCards()
    {
        $credential = null;
        $requestId = null;
        $ALLOW_PRODUCTION_PAYMENT = null;
        $modelT = new TemplateInformation();
        $templateInformation = $modelT->getTemplateMainFrontend(array('business_id' => self::BUSINESS_MANAGER_ID));
        $success = false;
        $data = [];
        $msg = 'Realizado Con exito.';
        $resultDataPayment = null;
        if ($templateInformation != false) {
            $template_information_id = $templateInformation->id;
            $modelTP = new TemplatePayments();
            $paramsCurrent['filters'] = [
                'template_information_id' => $template_information_id,
                'type_payment' => $modelTP::TYPE_PAYMENT_CREDIT_CARDS, 'status' => 'ACTIVE'
            ];

            $resultData = $modelTP->getTypesPayments($paramsCurrent);
            $resultDataPayment = $resultData;
            if ($resultData != false) {
                $ALLOW_PRODUCTION_PAYMENT = $resultData->type_manager == 1 ? true : false;
                $credential = $ALLOW_PRODUCTION_PAYMENT ? $resultData->live_id : $resultData->test_id;
                $requestId = $ALLOW_PRODUCTION_PAYMENT ? $resultData->live_secret : $resultData->test_secret;
                $dataPost = Request::all();
                $paramsRequest = isset($dataPost['params']) ? $dataPost['params'] : $dataPost;
                $paramsRequest = json_decode($paramsRequest);
                $Payment = $paramsRequest->Payment;
                $transaction = $Payment->transaction;

                $User = $paramsRequest->User;
                $manager_user_new = $User->create_account == 'true';
                $manager_id = $User->id == 'null' ? null : $User->id;

                //STEP 1  MANAGER USER CURRENT
                //a) Not user login
                try {

                    $allowManagerNext = true;
                    $resultUser = null;
                    if ($manager_id == null && $manager_user_new) { //new user
                        $modelUserUtil = new UtilUser();
                        $resultUser = $modelUserUtil->managerUserCheckout([
                            'typePayment' => UtilUser::TYPE_PAYMENT_PAYPAL,
                            'dataCheckout' => $paramsRequest,
                            'userData'
                        ]);
                        $allowManagerNext = $resultUser['success'];
                        $userSave = $resultUser['data']['User'];
                        $manager_id = $userSave->id;
                    }
                    if ($allowManagerNext) {
                        //STEP MANAGER CHECKOUT
                        $OrderShopping = $paramsRequest->OrderShopping;
                        $OrderBillingDetails = json_decode($paramsRequest->OrderBillingDetails);
                        $OrderBillingCustomer = $paramsRequest->OrderBillingCustomer;
                        $Payment = $paramsRequest->Payment;

                        $data = [];
                        $success = false;
                        $msg = 'Error';
                        try {

                            //emit credit card

                            try {
                                $payment = [];
                                $data['payment'] = $payment;
                                $msg = 'Se realizo correctamente el pago.';
                                $success = true;
                                $modelOrderShipping = new OrderPaymentsManager();
                                $paramsOrderShipping = [
                                    'user_id' => $manager_id,
                                    'OrderShopping' => $OrderShopping,
                                    'OrderBillingDetails' => $OrderBillingDetails,
                                    'OrderBillingCustomer' => $OrderBillingCustomer,
                                    'Payments' => [
                                        'PaymentPost' => $Payment,
                                        'PaymentResult' => $payment,
                                        'type' => OrderPaymentsManager::TYPE_PAYMENT_CUSTOMER_API_CREDIT_CARDS
                                    ],
                                    'BUSINESS_MANAGER_ID' => self::BUSINESS_MANAGER_ID
                                ];
                                try {

                                    $managerOrderShipping = $modelOrderShipping->saveDataManagerOrderShipping($paramsOrderShipping);
                                    $success = $managerOrderShipping['success'];
                                    if (!$success) {
                                        $data['errors'] = $managerOrderShipping['errors'];
                                        $msg = $this->getDataMessageString([
                                            'data' => $data['errors']
                                        ]);
                                        $data = ['typeError' => 7]; //saveDataManagerOrderShipping
                                    } else {
                                        $data = $managerOrderShipping['data'];
                                        $msg = $managerOrderShipping['msj'];
                                        $dataResult = $managerOrderShipping['data'];
                                        $modelOPM = $dataResult['OrderPaymentsManager'];
                                        $dataMessage = $this->getManagerMailPayment([
                                            'typePayment' => 2,
                                            'typeManagerUser' => 0,
                                            'OrderBillingCustomer' => $OrderBillingCustomer,
                                            'OrderPaymentsManager' => $modelOPM,
                                            'ManagerCheckout' => $data['ManagerCheckout'],
                                            'OrderShoppingCart' => $data['ManagerCheckout']['OrderShoppingCart'],
                                            'paymentManager' => $Payment

                                        ]);
                                        $mailSend = $dataMessage['mailSend'];
                                        $typeTemplate = $dataMessage['typeTemplate'];
                                        $emailUtil = new  EmailUtil();
                                        $data['email-customer'] = $emailUtil->sendMailCustomerShop(
                                            [
                                                'mailSend' => $mailSend,
                                                'typeTemplate' => $typeTemplate,
                                                'dataMessage' => $dataMessage
                                            ]
                                        );
                                        $dataMessage = $this->getManagerMailPayment([
                                            'typePayment' => 2,
                                            'typeManagerUser' => 1,
                                            'OrderBillingCustomer' => $OrderBillingCustomer,
                                            'OrderPaymentsManager' => $modelOPM,
                                            'ManagerCheckout' => $data['ManagerCheckout'],
                                            'OrderShoppingCart' => $data['ManagerCheckout']['OrderShoppingCart'],
                                            'paymentManager' => $Payment

                                        ]);
                                        $mailSend = $dataMessage['mailSend'];
                                        $typeTemplate = $dataMessage['typeTemplate'];
                                        $data['email-supervisor'] = $emailUtil->sendMailByPages(
                                            [
                                                'mailSend' => $mailSend,
                                                'typeTemplate' => $typeTemplate,
                                                'dataMessage' => $dataMessage,
                                                'typePage' => 4,
                                                'business_id' => self::BUSINESS_MANAGER_ID
                                            ]
                                        );
                                    }
                                } catch (\Exception $ex) {

                                    $success = false;
                                    $msg = 'No se gestiono los pagos.' . $ex->getMessage();
                                    $data = ['typeError' => 6]; //Save Order Checkout
                                    $data['errors'] = $ex;
                                }
                            } catch (\Exception $ex) {
                                $success = false;
                                $msg = 'Get Paymentez :' . $ex->getMessage();
                                $data = ['typeError' => 5]; //Api Get
                                $data['errors'] = $ex;
                            }
                        } catch (\Exception $ex) {
                            $success = false;
                            $msg = 'No realizo el pago Api :' . $ex->getMessage();
                            $data = ['typeError' => 4]; //Api
                            $data['errors'] = $ex;
                        }
                    } else {
                        $success = false;
                        $msg = 'Not manager User';
                        $msg = $this->getDataMessageString([
                            'data' => $resultUser['errors']
                        ]);
                        $data = ['typeError' => 3]; //User
                        $data['errors'] = $resultUser['errors'];
                    }
                } catch (Exception $e) {
                    $data = ['typeError' => 2]; //server
                    $msj = 'Error Server' . $e->getMessage();
                    $success = false;
                }
            } else { //Not manager Payment
                $success = false;
                $data = ['typeError' => 1];
                $msg = 'Not manager Payment';
            }
        } else { //Not manager Template
            $success = false;
            $data = [];
            $msg = 'Not manager Template';
        }
        if (!$success) {
            $transaction_id = $transaction->id;
            $resultCurrent = $this->refundManager(['resultData' => $resultDataPayment, 'manager_id' => $transaction_id]);
            $msg = $resultCurrent['msg'];
            $data['managementRefund'] = $resultCurrent;
        }

        return [
            'success' => $success,
            'data' => $data,
            'msg' => $msg,
            'message' => $msg
        ];
    }


    public function createPaymentPaymentez(Request $request)
    {
        $otherFetch = false;

        $credential = '';
        $requestId = '';
        $applicationCode = '';
        $applicationKey = '';
        $modelT = new TemplateInformation();
        $templateInformation = $modelT->getTemplateMainFrontend(array('business_id' => self::BUSINESS_MANAGER_ID));
        $ALLOW_PRODUCTION_PAYMENT = self::ALLOW_PRODUCTION_PAYMENTEZ;
        if ($templateInformation != false) {
            $template_information_id = $templateInformation->id;
            $modelTP = new TemplatePayments();
            $paramsCurrent['filters'] = [
                'template_information_id' => $template_information_id,
                'type_payment' => $modelTP::TYPE_PAYMENT_CREDIT_CARDS, 'status' => 'ACTIVE'
            ];

            $resultData = $modelTP->getTypesPayments($paramsCurrent);
            if ($resultData != false) {
                $ALLOW_PRODUCTION_PAYMENT = $resultData->type_manager == 1 ? true : false;
                $credential = $ALLOW_PRODUCTION_PAYMENT ? $resultData->live_id : $resultData->test_id;
                $requestId = $ALLOW_PRODUCTION_PAYMENT ? $resultData->live_secret : $resultData->test_secret;
            }
            $applicationCode = $credential;
            $applicationKey = $requestId;
        }

        // First setup your credentials provided by paymentez
        $applicationCode = "SOME_APP_CODE";
        $applicationKey = "SOME_APP_KEY";

        Paymentez::init($applicationCode, $applicationKey, $ALLOW_PRODUCTION_PAYMENT);

        $card = Paymentez::card();
        $userId = "1";
        $listOfUserCards = $card->getList($userId);

        $totalSizeOfCardList = $listOfUserCards->result_size;
        $listCards = $listOfUserCards->cards;

        // Get all data of response
        $response = $listOfUserCards->getData();

        // Catch fail response

        try {
            $listOfUserCards = $card->getList("someUID");
        } catch (PaymentezErrorException $error) {

            // Details of exception
            echo $error->getMessage();
            // You can see the logs for complete information
        }
    }

    public function getDataMessageString($params)
    {
        $result = '';
        $data = is_array($params['data']) ? $params['data'] : [];
        foreach ($data as $key => $value) {
            $result .= $value;
        }
        return $result;
    }

    public function getManagerMailPayment($params)
    {
        $allowRoutes = env('allowRoutes');
        $result = [];
        $typePayment = $params['typePayment'];
        $typeManagerUser = $params['typeManagerUser'];
        $typeCustomer = 0;
        $typeSellerManager = 1;
        $contactSubject = '';
        $customerName = '';
        $customerEmail = '';
        $contactMessage = '';
        $contactOrderTitle = '';
        $mailSend = '';
        $typeTemplate = '';
        if ($typePayment == 0) { //pay pal

        } else if ($typePayment == 2) { //credit Card

            $OrderBillingCustomer = $params['OrderBillingCustomer'];
            $modelOPM = $params['OrderPaymentsManager'];
            $paymentManager = $params['paymentManager'];
            $OrderShoppingCart = $params['OrderShoppingCart'];
            if ($typeManagerUser == $typeCustomer) {

                $contactSubject = $allowRoutes ? 'Información de Orden de Registro de Evento' : 'Información de Orden';
                $customerName = $OrderBillingCustomer->first_name . ' ' . $OrderBillingCustomer->last_name;
                $customerEmail = $OrderBillingCustomer->payer_email;
                $contactOrderTitle = '<h1> Orden #' . $modelOPM->manager_id . ' o codigo de registro #' . $modelOPM->id . '</h1>';
                $contactOrderTitle .= '<h2><span class="title">Autorización:</span> <span class="value">' . $paymentManager->transaction->authorization_code . '</span></h2>';
                $contactOrderTitle .= '<h3><span class="title">Transacción Referencia:</span> <span class="value">' . $paymentManager->card->transaction_reference . '</span></h3>';
                $msg = $allowRoutes ? ',los kits se entregara el dia del evento.' : ',la orden se entregara luego de 1 dia laborable';
                $contactMessage .= '<p>Se realizo correctamente el pago(' . $paymentManager->transaction->amount . ') ' . $msg . '</p>';
                if ($OrderBillingCustomer->same_billing_address == false) {
                    $customerName = $OrderBillingCustomer->billing_first_name . ' ' . $OrderBillingCustomer->billing_last_name;
                    $customerEmail = $OrderBillingCustomer->billing_payer_email;
                }
                $checkoutId = $OrderShoppingCart->id;
                $locationCheckout = route("checkoutDetails", app()->getLocale()) . '/' . $checkoutId;
                $msg = $allowRoutes ? 'Link para ver el detalle de su Orden de Registro de Evento' : 'Link para ver el detalle de su Orden';

                $contactMessage .= '<a href="' . $locationCheckout . '">' . $msg . '</a>';
                $mailSend = $customerEmail;
                $typeTemplate = 'checkout';
            } else if ($typeManagerUser == $typeSellerManager) {

                $typeTemplate = 'checkoutForm';
                $contactSubject = 'Información de Orden';
                $customerName = $OrderBillingCustomer->first_name . ' ' . $OrderBillingCustomer->last_name;
                $customerEmail = $OrderBillingCustomer->payer_email;
                if ($OrderBillingCustomer->same_billing_address == false) {
                    $customerName = $OrderBillingCustomer->billing_first_name . ' ' . $OrderBillingCustomer->billing_last_name;
                    $customerEmail = $OrderBillingCustomer->billing_payer_email;
                }
                $contactMessage = '<p>Entrega de Productos .</p>';
                $contactOrderTitle = '<h1> Orden #' . $modelOPM->manager_id . ' o codigo de registro #' . $modelOPM->id . '</h1>';
                $contactOrderTitle .= '<h2><span class="title">Autorización:</span> <span class="value">' . $paymentManager->transaction->authorization_code . '</span></h2>';
                $contactOrderTitle .= '<h3><span class="title">Transacción Referencia:</span> <span class="value">' . $paymentManager->card->transaction_reference . '</span></h3>';
            }
        } else if ($typePayment == 2) { //bank

        }
        $result = [

            'contactSubject' => $contactSubject,
            'customerName' => $customerName,
            'customerEmail' => $customerEmail,
            'contactMessage' => $contactMessage,
            'contactOrderTitle' => $contactOrderTitle,
            'mailSend' => $mailSend,
            'typeTemplate' => $typeTemplate
        ];
        return $result;
    }

    public function capturePaymentCreditCards($params)
    {
        $charge = $params['charge'];
        $transactionId = $params['transactionId'];
        $success = false;
        $data = [];
        $msg = 'None';

        try {

            $viewData = $charge->capture('DF-4760');
            $data['viewData'] = $viewData;
            $success = true;
        } catch (PaymentezErrorException $error) {
            $code = $error->getCode();
            $message = $error->getMessage();
            $msg = 'Code Error Capture:' . $code . ' mensaje:' . $message;
            $success = false;
        }


        $result = [
            'success' => $success,
            'data' => $data,
            'msg' => $msg
        ];

        return $result;
    }

    public function refundManager($params)
    {
        $resultData = $params['resultData'];
        $manager_id = $params['manager_id'];

        $success = true;

        $ALLOW_PRODUCTION_PAYMENT = $resultData->type_manager == 1 ? true : false;

        $credential = $resultData->test_id; //codigo
        $requestId = $resultData->test_secret; //server key
        $data['payment-api'] = $resultData;
        $server_application_code = $credential;
        $server_app_key = $requestId;
        $applicationCode = $server_application_code;
        $applicationKey = $server_app_key;

        $date = new \DateTime();
        $unix_timestamp = $date->getTimestamp();
        // $unix_timestamp = "1546543146";
        $uniq_token_string = $server_app_key . $unix_timestamp;
        $uniq_token_hash = hash('sha256', $uniq_token_string);
        $auth_token = base64_encode($server_application_code . ";" . $unix_timestamp . ";" . $uniq_token_hash);

        $success = true;

        $transaction_id = $manager_id;
        $urlrefund = 'https://ccapi.paymentez.com/v2/transaction/refund/';
        $data = array('id' => $transaction_id);
        $ch = curl_init($urlrefund);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        $payload = json_encode(array("transaction" => $data));
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
            'Auth-Token:' . $auth_token
        ));
        $response = curl_exec($ch);
        $refundManager = json_decode($response, true);
        $msg = 'Se reembolso con exito.';
        $status = 'info';
        if (isset($refundManager['error'])) {
            $status = 'error';
            $msg = 'No existe un registro para reembolsar con este condigo :' . $transaction_id;
        } else if ($refundManager['status'] == 'success') {
            $status = 'success';
        } else if ($refundManager['status'] == 'failure') {
            $status = 'warning';
            $msg = 'Anteriormente se realizo el reembolso';
        }
        $data['refundManager'] = $refundManager;
        $success = $status == 'success' ? true : false;


        return [
            'success' => $success,
            'status' => $status,
            'message' => $msg,
            'data' => $data,
            'msg' => $msg
        ];
    }

    public function refundPaymentCreditCards()
    {
        //https://developers.paymentez.com/docs/payments/
        $credential = null;
        $requestId = null;
        $ALLOW_PRODUCTION_PAYMENT = null;
        $modelT = new TemplateInformation();
        $templateInformation = $modelT->getTemplateMainFrontend(array('business_id' => self::BUSINESS_MANAGER_ID));
        $success = false;
        $data = [];
        $msg = '';
        $transaction_id = null;
        $charge = null;
        $status = 'warning';

        if ($templateInformation != false) {
            $template_information_id = $templateInformation->id;
            $modelTP = new TemplatePayments();
            $paramsCurrent['filters'] = [
                'template_information_id' => $template_information_id,
                'type_payment' => $modelTP::TYPE_PAYMENT_CREDIT_CARDS, 'status' => 'ACTIVE'
            ];
            $resultData = $modelTP->getTypesPayments($paramsCurrent);
            if ($resultData != false) {
                $success = true;
                $dataPost = Request::all();
                $transaction_id = $dataPost['manager_id'];
                $resultCurrent = $this->refundManager(['resultData' => $resultData, 'manager_id' => $transaction_id]);
                $success = $resultCurrent['success'];
                $status = $resultCurrent['status'];
                $data = $resultCurrent['data'];
                $msg = $resultCurrent['msg'];
            } else { //Not manager Payment
                $success = false;
                $data = ['typeError' => 1];
                $msg = 'Not manager Payment';
            }
        } else { //Not manager Template
            $success = false;
            $data = [];
            $msg = 'Not manager Template';
        }
        return [
            'success' => $success,
            'status' => $status,
            'message' => $msg,
            'data' => $data,
            'msg' => $msg
        ];
    }

    public function executePaymentCashEvents()
    {


        $credential = null;
        $requestId = null;
        $ALLOW_PRODUCTION_PAYMENT = null;
        $modelT = new TemplateInformation();
        $templateInformation = $modelT->getTemplateMainFrontend(array('business_id' => self::BUSINESS_MANAGER_ID));
        $success = false;
        $data = [];
        $msg = '';


        if ($templateInformation != false) {
            $template_information_id = $templateInformation->id;
            $modelTP = new TemplatePayments();
            $paramsCurrent['filters'] = [
                'template_information_id' => $template_information_id,
                'type_payment' => $modelTP::TYPE_PAYMENT_BANK_DEPOSIT, 'status' => 'ACTIVE'
            ];

            $resultData = ['user' => 'Alex', 'password' => '12345679'];
            if ($resultData != false) {

                $credential = $resultData['user'];
                $requestId = $resultData['password'];
                $dataPost = Request::all();
                $paramsRequest = $dataPost['params'];


                $paramsRequest = json_decode($paramsRequest);
                $pointsSales = $paramsRequest->PointsSales;

                $events_trails_registration_points_id = $pointsSales->events_trails_registration_points_id;

                $User = $paramsRequest->User;
                $manager_user_new = $User->create_account == 'true';
                $manager_id = $User->id == 'null' ? null : $User->id;
                //STEP 1  MANAGER USER CURRENT
                //a) Not user login
                $allowManagerNext = true;
                $resultUser = null;
                if ($manager_id == null && $manager_user_new) { //new user
                    $modelUserUtil = new UtilUser();
                    $resultUser = $modelUserUtil->managerUserCheckout([
                        'typePayment' => UtilUser::TYPE_PAYMENT_CASH,
                        'dataCheckout' => $paramsRequest,
                        'userData'
                    ]);
                    $allowManagerNext = $resultUser['success'];
                    $userSave = $resultUser['data']['User'];
                    $manager_id = $userSave->id;
                }
                if ($allowManagerNext) {
                    //STEP MANAGER CHECKOUT
                    $OrderShopping = $paramsRequest->OrderShopping;
                    $OrderBillingDetails = json_decode($paramsRequest->OrderBillingDetails);
                    $OrderBillingCustomer = $paramsRequest->OrderBillingCustomer;
                    $data = [];
                    $success = false;
                    $msg = 'Se realizo correctamente el pago.';
                    $success = true;
                    $modelOrderShipping = new OrderPaymentsManager();

                    $account_bank = $credential;
                    $number_bank = $requestId;
                    $paramsOrderShipping = [
                        'user_id' => $manager_id,
                        'OrderShopping' => $OrderShopping,
                        'OrderBillingDetails' => $OrderBillingDetails,
                        'OrderBillingCustomer' => $OrderBillingCustomer,
                        'Payments' => [
                            'type' => OrderPaymentsManager::TYPE_PAYMENT_CUSTOMER_CASH
                        ],
                        'BUSINESS_MANAGER_ID' => self::BUSINESS_MANAGER_ID,
                        'type_registration' => 1

                    ];
                    try {
                        $managerOrderShipping = $modelOrderShipping->saveDataManagerOrderShippingEvents($paramsOrderShipping);
                        $success = $managerOrderShipping['success'];
                        if (!$success) {
                            $data['errors'] = $managerOrderShipping['errors'];
                            $msg = $this->getDataMessageString([
                                'data' => $data['errors']
                            ]);
                            $data = ['typeError' => 7]; //saveDataManagerOrderShipping
                        } else {


                            $data = $managerOrderShipping['data'];
                            $msg = $managerOrderShipping['msj'];
                            $dataResult = $managerOrderShipping['data'];
                            $modelOPM = $dataResult['OrderPaymentsManager'];
                            $contactSubject = 'Información de Orden';
                            $customerName = $OrderBillingCustomer->first_name . ' ' . $OrderBillingCustomer->last_name;
                            $customerEmail = $OrderBillingCustomer->payer_email;
                            $contactMessage = '<p>Para poder realizar el envio debemos verificar el deposito realizado a la empresa, aproximadamente el tiempo de verificacion es 2 horas ,todo dependiendo del banco.<br> Al realizar la verificacion si es valida se enviara un correo al cliente para el envio.</p>';

                            $checkoutId = $data['ManagerCheckout']['OrderShoppingCart']->id;
                            $locationCheckout = route("checkoutDetails", app()->getLocale()) . '/' . $checkoutId;

                            $contactMessage .= '<a href="' . $locationCheckout . '">Link para ver el detalle de su Evento Registrado </a>';
                            $contactOrderTitle = '<h1> Orden #' . $modelOPM->manager_id . ' o codigo de registro #' . $modelOPM->id . '</h1>';

                            if ($OrderBillingCustomer->same_billing_address == false) {
                                $customerName = $OrderBillingCustomer->billing_first_name . ' ' . $OrderBillingCustomer->billing_last_name;
                                $customerEmail = $OrderBillingCustomer->billing_payer_email;
                            }
                            $order_shopping_cart_id = $data['ManagerCheckout']['OrderShoppingCart']->id;
                            $checkoutId = $order_shopping_cart_id;
                            $locationCheckout = route("checkoutDetails", app()->getLocale()) . '/' . $checkoutId;

                            $contactMessage .= '<a href="' . $locationCheckout . '">Link para ver el detalle de su Evento Registrado </a>';
                            $dataMessage = [
                                'contactSubject' => $contactSubject,
                                'customerName' => $customerName,
                                'customerEmail' => $customerEmail,
                                'contactMessage' => $contactMessage,
                                'contactOrderTitle' => $contactOrderTitle,
                            ];
                            $emailUtil = new  EmailUtil();
                            $typeTemplate = 'checkout';
                            $data['email-customer'] = $emailUtil->sendMailCustomerShop(
                                [
                                    'mailSend' => $customerEmail,
                                    'typeTemplate' => $typeTemplate,
                                    'dataMessage' => $dataMessage
                                ]
                            );
                            $typeTemplate = 'checkoutForm';
                            $contactSubject = 'Información de Orden';
                            $customerName = $OrderBillingCustomer->first_name . ' ' . $OrderBillingCustomer->last_name;
                            $customerEmail = $OrderBillingCustomer->payer_email;
                            if ($OrderBillingCustomer->same_billing_address == false) {
                                $customerName = $OrderBillingCustomer->billing_first_name . ' ' . $OrderBillingCustomer->billing_last_name;
                                $customerEmail = $OrderBillingCustomer->billing_payer_email;
                            }
                            $contactMessage = '<p>Entrega de Productos .</p>';
                            $contactOrderTitle = '<h1> Orden #' . $modelOPM->manager_id . ' o codigo de registro #' . $modelOPM->id . '</h1>';
                            $dataMessage = [
                                'contactSubject' => $contactSubject,
                                'customerName' => $customerName,
                                'customerEmail' => $customerEmail,
                                'contactMessage' => $contactMessage,
                                'contactOrderTitle' => $contactOrderTitle,
                            ];
                            $data['email-supervisor'] = $emailUtil->sendMailByPages(
                                [
                                    'mailSend' => $customerEmail,
                                    'typeTemplate' => $typeTemplate,
                                    'dataMessage' => $dataMessage,
                                    'typePage' => 4,
                                    'business_id' => self::BUSINESS_MANAGER_ID
                                ]
                            );


                            /*MANAGEMENT OWNER BUSINESS PAYMENTS*/
                            $modelPaymentCash = new \App\Models\EventsTrailsRegistrationPaymentsByBusiness();
                            $modelPaymentCash->events_trails_registration_points_id = $events_trails_registration_points_id;
                            $modelPaymentCash->order_shopping_cart_id = $order_shopping_cart_id;
                            $modelPaymentCash->save();
                        }
                    } catch (\Exception $ex) {

                        $success = false;
                        $msg = 'No se gestiono los pagos.' . $ex->getMessage();
                        $data = ['typeError' => 6]; //Save Order Checkout
                        $data['errors'] = $ex;
                    }
                } else {
                    $success = false;
                    $msg = 'Not manager User';
                    $msg = $this->getDataMessageString([
                        'data' => $resultUser['errors']
                    ]);
                    $data = ['typeError' => 3]; //User
                    $data['errors'] = $resultUser['errors'];
                }
            } else { //Not manager Payment
                $success = false;
                $data = ['typeError' => 1];
                $msg = 'Not manager Payment';
            }
        } else { //Not manager Template
            $success = false;
            $data = [];
            $msg = 'Not manager Template';
        }


        return $params = [
            'success' => $success,
            'data' => $data,
            'msg' => $msg
        ];
    }

    public function executePaymentBankEvents()
    {


        $credential = null;
        $requestId = null;
        $ALLOW_PRODUCTION_PAYMENT = null;
        $modelT = new TemplateInformation();
        $templateInformation = $modelT->getTemplateMainFrontend(array('business_id' => self::BUSINESS_MANAGER_ID));
        $success = false;
        $data = [];
        $msg = '';

        if ($templateInformation != false) {
            $template_information_id = $templateInformation->id;
            $modelTP = new TemplatePayments();
            $paramsCurrent['filters'] = [
                'template_information_id' => $template_information_id,
                'type_payment' => $modelTP::TYPE_PAYMENT_BANK_DEPOSIT, 'status' => 'ACTIVE'
            ];

            $resultData = $modelTP->getTypesPayments($paramsCurrent);
            if ($resultData != false) {
                $ALLOW_PRODUCTION_PAYMENT = $resultData->type_manager == 1 ? true : false;
                $credential = $resultData->user;
                $requestId = $resultData->password;
                $dataPost = Request::all();
                $paramsRequest = $dataPost['params'];


                $paramsRequest = json_decode($paramsRequest);
                $User = $paramsRequest->User;
                $manager_user_new = $User->create_account == 'true';
                $manager_id = $User->id == 'null' ? null : $User->id;
                //STEP 1  MANAGER USER CURRENT
                //a) Not user login
                $allowManagerNext = true;
                $resultUser = null;
                if ($manager_id == null && $manager_user_new) { //new user
                    $modelUserUtil = new UtilUser();
                    $resultUser = $modelUserUtil->managerUserCheckout([
                        'typePayment' => UtilUser::TYPE_PAYMENT_PAYPAL,
                        'dataCheckout' => $paramsRequest,
                        'userData'
                    ]);
                    $allowManagerNext = $resultUser['success'];
                    $userSave = $resultUser['data']['User'];
                    $manager_id = $userSave->id;
                }
                if ($allowManagerNext) {
                    //STEP MANAGER CHECKOUT
                    $OrderShopping = $paramsRequest->OrderShopping;
                    $OrderBillingDetails = json_decode($paramsRequest->OrderBillingDetails);
                    $OrderBillingCustomer = $paramsRequest->OrderBillingCustomer;
                    $data = [];
                    $success = false;
                    $msg = 'Error';
                    $msg = 'Se realizo correctamente el pago.';
                    $success = true;
                    $modelOrderShipping = new OrderPaymentsManager();
                    $source = $dataPost['source'];
                    $account_bank = $credential;
                    $number_bank = $requestId;
                    $paramsOrderShipping = [
                        'user_id' => $manager_id,
                        'OrderShopping' => $OrderShopping,
                        'OrderBillingDetails' => $OrderBillingDetails,
                        'OrderBillingCustomer' => $OrderBillingCustomer,
                        'Payments' => [
                            'type' => OrderPaymentsManager::TYPE_PAYMENT_CUSTOMER_BANK_DEPOSIT
                        ],
                        'BUSINESS_MANAGER_ID' => self::BUSINESS_MANAGER_ID,
                        'OrderPaymentsDocument' => [
                            'source' => $source,
                            'account_bank' => $account_bank,
                            'number_bank' => $number_bank,
                        ]
                    ];
                    try {
                        $managerOrderShipping = $modelOrderShipping->saveDataManagerOrderShippingEvents($paramsOrderShipping);
                        $success = $managerOrderShipping['success'];
                        if (!$success) {
                            $data['errors'] = $managerOrderShipping['errors'];
                            $msg = $this->getDataMessageString([
                                'data' => $data['errors']
                            ]);
                            $data = ['typeError' => 7]; //saveDataManagerOrderShipping
                        } else {


                            $data = $managerOrderShipping['data'];
                            $msg = $managerOrderShipping['msj'];
                            $dataResult = $managerOrderShipping['data'];
                            $modelOPM = $dataResult['OrderPaymentsManager'];
                            $contactSubject = 'Información de Orden';
                            $customerName = $OrderBillingCustomer->first_name . ' ' . $OrderBillingCustomer->last_name;
                            $customerEmail = $OrderBillingCustomer->payer_email;
                            $contactMessage = '<p>Para poder realizar el envio debemos verificar el deposito realizado a la empresa, aproximadamente el tiempo de verificacion es 2 horas ,todo dependiendo del banco.<br> Al realizar la verificacion si es valida se enviara un correo al cliente para el envio.</p>';

                            $checkoutId = $data['ManagerCheckout']['OrderShoppingCart']->id;
                            $locationCheckout = route("checkoutDetails", app()->getLocale()) . '/' . $checkoutId;

                            $contactMessage .= '<a href="' . $locationCheckout . '">Link para ver el detalle de su Evento Registrado </a>';
                            $contactOrderTitle = '<h1> Orden #' . $modelOPM->manager_id . ' o codigo de registro #' . $modelOPM->id . '</h1>';

                            if ($OrderBillingCustomer->same_billing_address == false) {
                                $customerName = $OrderBillingCustomer->billing_first_name . ' ' . $OrderBillingCustomer->billing_last_name;
                                $customerEmail = $OrderBillingCustomer->billing_payer_email;
                            }
                            $checkoutId = $data['ManagerCheckout']['OrderShoppingCart']->id;
                            $locationCheckout = route("checkoutDetails", app()->getLocale()) . '/' . $checkoutId;

                            $contactMessage .= '<a href="' . $locationCheckout . '">Link para ver el detalle de su Evento Registrado </a>';
                            $dataMessage = [
                                'contactSubject' => $contactSubject,
                                'customerName' => $customerName,
                                'customerEmail' => $customerEmail,
                                'contactMessage' => $contactMessage,
                                'contactOrderTitle' => $contactOrderTitle,
                            ];
                            $emailUtil = new  EmailUtil();
                            $typeTemplate = 'checkout';
                            $data['email-customer'] = $emailUtil->sendMailCustomerShop(
                                [
                                    'mailSend' => $customerEmail,
                                    'typeTemplate' => $typeTemplate,
                                    'dataMessage' => $dataMessage
                                ]
                            );
                            $typeTemplate = 'checkoutForm';
                            $contactSubject = 'Información de Orden';
                            $customerName = $OrderBillingCustomer->first_name . ' ' . $OrderBillingCustomer->last_name;
                            $customerEmail = $OrderBillingCustomer->payer_email;
                            if ($OrderBillingCustomer->same_billing_address == false) {
                                $customerName = $OrderBillingCustomer->billing_first_name . ' ' . $OrderBillingCustomer->billing_last_name;
                                $customerEmail = $OrderBillingCustomer->billing_payer_email;
                            }
                            $contactMessage = '<p>Entrega de Productos .</p>';
                            $contactOrderTitle = '<h1> Orden #' . $modelOPM->manager_id . ' o codigo de registro #' . $modelOPM->id . '</h1>';
                            $dataMessage = [
                                'contactSubject' => $contactSubject,
                                'customerName' => $customerName,
                                'customerEmail' => $customerEmail,
                                'contactMessage' => $contactMessage,
                                'contactOrderTitle' => $contactOrderTitle,
                            ];
                            $data['email-supervisor'] = $emailUtil->sendMailByPages(
                                [
                                    'mailSend' => $customerEmail,
                                    'typeTemplate' => $typeTemplate,
                                    'dataMessage' => $dataMessage,
                                    'typePage' => 4,
                                    'business_id' => self::BUSINESS_MANAGER_ID
                                ]
                            );
                        }
                    } catch (\Exception $ex) {

                        $success = false;
                        $msg = 'No se gestiono los pagos.' . $ex->getMessage();
                        $data = ['typeError' => 6]; //Save Order Checkout
                        $data['errors'] = $ex;
                    }
                } else {
                    $success = false;
                    $msg = 'Not manager User';
                    $msg = $this->getDataMessageString([
                        'data' => $resultUser['errors']
                    ]);
                    $data = ['typeError' => 3]; //User
                    $data['errors'] = $resultUser['errors'];
                }
            } else { //Not manager Payment
                $success = false;
                $data = ['typeError' => 1];
                $msg = 'Not manager Payment';
            }
        } else { //Not manager Template
            $success = false;
            $data = [];
            $msg = 'Not manager Template';
        }


        return $params = [
            'success' => $success,
            'data' => $data,
            'msg' => $msg
        ];
    }

    public function createPaymentPayPalEvents(Request $request)
    {
        $otherFetch = false;
        $credential = self::ALLOW_PRODUCTION_PAY_PAL ? self::API_LIVE_CLIENT_ID : self::SAND_BOX_CLIENT_ID;
        $requestId = self::ALLOW_PRODUCTION_PAY_PAL ? self::API_LIVE_SECRET : self::SAND_BOX_SECRET;
        $modelT = new TemplateInformation();
        $templateInformation = $modelT->getTemplateMainFrontend(array('business_id' => self::BUSINESS_MANAGER_ID));
        $ALLOW_PRODUCTION_PAYMENT = self::ALLOW_PRODUCTION_PAY_PAL;
        if ($templateInformation != false) {
            $template_information_id = $templateInformation->id;
            $modelTP = new TemplatePayments();
            $paramsCurrent['filters'] = [
                'template_information_id' => $template_information_id,
                'type_payment' => $modelTP::TYPE_PAYMENT_PAYPAL, 'status' => 'ACTIVE'
            ];

            $resultData = $modelTP->getTypesPayments($paramsCurrent);
            if ($resultData != false) {
                $ALLOW_PRODUCTION_PAYMENT = $resultData->type_manager == 1 ? true : false;
                $credential = $ALLOW_PRODUCTION_PAYMENT ? $resultData->live_id : $resultData->test_id;
                $requestId = $ALLOW_PRODUCTION_PAYMENT ? $resultData->live_secret : $resultData->test_secret;
            }
        }

        $aut = new OAuthTokenCredential(
            $credential,
            $requestId
        );
        $apiContext = new ApiContext($aut);
        if ($ALLOW_PRODUCTION_PAYMENT) {
            $apiContext->setConfig(
                array(
                    'mode' => 'live',

                )
            );
        }
        $dataPost = Request::all();
        if ($otherFetch) {
            $paramsPost = $request->getContent();
            $paramsRequest = json_decode($paramsPost);
            $dataPost['params'] = $paramsRequest->params;
        }
        $paramsRequest = $dataPost['params'];
        $paramsRequest = json_decode($paramsRequest);

        $OrderShopping = $paramsRequest->OrderShopping;
        $OrderBillingDetails = json_decode($paramsRequest->OrderBillingDetails);
        $OrderBillingCustomer = $paramsRequest->OrderBillingCustomer;
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $itemsData = [];

        /*CUSTOMER*/
        if (self::ALLOW_PRODUCTION_PAY_PAL) {
            if (false) {

                $inputFields = new InputFields();
                $inputFields->setNoShipping(1);
                $addressSend = $OrderBillingCustomer->address_main . ' , ' . $OrderBillingCustomer->address_secondary . '.';
                $inputFields->setAddressOverride($addressSend);
                $webProfile = new WebProfile();
                $nameProfile = $OrderBillingCustomer->first_name . ' ' . $OrderBillingCustomer->last_name;
                $webProfile->setName($nameProfile)->setInputFields($inputFields);
                $webProfileId = $webProfile->create($apiContext)->getId();
            }
        }
        foreach ($OrderBillingDetails as $key => $row) {
            $itemCurrent = new Item();
            $nameProduct = $row->name . ' - ' . $row->code;
            $priceProduct = $row->price;
            $countProduct = $row->count;

            $itemCurrent->setName($nameProduct)
                ->setCurrency(self::CURRENCY)
                ->setQuantity($countProduct)
                ->setSku($row->id)
                ->setPrice($priceProduct);
            $itemsData[] = $itemCurrent;
        }
        $itemList = new ItemList();
        $itemList->setItems($itemsData);

        $details = new Details();
        $details->setShipping($OrderShopping->shipping)
            ->setTax(0)
            ->setSubtotal($OrderShopping->subtotal);
        $total = $OrderShopping->subtotal;
        $amount = new Amount();
        $amount->setTotal($total)
            ->setCurrency(self::CURRENCY)
            ->setDetails($details);
        $invoiceNumber = uniqid();
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription($OrderShopping->description)
            ->setInvoiceNumber($invoiceNumber);
        $urlEnd = URL('paymentSend');
        $urlCancel = URL('shop');

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($urlEnd)
            ->setCancelUrl($urlCancel);

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));
        $result = [];
        try {
            $payment->create($apiContext);
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            exit(1);
        }


        return $payment;
    }

    public function executePaymentPayPalEvents()
    {
        $credential = null;
        $requestId = null;
        $ALLOW_PRODUCTION_PAYMENT = null;
        $modelT = new TemplateInformation();
        $templateInformation = $modelT->getTemplateMainFrontend(array('business_id' => self::BUSINESS_MANAGER_ID));
        $success = false;
        $data = [];
        $msg = '';

        if ($templateInformation != false) {
            $template_information_id = $templateInformation->id;
            $modelTP = new TemplatePayments();
            $paramsCurrent['filters'] = [
                'template_information_id' => $template_information_id,
                'type_payment' => $modelTP::TYPE_PAYMENT_PAYPAL, 'status' => 'ACTIVE'
            ];

            $resultData = $modelTP->getTypesPayments($paramsCurrent);
            if ($resultData != false) {
                $ALLOW_PRODUCTION_PAYMENT = $resultData->type_manager == 1 ? true : false;
                $credential = $ALLOW_PRODUCTION_PAYMENT ? $resultData->live_id : $resultData->test_id;
                $requestId = $ALLOW_PRODUCTION_PAYMENT ? $resultData->live_secret : $resultData->test_secret;
                $dataPost = Request::all();
                $paramsRequest = $dataPost['params'];


                $paramsRequest = json_decode($paramsRequest);
                $User = $paramsRequest->User;
                $manager_user_new = $User->create_account == 'true';
                $manager_id = $User->id == 'null' ? null : $User->id;

                //STEP 1  MANAGER USER CURRENT
                //a) Not user login
                try {

                    $allowManagerNext = true;
                    $resultUser = null;
                    if ($manager_id == null && $manager_user_new) { //new user
                        $modelUserUtil = new UtilUser();
                        $resultUser = $modelUserUtil->managerUserCheckout([
                            'typePayment' => UtilUser::TYPE_PAYMENT_PAYPAL,
                            'dataCheckout' => $paramsRequest,
                            'userData'
                        ]);
                        $allowManagerNext = $resultUser['success'];
                        $userSave = $resultUser['data']['User'];
                        $manager_id = $userSave->id;
                    }
                    if ($allowManagerNext) {
                        //STEP MANAGER CHECKOUT
                        $OrderShopping = $paramsRequest->OrderShopping;
                        $OrderBillingDetails = json_decode($paramsRequest->OrderBillingDetails);

                        $OrderBillingCustomer = $paramsRequest->OrderBillingCustomer;

                        $aut = new OAuthTokenCredential(
                            $credential,
                            $requestId
                        );
                        $apiContext = new ApiContext($aut);
                        $Payment = $paramsRequest->Payment;

                        $amount = new Amount();
                        $transaction = new Transaction();
                        $details = new Details();
                        $details->setShipping($OrderShopping->shipping)
                            ->setTax(0)
                            ->setSubtotal($OrderShopping->subtotal);
                        $total = $OrderShopping->subtotal;
                        $amount->setTotal($total)
                            ->setCurrency(self::CURRENCY)
                            ->setDetails($details);
                        $transaction->setAmount($amount);
                        $paymentId = $Payment->id;
                        $PayerID = $Payment->payerID;
                        $execution = new \PayPal\Api\PaymentExecution();
                        $payment = Payment::get($paymentId, $apiContext);
                        $execution->setPayerId($PayerID);
                        $execution->addTransaction($transaction);
                        $data = [];
                        $success = false;
                        $msg = 'Error';
                        try {

                            $resultExecutePayPal = $payment->execute($execution, $apiContext);

                            try {
                                $payment = Payment::get($paymentId, $apiContext);
                                $data['payment'] = $payment;
                                $msg = 'Se realizo correctamente el pago.';
                                $success = true;
                                $modelOrderShipping = new OrderPaymentsManager();
                                $paramsOrderShipping = [
                                    'user_id' => $manager_id,
                                    'OrderShopping' => $OrderShopping,
                                    'OrderBillingDetails' => $OrderBillingDetails,
                                    'OrderBillingCustomer' => $OrderBillingCustomer,
                                    'Payments' => [
                                        'resultExecutePayPal' => $resultExecutePayPal,
                                        'PaymentPost' => $Payment,
                                        'PaymentResult' => $payment,
                                        'type' => OrderPaymentsManager::TYPE_PAYMENT_CUSTOMER_PAYPAL
                                    ],
                                    'BUSINESS_MANAGER_ID' => self::BUSINESS_MANAGER_ID
                                ];
                                try {

                                    $managerOrderShipping = $modelOrderShipping->saveDataManagerOrderShippingEvents($paramsOrderShipping);
                                    $success = $managerOrderShipping['success'];
                                    if (!$success) {
                                        $data['errors'] = $managerOrderShipping['errors'];
                                        $msg = $this->getDataMessageString([
                                            'data' => $data['errors']
                                        ]);
                                        $data = ['typeError' => 7]; //saveDataManagerOrderShipping
                                    } else {

                                        $data = $managerOrderShipping['data'];
                                        $msg = $managerOrderShipping['msj'];
                                        $dataResult = $managerOrderShipping['data'];
                                        $modelOPM = $dataResult['OrderPaymentsManager'];
                                        $contactSubject = 'Información de Orden';
                                        $customerName = $OrderBillingCustomer->first_name . ' ' . $OrderBillingCustomer->last_name;
                                        $customerEmail = $OrderBillingCustomer->payer_email;
                                        $contactMessage = '<p>Se realizo correctamente el pago ,la orden se entregara luego de 1 dia laborable</p>';
                                        $contactOrderTitle = '<h1> Orden #' . $modelOPM->manager_id . ' o codigo de registro #' . $modelOPM->id . '</h1>';
                                        if ($OrderBillingCustomer->same_billing_address == false) {
                                            $customerName = $OrderBillingCustomer->billing_first_name . ' ' . $OrderBillingCustomer->billing_last_name;
                                            $customerEmail = $OrderBillingCustomer->billing_payer_email;
                                        }
                                        $checkoutId = $data['ManagerCheckout']['OrderShoppingCart']->id;
                                        $locationCheckout = route("checkoutDetails", app()->getLocale()) . '/' . $checkoutId;
                                        $contactMessage .= '<a href="' . $locationCheckout . '">Link para ver el detalle de su Evento Registrado</a>';
                                        $dataMessage = [

                                            'contactSubject' => $contactSubject,
                                            'customerName' => $customerName,
                                            'customerEmail' => $customerEmail,
                                            'contactMessage' => $contactMessage,
                                            'contactOrderTitle' => $contactOrderTitle,
                                        ];
                                        $emailUtil = new  EmailUtil();
                                        $typeTemplate = 'checkout';
                                        $paramsMail = [
                                            'mailSend' => $customerEmail,
                                            'typeTemplate' => $typeTemplate,
                                            'dataMessage' => $dataMessage
                                        ];

                                        $data['email-customer'] = $emailUtil->sendMailCustomerShop(
                                            $paramsMail
                                        );
                                        $typeTemplate = 'checkoutForm';
                                        $contactSubject = 'Información de Orden';
                                        $customerName = $OrderBillingCustomer->first_name . ' ' . $OrderBillingCustomer->last_name;
                                        $customerEmail = $OrderBillingCustomer->payer_email;
                                        if ($OrderBillingCustomer->same_billing_address == false) {
                                            $customerName = $OrderBillingCustomer->billing_first_name . ' ' . $OrderBillingCustomer->billing_last_name;
                                            $customerEmail = $OrderBillingCustomer->billing_payer_email;
                                        }
                                        $contactMessage = '<p>Entrega de Productos .</p>';
                                        $contactOrderTitle = '<h1> Orden #' . $modelOPM->manager_id . ' o codigo de registro #' . $modelOPM->id . '</h1>';
                                        $dataMessage = [
                                            'contactSubject' => $contactSubject,
                                            'customerName' => $customerName,
                                            'customerEmail' => $customerEmail,
                                            'contactMessage' => $contactMessage,
                                            'contactOrderTitle' => $contactOrderTitle,
                                        ];
                                        $paramsMail = [
                                            'mailSend' => $customerEmail,
                                            'typeTemplate' => $typeTemplate,
                                            'dataMessage' => $dataMessage,
                                            'typePage' => 4,
                                            'business_id' => self::BUSINESS_MANAGER_ID
                                        ];
                                        $data['email-supervisor'] = $emailUtil->sendMailByPages(
                                            $paramsMail
                                        );
                                    }
                                } catch (\Exception $ex) {

                                    $success = false;
                                    $msg = 'No se gestiono los pagos.' . $ex->getMessage();
                                    $data = ['typeError' => 6]; //Save Order Checkout
                                    $data['errors'] = $ex;
                                }
                            } catch (\Exception $ex) {
                                $success = false;
                                $msg = 'Get Paymentez :' . $ex->getMessage();
                                $data = ['typeError' => 5]; //Api Get
                                $data['errors'] = $ex;
                            }
                        } catch (\Exception $ex) {
                            $success = false;
                            $msg = 'No realizo el pago Api :' . $ex->getMessage();
                            $data = ['typeError' => 4]; //Api
                            $data['errors'] = $ex;
                        }
                    } else {
                        $success = false;
                        $msg = 'Not manager User';
                        $msg = $this->getDataMessageString([
                            'data' => $resultUser['errors']
                        ]);
                        $data = ['typeError' => 3]; //User
                        $data['errors'] = $resultUser['errors'];
                    }
                } catch (Exception $e) {
                    $data = ['typeError' => 2]; //server
                    $msj = 'Error Server' . $e->getMessage();
                    $success = false;
                }
            } else { //Not manager Payment
                $success = false;
                $data = ['typeError' => 1];
                $msg = 'Not manager Payment';
            }
        } else { //Not manager Template
            $success = false;
            $data = [];
            $msg = 'Not manager Template';
        }


        return $params = [
            'success' => $success,
            'data' => $data,
            'msg' => $msg
        ];
    }

    public function executePaymentCreditCardsEvents()
    {
        $credential = null;
        $requestId = null;
        $ALLOW_PRODUCTION_PAYMENT = null;
        $modelT = new TemplateInformation();
        $templateInformation = $modelT->getTemplateMainFrontend(array('business_id' => self::BUSINESS_MANAGER_ID));
        $success = false;
        $data = [];
        $msg = '';

        if ($templateInformation != false) {
            $template_information_id = $templateInformation->id;
            $modelTP = new TemplatePayments();
            $paramsCurrent['filters'] = [
                'template_information_id' => $template_information_id,
                'type_payment' => $modelTP::TYPE_PAYMENT_CREDIT_CARDS, 'status' => 'ACTIVE'
            ];

            $resultData = $modelTP->getTypesPayments($paramsCurrent);
            if ($resultData != false) {
                $ALLOW_PRODUCTION_PAYMENT = $resultData->type_manager == 1 ? true : false;
                $credential = $ALLOW_PRODUCTION_PAYMENT ? $resultData->live_id : $resultData->test_id;
                $requestId = $ALLOW_PRODUCTION_PAYMENT ? $resultData->live_secret : $resultData->test_secret;
                $dataPost = Request::all();
                $paramsRequest = isset($dataPost['params']) ? $dataPost['params'] : $dataPost;


                $paramsRequest = json_decode($paramsRequest);
                $User = $paramsRequest->User;
                $manager_user_new = $User->create_account == 'true';
                $manager_id = $User->id == 'null' ? null : $User->id;

                //STEP 1  MANAGER USER CURRENT
                //a) Not user login
                try {

                    $allowManagerNext = true;
                    $resultUser = null;
                    if ($manager_id == null && $manager_user_new) { //new user
                        $modelUserUtil = new UtilUser();
                        $resultUser = $modelUserUtil->managerUserCheckout([
                            'typePayment' => UtilUser::TYPE_PAYMENT_PAYPAL,
                            'dataCheckout' => $paramsRequest,
                            'userData'
                        ]);
                        $allowManagerNext = $resultUser['success'];
                        $userSave = $resultUser['data']['User'];
                        $manager_id = $userSave->id;
                    }
                    if ($allowManagerNext) {
                        //STEP MANAGER CHECKOUT
                        $OrderShopping = $paramsRequest->OrderShopping;
                        $OrderBillingDetails = json_decode($paramsRequest->OrderBillingDetails);
                        $OrderBillingCustomer = $paramsRequest->OrderBillingCustomer;
                        $Payment = $paramsRequest->Payment;

                        $data = [];
                        $success = false;
                        $msg = 'Error';
                        try {

                            //emit credit card

                            try {
                                $payment = [];
                                $data['payment'] = $payment;
                                $msg = 'Se realizo correctamente el pago.';
                                $success = true;
                                $modelOrderShipping = new OrderPaymentsManager();
                                $paramsOrderShipping = [
                                    'user_id' => $manager_id,
                                    'OrderShopping' => $OrderShopping,
                                    'OrderBillingDetails' => $OrderBillingDetails,
                                    'OrderBillingCustomer' => $OrderBillingCustomer,
                                    'Payments' => [
                                        'PaymentPost' => $Payment,
                                        'PaymentResult' => $payment,
                                        'type' => OrderPaymentsManager::TYPE_PAYMENT_CUSTOMER_API_CREDIT_CARDS
                                    ],
                                    'BUSINESS_MANAGER_ID' => self::BUSINESS_MANAGER_ID
                                ];
                                try {

                                    $managerOrderShipping = $modelOrderShipping->saveDataManagerOrderShippingEvents($paramsOrderShipping);
                                    $success = $managerOrderShipping['success'];
                                    if (!$success) {
                                        $data['errors'] = $managerOrderShipping['errors'];
                                        $msg = $this->getDataMessageString([
                                            'data' => $data['errors']
                                        ]);
                                        $data = ['typeError' => 7]; //saveDataManagerOrderShipping
                                    } else {
                                        $data = $managerOrderShipping['data'];
                                        $msg = $managerOrderShipping['msj'];
                                        $dataResult = $managerOrderShipping['data'];
                                        $modelOPM = $dataResult['OrderPaymentsManager'];
                                        $dataMessage = $this->getManagerMailPayment([
                                            'typePayment' => 2,
                                            'typeManagerUser' => 0,
                                            'OrderBillingCustomer' => $OrderBillingCustomer,
                                            'OrderPaymentsManager' => $modelOPM,
                                            'ManagerCheckout' => $data['ManagerCheckout'],
                                            'OrderShoppingCart' => $data['ManagerCheckout']['OrderShoppingCart'],
                                            'paymentManager' => $Payment

                                        ]);
                                        $mailSend = $dataMessage['mailSend'];
                                        $typeTemplate = $dataMessage['typeTemplate'];
                                        $emailUtil = new  EmailUtil();
                                        $data['email-customer'] = $emailUtil->sendMailCustomerShop(
                                            [
                                                'mailSend' => $mailSend,
                                                'typeTemplate' => $typeTemplate,
                                                'dataMessage' => $dataMessage
                                            ]
                                        );
                                        $dataMessage = $this->getManagerMailPayment([
                                            'typePayment' => 2,
                                            'typeManagerUser' => 1,
                                            'OrderBillingCustomer' => $OrderBillingCustomer,
                                            'OrderPaymentsManager' => $modelOPM,
                                            'ManagerCheckout' => $data['ManagerCheckout'],
                                            'OrderShoppingCart' => $data['ManagerCheckout']['OrderShoppingCart'],
                                            'paymentManager' => $Payment

                                        ]);
                                        $mailSend = $dataMessage['mailSend'];
                                        $typeTemplate = $dataMessage['typeTemplate'];
                                        $data['email-supervisor'] = $emailUtil->sendMailByPages(
                                            [
                                                'mailSend' => $mailSend,
                                                'typeTemplate' => $typeTemplate,
                                                'dataMessage' => $dataMessage,
                                                'typePage' => 4,
                                                'business_id' => self::BUSINESS_MANAGER_ID
                                            ]
                                        );
                                    }
                                } catch (\Exception $ex) {

                                    $success = false;
                                    $msg = 'No se gestiono los pagos.' . $ex->getMessage();
                                    $data = ['typeError' => 6]; //Save Order Checkout
                                    $data['errors'] = $ex;
                                }
                            } catch (\Exception $ex) {
                                $success = false;
                                $msg = 'Get Paymentez :' . $ex->getMessage();
                                $data = ['typeError' => 5]; //Api Get
                                $data['errors'] = $ex;
                            }
                        } catch (\Exception $ex) {
                            $success = false;
                            $msg = 'No realizo el pago Api :' . $ex->getMessage();
                            $data = ['typeError' => 4]; //Api
                            $data['errors'] = $ex;
                        }
                    } else {
                        $success = false;
                        $msg = 'Not manager User';
                        $msg = $this->getDataMessageString([
                            'data' => $resultUser['errors']
                        ]);
                        $data = ['typeError' => 3]; //User
                        $data['errors'] = $resultUser['errors'];
                    }
                } catch (Exception $e) {
                    $data = ['typeError' => 2]; //server
                    $msj = 'Error Server' . $e->getMessage();
                    $success = false;
                }
            } else { //Not manager Payment
                $success = false;
                $data = ['typeError' => 1];
                $msg = 'Not manager Payment';
            }
        } else { //Not manager Template
            $success = false;
            $data = [];
            $msg = 'Not manager Template';
        }


        return $params = [
            'success' => $success,
            'data' => $data,
            'msg' => $msg
        ];
    }
}




/*

@if(isset($dataManagerPage['shippingByClient']))
        var allowProduction = false;
        optionsConfig = allowProduction ? {
    // Configure environment
    env: 'production',
            client: {
        production: 'AaVfUBg5Frcy7wnsvGTYHWa1X0nrTQnDE7Gq1F6L5TjkHhYnvB2N43LgId97HVDei3FwXYpbsoZq2X2A'//LIVE_CLIENT_ID
            },
            // Customize button (optional)
            locale: 'es_US',
            style: {
        size: 'large',
                color: 'gold',
                shape: 'pill',
            },

            // Enable Pay Now checkout flow (optional)
            commit: true,

            // Set up a payment
            payment: function (data, actions) {
        return actions.payment.create({
                    transactions: [{
            amount: {
                total: '0.01',
                            currency: 'USD'
                        }
        }]
                });
            },
            // Execute the payment
            onAuthorize: function (data, actions) {
        return actions.payment.execute().then(function () {
                // Show a confirmation message to the buyer
                window.alert('Thank you for your purchase!');
            });
    }
        } : {
    // Configure environment
    env: 'sandbox',
            client: {
        sandbox: 'AczLXF5IQeldkXWigGE4gwrvOk8iBcBN7Ghh0jHQS4BqmOHUqV61I5nFyJzKQJY7TT50GU6o2fzfk7ER',
                production: 'demo_production_client_id'
            },
            // Customize button (optional)
            locale: 'es_US',
            style: {
        size: 'large',
                color: 'gold',
                shape: 'pill',
            },

            // Enable Pay Now checkout flow (optional)
            commit: true,

            // Set up a payment
            payment: function (data, actions) {
        return actions.payment.create({
                    transactions: [{
            amount: {
                total: '0.01',
                            currency: 'USD'
                        }
        }]
                });
            },
            // Execute the payment
            onAuthorize: function (data, actions) {
        return actions.payment.execute().then(function () {
                // Show a confirmation message to the buyer
                window.alert('Thank you for your purchase!');
            });
    }
        };


        @endif*/
