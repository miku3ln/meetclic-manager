<?php

namespace App\Models;

use App\Mail\SendMailCustomer;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Components\Twilio;
use URL;

class MailingByDataSend extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'mailing_by_data_send';

    protected $fillable = array(
        'customer_id',//*
        'email',//*
        'entity_type',//*
        'mailing_template_id',//*
        'date'//*

    );
    protected $attributesData = [
        ['column' => 'customer_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'email', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'date', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],

        ['column' => 'entity_type', 'type' => 'integer', 'defaultValue' => '1', 'required' => 'true'],
        ['column' => 'mailing_template_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'id';

    public static function getRulesModel()
    {
        $rules = ["customer_id" => "required|numeric",
            "email" => "required",
            "date" => "required",

            "entity_type" => "required|numeric",
            "mailing_template_id" => "required|numeric"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,customer.identification_document as customer,
customer.id as customer_id,
information_mail.value as information_mail,
information_mail.id as information_mail_id,
$this->table.entity_type,mailing_template.name as mailing_template,
mailing_template.id as mailing_template_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('customer', 'customer.id', '=', $this->table . '.customer_id');
        $query->join('information_mail', 'information_mail.id', '=', $this->table . '.information_mail_id');
        $query->join('mailing_template', 'mailing_template.id', '=', $this->table . '.mailing_template_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere("customer.identification_document", 'like', '%' . $likeSet . '%');
                $query->orWhere("information_mail.value", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.entity_type', 'like', '%' . $likeSet . '%');
                $query->orWhere("mailing_template.name", 'like', '%' . $likeSet . '%');
            });;

        }

        $recordsTotal = $query->get()->count();
        $pages = 1;
        $total = $recordsTotal; // total items in array
// sort
        $query->orderBy($field, $sort);
// Pagination: $perpage 0; get all data
        if ($perpage > 0) {
            $pages = ceil($total / $perpage); // calculate total pages
            $page = max($page, 1); // get 1 page when $_REQUEST['page'] <= 0
            $page = min($page, $pages); // get last page when $_REQUEST['page'] > $totalPages
            $offset = ($page - 1) * $perpage;
            if ($offset < 0) {
                $offset = 0;
            }
            $query->offset((int)$offset);
            $query->limit((int)$perpage);
        }
        $current_page = isset($params['current']) ? (int)$params['current'] : 0;
        $data = $query->get()->toArray();

        $result['total'] = $total;
        $result['rows'] = $data;
        $result['current'] = $current_page;
        $limit = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $result['rowCount'] = $limit;

        return $result;
    }


    public function saveDataSend($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        DB::beginTransaction();
        try {
            $modelName = 'MailingByDataSend';

            $createUpdate = true;
            $entity_type = 0;
            $template = $attributesPost['template'];
            $mailing_template_id = $attributesPost['template']['id'];

            $mailingByDataSendData = $attributesPost;
            $all_customers = $attributesPost['all_customers'];
            $customersData = [];
            if ($all_customers) {

                $modelCustomer = new \App\Models\Customer();
                $business_id = $attributesPost['business_id'];
                $customersData = $modelCustomer->getAllAdminEmails([
                    'filters' => [
                        'business_id' => $business_id
                    ]
                ]);
            } else {
                $customersData = $attributesPost['customers'];
            }
            if (count($customersData) > 0) {

                $date = \App\Utils\Util::DateCurrent();

                foreach ($customersData as $key => $row) {
                    $setPush = [];
                    $customer_id = 0;
                    $email = null;
                    if ($all_customers) {
                        $customer_id = $row->id;
                        $email = $row->information_mail_value;

                    } else {
                        $customer_id = $row->id;
                        $email = $row->information_mail_value;

                    }
                    $setPush = [
                        'customer_id' => $customer_id,//*
                        'email' => $email,//*
                        'date' => $date,//*
                        'entity_type' => $entity_type,//*
                        'mailing_template_id' => $mailing_template_id//*,

                    ];

                    $attributesSet = $setPush;
                    $paramsValidate = array(
                        'modelAttributes' => $attributesSet,
                        'rules' => self::getRulesModel(),

                    );
                    $validateResult = $this->validateModel($paramsValidate);
                    $success = $validateResult["success"];
                    $rootCurrent = env('APP_IS_SERVER') ? "public" : '';
                    $urlRootImage = URL($rootCurrent . $template['source_main']);

                    if ($success) {
                        $model = new MailingByDataSend();
                        $model->fill($attributesSet);
                        $dataMessage = [];
                        $dataMessage['subject'] = $template['name'];
                        $templateHtml = '<div class="content-message"  style="text-align: center;" >';

                        $templateHtml .= '<img src="' . $urlRootImage . '"   style="text-align: center;">';
                        if ($template['type_template'] == 1) {
                            $templateHtml .= $template['message'];
                        }

                        $templateHtml .= '</div>';

                        $dataMessage['templateHtml'] = $templateHtml;
                        $modelMailSend = new \App\Mail\SendMailCustomer($dataMessage);
                        Mail::to($email)->send($modelMailSend);
                        $success = $model->save();
                    } else {
                        $success = false;
                        $msj = "Problemas al guardar correo";
                        $errors = $validateResult["errors"];
                    }
                }
                if (count(Mail::failures()) > 0) {
                    $success = false;
                    $msj = 'Problemas al enviar un correo electronico.';

                }

            } else {
                $success = false;
                $msj = "No existe clientes para enviar correos.";
                $errors = [
                    ''
                ];
            }


            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success
            ];

            if (!$success) {
                DB::rollBack();

            } else {
                DB::commit();
            }
            return ($result);
        } catch (Exception $e) {

            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors
            );
            return ($result);
        }

    }

    public function saveDataSendData($params)
    {
        $twilio = new Twilio();
//$twilio->createSms();


        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        $dataSend = [];
        $whatsappResult = [];
        $mailResult = [];
        $linkCurrentManager = URL('es/managerInvitationOtavalo');
        DB::beginTransaction();
        try {
            $modelName = 'MailingByDataSend';

            $createUpdate = true;
            $entity_type = 0;
            $template = $attributesPost['template'];
            $mailing_template_id = $attributesPost['template']['id'];

            $mailingByDataSendData = $attributesPost;
            $all_customers = $attributesPost['all_customers'] == "true";

            $customersData = [];
            if ($all_customers) {

                $modelCustomer = new \App\Models\Customer();
                $business_id = $attributesPost['business_id'];
                $customersData = $modelCustomer->getAllAdminEmailsRegisters([
                    'filters' => [
                        'business_id' => $business_id
                    ]
                ]);
            } else {
                $customersData = $attributesPost['customers'];

            }
            if (count($customersData) > 0) {

                $date = \App\Utils\Util::DateCurrent();
                $toCountry = '+593';
                foreach ($customersData as $key => $row) {
                    $setPush = [];
                    $customer_id = 0;
                    $email = null;
                    $toNumber = null;
                    $identification_document='';
                    if ($all_customers) {
                        $customer_id = $row->id;
                        $email = $row->information_mail_value;
                        $information_phone_value = substr($row->information_phone_value, 1);
                        $toNumber = $toCountry . $information_phone_value;
                        $identification_document=$row->identification_document;

                    } else {

                        $customer_id = $row["id"];
                        $email = $row['information_mail_value'];
                        $information_phone_value = substr($row['information_phone_value'], 1);
                        $toNumber = $toCountry . $information_phone_value;
                        $identification_document=$row['identification_document'];
                    }
                    if ($template['type_template'] == 1) {

                        $body = $template['message'];
                    }
                    $body .= $linkCurrentManager.'/'.$identification_document;
                    $sendData = [
                        'to' => $toNumber,
                        'body' => $body,

                    ];
                    $resultSend = $twilio->createSmsWhatsApp($sendData);
                    $success = $resultSend['success'];
                    if ($resultSend['success']) {
                        $success = true;
                    }
                    array_push($whatsappResult, ['result' => $resultSend, 'phone' => $toNumber]);
                    if ($email) {
                        $setPush = [
                            'customer_id' => $customer_id,//*
                            'email' => $email,//*
                            'date' => $date,//*
                            'entity_type' => $entity_type,//*
                            'mailing_template_id' => $mailing_template_id//*,

                        ];

                        $attributesSet = $setPush;
                        $paramsValidate = array(
                            'modelAttributes' => $attributesSet,
                            'rules' => self::getRulesModel(),

                        );
                        $validateResult = $this->validateModel($paramsValidate);
                        $success = $validateResult["success"];
                        $rootCurrent = env('APP_IS_SERVER') ? "public" : '';
                        $urlRootImage = URL($rootCurrent . $template['source_main']);

                        if ($success) {
                            $model = new MailingByDataSend();
                            $model->fill($attributesSet);
                            $dataMessage = [];
                            $dataMessage['subject'] = $template['name'];
                            $templateHtml = '<div class="content-message"  style="text-align: center;" >';

                            $templateHtml .= '<img src="' . $urlRootImage . '"   style="text-align: center;">';
                            if ($template['type_template'] == 1) {
                                $templateHtml .= $template['message'];

                            }
                            $templateHtml .= $linkCurrentManager.'/'.$identification_document;
                            $templateHtml .= '</div>';

                            $dataMessage['templateHtml'] = $templateHtml;
                            $modelMailSend = new \App\Mail\SendMailCustomer($dataMessage);
                            Mail::to($email)->send($modelMailSend);
                            $success = $model->save();
                            array_push($mailResult, [
                                'model' => $model,
                            ]);
                        } else {
                            $success = false;
                            $msj = "Problemas al guardar correo";
                            $errors = $validateResult["errors"];
                        }
                    }

                }
                if (count(Mail::failures()) > 0) {
                    $success = false;
                    $msj = 'Problemas al enviar un correo electronico.';

                }

            } else {
                $success = false;
                $msj = "No existe clientes para enviar correos.";
                $errors = [
                    ''
                ];
            }
            $dataSend = [
                'whatsapp' => $whatsappResult,
                'mail' => $mailResult,

            ];

            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success,
                'data' => $dataSend
            ];

            if (!$success) {
                DB::rollBack();

            } else {
                DB::commit();
            }
            return ($result);
        } catch (Exception $e) {

            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors,
                'data' => $dataSend
            );
            return ($result);
        }

    }

    public function getListSelect2($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue as text";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('customer', 'customer.id', '=', $this->table . '.customer_id');
        $query->join('information_mail', 'information_mail.id', '=', $this->table . '.information_mail_id');
        $query->join('mailing_template', 'mailing_template.id', '=', $this->table . '.mailing_template_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere("customer.identification_document", 'like', '%' . $likeSet . '%');
                $query->orWhere("information_mail.value", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.entity_type', 'like', '%' . $likeSet . '%');
                $query->orWhere("mailing_template.name", 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

}
