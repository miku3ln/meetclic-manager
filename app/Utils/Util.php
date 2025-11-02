<?php

namespace App\Utils;


use App\Models\BusinessByEmployeeProfile;
use App\Models\City;
use App\Models\DeliveryMen;
use App\Models\Order;
use App\Models\PriceByZone;
use App\Models\ProductCategory;
use App\Models\Products\Product;
use App\Models\Role;
use App\Models\TaxByCity;
use App\Models\Zone;
use Auth;
use DateInterval;
use DatePeriod;
use DateTime;
use DateTimeZone;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Support\Facades\Session;
use App;
class Util
{
    const INFORMATION_CUSTOMER_TYPE=0;
    const INFORMATION_BUSINESS_TYPE=1;
    public  $languageData = [
        'en', 'es', 'ki'

    ];
    public  function getLanguageValid($languagePost)
    {
        $languageCurrent = $languagePost;
        $language = 'es';
        if ($languageCurrent == '' || $languageCurrent == null || in_array($language, $this->languageData) == false) {
            $language = 'es';
        } else {
            $language = $languageCurrent;
        }
        return $language;
    }
    public  function setLanguage($request)
    {

        $language = $request->route('language');
        $language = $this->getLanguageValid($language);


        // Guardar el idioma en la sesión y aplicarlo en Laravel
        Session::put('applocale', $language);
        App::setLocale($language);


    }
    public static function sumData($params)
    {
        $data_all = $params["haystack"];
        $keyGetValue = $params["keyGetValue"];//POSITION GET VALUE
        $sumTotal = 0;
        $result = array();
        foreach ($data_all as $key => $value) {

            $sumTotal += $value[$keyGetValue];

        }
        return $sumTotal;
    }

    public function calculatePriceProductByZone(Product $product, Zone $zone)
    {
        $response = [
            'price' => 0.00,
            'vat_calculated' => 0.00,
            'vat' => 0.00,
            'price_total' => 0.00
        ];
        $price_by_zone = PriceByZone::where('zone_id', '=', $zone->id)
            ->where('product_id', '=', $product->id)
            ->first();
        $tax_value = $this->getVatByZone($zone); //ex: 0.12
        if ($price_by_zone) {
            $price = $price_by_zone ? (float)$price_by_zone->price : 0.00;
            $vat_calculated = $price * $tax_value;
            $response = [
                'price' => $price,
                'vat_calculated' => $vat_calculated,
                'vat' => $tax_value,
            ];
        }
        return $response;
    }

    public function calculatePriceProductByLatLong(Product $product, $latitude, $longitude)
    {
        $response = [
            'price' => 0.00,
            'vat_calculated' => 0.00,
            'vat' => 0.00,
            'price_total' => 0.00
        ];
        $zone = $this->findZoneFromLatLong($latitude, $longitude);
        if ($zone) {
            return $this->calculatePriceProductByZone($product, $zone);
        }
        return $response;
    }

    /**
     * @param Zone $zone
     * @return float|int
     */
    public function getVatByZone(Zone $zone)
    {
        $city = $zone->city;
        $tax_by_city = TaxByCity::where('city_id', '=', $city->id)->first();
        $tax = null;
        if ($tax_by_city) {
            $tax = $tax_by_city->tax;
        }
        return $tax ? (float)$tax->value / 100 : 0.00; //ex: 0.12
    }

    /**
     * @param $latitude
     * @param $longitude
     * @return Zone|null
     */
    public function findZoneFromLatLong($latitude, $longitude)
    {
        $point = new Point($latitude, $longitude);
        return Zone::where('status', '=', 'ACTIVE')
            ->contains('polygon_spatial', $point)
            ->first();
    }


    /**
     * Calculate distance in meters between points
     * @param $latitude1
     * @param $longitude1
     * @param $latitude2
     * @param $longitude2
     * @return float|int
     */
    public function calculateDistanceBetweenPoints($latitude1, $longitude1, $latitude2, $longitude2)
    {
        if (($latitude1 == $latitude2) && ($longitude1 == $longitude2)) {
            return 0.00;
        }
        $p1 = deg2rad($latitude1);
        $p2 = deg2rad($latitude2);
        $dp = deg2rad($latitude2 - $latitude1);
        $dl = deg2rad($longitude2 - $longitude1);
        $a = (sin($dp / 2) * sin($dp / 2)) + (cos($p1) * cos($p2) * sin($dl / 2) * sin($dl / 2));
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $r = 6371008; // Earth's average radius, in meters
        $d = $r * $c;
        return $d; // distance, in meters
    }

    /**
     * Get City more nearby of the point
     * @param $latitude
     * @param $longitude
     * @return City|null
     */
    public function findBestCity($latitude, $longitude)
    {
        $response = null;
        $distance_by_city = $this->calculateDistanceByCity($latitude, $longitude);
        usort($distance_by_city, function ($a, $b) {
            return $a['distance'] - $b['distance'];
        });
        $response = $distance_by_city > 0 ? $distance_by_city[0]['city'] : null;
        return $response;
    }

    /**
     * @param $latitude
     * @param $longitude
     * @return array
     */
    public function calculateDistanceByCity($latitude, $longitude)
    {
        $cities = City::where('status', '=', 'ACTIVE')->get();
        $response = [];
        foreach ($cities as $city) {
            $distance = $this->calculateDistanceBetweenPoints($latitude, $longitude, $city->latitude, $city->longitude);
            $response[] = [
                'distance' => $distance,
                'city' => $city
            ];
        }
        return $response;
    }

    /**
     * @param $products
     * @param Zone $zone
     * @return array
     */
    public function calculateProductsByOrder($products, Zone $zone)
    {
        $total = 0.00;
        $vat_calculated = 0.00;
        $subtotal = 0.00;
        $vat = $this->getVatByZone($zone);
        $response = [
            'total' => 0.00,
            'vat_calculated' => 0.00,
            'vat_tax_base' => 0.00,
            'vat' => $vat,
            'subtotal' => 0.00,
            'products' => []
        ];
        foreach ($products as $item) {
            $product = Product::find($item['product_id']);
            $price_calculated = $this->calculatePriceProductByZone($product, $zone);
            $vat_calculated_by_product = $price_calculated['vat_calculated'] * $item['amount'];
            $price_total_by_product = $price_calculated['price'] * $item['amount'];
            $aux = [
                'unit_price' => $price_calculated['price'],
                'amount' => $item['amount'],
                'vat' => $price_calculated['vat'],
                'vat_tax_base' => $price_total_by_product,//precio total del producto sin iva
                'vat_calculated' => $vat_calculated_by_product,
                'total_price' => $vat_calculated_by_product + $price_total_by_product,//precio total del product con iva
                'product_id' => $product->id
            ];
            $response['products'][] = $aux;

            $subtotal += $price_total_by_product;//sumo los total del cada producto sin iva
            $vat_calculated += $vat_calculated_by_product;//sumo los totales(iva) de cada producto
        }
        $total = $subtotal + $vat_calculated;
        $response['total'] = $total;
        $response['subtotal'] = $subtotal;
        $response['vat_calculated'] = $vat_calculated;
        $response['vat_tax_base'] = $subtotal;
        return $response;
    }

    /**
     * Build structure to replicate in firebase
     * @param Order $order
     * @return array
     */
    public function buildStructureOrder(Order $order)
    {
        $zone = $this->findZoneFromLatLong($order->shipping_latitude, $order->shipping_longitude);
        $province = $zone->city->province;
        $country = $province->country;
        return [
            "customerUid" => $order->customer_uid,
            "statusValue" => $order->order_status->value,
            "statusName" => $order->order_status->name,
            "customerName" => $order->customer_name,
            "customerLastName" => $order->customer_last_name,
            "customerPhone" => $order->customer_phone,
            "customerDocumentType" => $order->customer_document_type,
            "customerDocument" => $order->customer_document,
            "shippingNickname" => $order->shipping_nickname,
            "shippingStreetMain" => $order->shipping_street_main,
            "shippingStreetSecondary" => $order->shipping_street_secondary,
            "shippingReference" => $order->shipping_reference,
            "shippingNumber" => $order->shipping_number,
            "shippingLatitude" => (float)$order->shipping_latitude,
            "shippingLongitude" => (float)$order->shipping_longitude,
            'zoneId' => $zone->id,
            'zoneName' => $zone->name,
            'cityId' => $zone->city->id,
            'cityName' => $zone->city->name,
            'provinceId' => $province->id,
            'provinceName' => $province->name,
            'countryId' => $country->id,
            'countryName' => $country->name,
            "externalId" => $order->id,
        ];

    }

    /**
     * @param DeliveryMen $deliveryMen
     * @return array
     */
    public function buildStructureDelivery(DeliveryMen $deliveryMen)
    {
        return [
            "name" => $deliveryMen->name,
            "email" => $deliveryMen->email,
            "externalId" => $deliveryMen->id,
        ];
    }

    /**
     * @param Order $order
     * @return array
     */
    public function buildStructureAssignDeliveryOrder(Order $order)
    {
        $deliveryMen = $order->motorized_log->deliveryMan;
        return [
            "deliveryName" => $deliveryMen->name,
            "deliveryEmail" => $deliveryMen->email,
            "deliveryPhone" => '098023909823',
            "deliveryId" => $deliveryMen->id,
        ];
    }

    /** Actual month last day **/
    function lastMonthDay()
    {
        $month = date('m');
        $year = date('Y');
        $day = date("d", mktime(0, 0, 0, $month + 1, 0, $year));

        return date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
    }

    /** Actual month first day **/
    public static function firstMonthDay()
    {
        $month = date('m');
        $year = date('Y');
        return date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
    }

    public static function DateCurrent($tz = 'America/Guayaquil', $format = "Y-m-d H:i:s")
    {


        $datetime = new DateTime();

        if ($tz) {
            $tz_object = new DateTimeZone($tz);
            $datetime->setTimezone($tz_object);
        }

        return $datetime->format($format);
    }

    public static function FormatDate($dateAt, $type)
    {
        if ($dateAt) {
            $date = str_replace('/', '-', $dateAt);
            $dateAt = date($type, strtotime($date));
            return $dateAt;
        }
    }

    public static function categoriesDate($option_interval, $init, $endDate)
    {
        $categories = array();
        $interval = $option_interval ["interval"];

        $name_format = $option_interval ["name_format"];
        $format_view = "Y/m/d H:i:s";
        switch ($name_format) {
            case "year":
                $format_view = "Y";
                break;
            case "month":
                $format_view = "Y/m";
                $date = "";

                foreach ($endDate as $key => $value) {
                    if ($key == "date") {
                        $date = Util::FormatDate($value, "Y-m-d");
                    }
                }
                $newDate = strtotime($date);
                $newDate = date('d/m/Y', $newDate);
                $endDate = DateTime::createFromFormat('d/m/Y', $newDate)->setTime(0, 0, 0);
                break;
            case "day":
                $format_view = "Y/m/d";
                break;
            case "hour":
                $format_view = "Y/m/d H";
                break;
        }
        $period = new DatePeriod($init, $interval, $endDate);
        $cont = 0;
        foreach ($period as $date) {
            $category = $date->format($option_interval["category_date_format"]);
            $category = Util::translateDate($category);
            $format_visible = $date->format($format_view);
            if ($format_view == "Y") {
                $category = $format_visible;
            }
            $init = $date->format('Y-m-d H:i:s');

            array_push($categories, array("category" => $category, "dateVisible" => $init, "dateCompare" => $format_visible));
        }
        return $categories;
    }

// DURATION INTERVAL_VAL ISO_VALUE
//---------- ------------ ------------
//        59 0 0:0:59.0   PT59S
//        60 0 0:1:0.0    PT1M0S
//        61 0 0:1:1.0    PT1M1S
//      3599 0 0:59:59.0  PT59M59S
//      3600 0 1:0:0.0    PT1H0M0S
//     86399 0 23:59:59.0 PT23H59M59S
    public static function getIntervalTimesOptions($days, $dateInit = "", $dateEnd = "")
    {
        $option_interval = array();
        //horas
        if ($days == 0) {
            $interval = DateInterval::createFromDateString('1 hour');
            $date_add_interval = "PT59M59S";
            $end_fecha_interval = new DateInterval($date_add_interval);
            //ciclo periodos
            $categoria_date_format = "H:i";
            $option_interval ["interval"] = $interval;
            $option_interval ["fin_fecha_interval"] = $end_fecha_interval;
            $option_interval ["category_date_format"] = $categoria_date_format;
            $option_interval ["date_add_interval"] = $date_add_interval;
            $option_interval ["name_format"] = "hour";
        } //dias
        else if ($days >= 1 && $days <= 30) {
            $interval = DateInterval::createFromDateString('1 day');
            $date_add_interval = "PT23H59M59S";
            $end_fecha_interval = new DateInterval($date_add_interval);
            //ciclo periodos
            $categoria_date_format = "d-M";
            $option_interval ["interval"] = $interval;
            $option_interval ["fin_fecha_interval"] = $end_fecha_interval;
            $option_interval ["category_date_format"] = $categoria_date_format;
            $option_interval ["date_add_interval"] = $date_add_interval;
            $option_interval ["name_format"] = "day";
        }
        //semanas
//            case ($days >= 31 && $days <= 83):
//                $interval = DateInterval::createFromDateString('1 week');
//                $end_fecha_interval = new DateInterval('P6DT23H59M59S');
//                //ciclo periodos
//                $categoria_date_format = "d/M";
//                $date_add_interval = "P6DT23H59M59S";
//                $option_interval ["interval"] = $interval;
//                $option_interval ["fin_fecha_interval"] = $end_fecha_interval;
//                $option_interval ["category_date_format"] = $categoria_date_format;
//                $option_interval ["date_add_interval"] = $date_add_interval;
//                $option_interval ["name_format"] = "week";
//
//                break;
        //meses
        else if ($days > 30 && $days < 360) {
            $interval = DateInterval::createFromDateString('1 month');
            $end_fecha_interval = new DateInterval('P6DT23H59M59S');
            //ciclo periodos
            $categoria_date_format = "F";
            $date_add_interval = "PT23H59M59S";
            $option_interval ["interval"] = $interval;
            $option_interval ["fin_fecha_interval"] = $end_fecha_interval;
            $option_interval ["category_date_format"] = $categoria_date_format;
            $option_interval ["date_add_interval"] = $date_add_interval;
            $option_interval ["name_format"] = "month";
        } else if ($days >= 360) {
            $interval = DateInterval::createFromDateString('1 year');
//            $timespan = new Timespan($dateInit, $dateEnd);
            $end_fecha_interval = new DateInterval('P6DT23H59M59S');
            //ciclo periodos
            $categoria_date_format = "F";
            $date_add_interval = "PT23H59M59S";
            $option_interval ["interval"] = $interval;
            $option_interval ["fin_fecha_interval"] = $end_fecha_interval;
            $option_interval ["category_date_format"] = $categoria_date_format;
            $option_interval ["date_add_interval"] = $date_add_interval;
            $option_interval ["name_format"] = "year";
        }
//horas


        return $option_interval;
    }

    public static function formatGroup($init, $endDate)
    {
        //formateamos las fechas a segundos tipo 1374998435
        $difference = strtotime($endDate) - strtotime($init);
        //        parametros
        $dateInit = $init;
        $dateEnd = $endDate;
//        ----OBTNER LAS xAxis CATEGORIAS---
//        ----------------uso para reportes higcharts-----------------
        $init = Util::FormatDate($dateInit, "d/m/Y");
        $endDate = Util::FormatDate($dateEnd, "d/m/Y");
        $init = DateTime::createFromFormat('d/m/Y', $init)->setTime(0, 0, 0);
        $endDate = DateTime::createFromFormat('d/m/Y', $endDate)->setTime(0, 0, 0);
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($init, $interval, $endDate); //frecuencia del intervalo a calcular
        //comprobamos el tiempo que ha pasado en segundos entre las dos fechas
        //floor devuelve el número entero anterior, si es 5.7 devuelve 5
//        var_dump($difference);
        $days = 0;
        $result = "";
        foreach ($period as $date) {
            $days++;
        }

        if ($days == 0) {//horas minutos segundos
            $result = "%Y/%m/%d %H";
        } //dias
        else if ($days > 0 && $days <= 30) {
            $result = "%Y/%m/%d";
        } else if ($days > 30 && $days < 360) {//meses
            $result = "%Y/%m";
        } else if ($days >= 360) {//años
            $result = "%Y";
        }
        return $result;
    }

    public static function stringToBinary($string)
    {
        $characters = str_split($string);

        $binary = [];
        foreach ($characters as $character) {
            $data = unpack('H*', $character);
            $binary[] = base_convert($data[1], 16, 2);
        }

        return implode(' ', $binary);
    }

    public static function binaryToString($binary)
    {
        $binaries = explode(' ', $binary);

        $string = null;
        foreach ($binaries as $binary) {
            $string .= pack('H*', dechex(bindec($binary)));
        }

        return $string;
    }

    public static function translateDate($needle)
    {
        $data_info = array(
            "January" => "Enero",
            "February" => "Febrero",
            "March" => "Marzo",
            "April" => "Abril",
            "May" => "Mayo",
            "June" => "Junio",
            "July" => "Julio",
            "August" => "Agosto",
            "September" => "Septiembre",
            "October" => "Octubre",
            "November" => "Noviembre",
            "December" => "Diciembre",
            "Monday" => "Lunes",
            "Tuesday" => "Martes",
            "Wednesday" => 'Miercoles',
            "Thursday" => 'Jueves',
            "Friday" => "Viernes",
            "Saturday" => 'Sabado',
            "Sunday" => 'Domingo'
        );
        foreach ($data_info as $key => $value) {
            if ($needle == $key) {
                $needle = $value;
            }
        }

        return $needle;
    }

    public static function getCategoriesByDates($params)
    {
        $initDateManager = $params["initDateManager"];
        $endDateManager = $params["endDateManager"];

        $initDate = Util::FormatDate($initDateManager, "d/m/Y");
        $endDate = Util::FormatDate($endDateManager, "d/m/Y");

        $initDate = DateTime::createFromFormat('d/m/Y', $initDate)->setTime(0, 0, 0);
        $endDate = DateTime::createFromFormat('d/m/Y', $endDate)->setTime(0, 0, 0);
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($initDate, $interval, $endDate);
        $dias = 0;
        $typeInterval = "";
        foreach ($period as $date) {
            $dias++;
        }
        $categories = array();
        $option_interval = Util::getIntervalTimesOptions($dias);
        //horas
        if ($dias == 0) {
            $typeInterval = "hours";
            for ($i = 0; $i < 24; $i++) {
                $endDate->add($option_interval ["fin_fecha_interval"]);
            }
            $categories = Util::categoriesDate($option_interval, $initDate, $endDate);

        } //dias
        else if ($dias > 0 && $dias <= 30) {
            $typeInterval = "days";
            $endDate->add($option_interval["fin_fecha_interval"]);
            $categories = Util::categoriesDate($option_interval, $initDate, $endDate);

        } else if ($dias > 30 && $dias < 360) {//meses
            $categories = Util::categoriesDate($option_interval, $initDate, $endDate);
            $typeInterval = "months";

        } else if ($dias >= 360) {//años
            $endDateManager = $params["endDateManager"];
            $explode_data_fin = explode("-", $endDateManager);
            $endDate = $explode_data_fin[0] . "-12-31";
            $endDate = Util::FormatDate($endDate, "d/m/Y");
            $endDate = DateTime::createFromFormat('d/m/Y', $endDate)->setTime(0, 0, 0);
            $categories = Util::categoriesDate($option_interval, $initDate, $endDate);
            $typeInterval = "years";

        }
        $result = array("categories" => $categories, "typeInterval" => $typeInterval, "days" => $dias);
        return $result;
    }

    public static function searchInArray($params)
    {
        $needle = $params["needle"];
        $haystack = $params["haystack"];
        $keyCompare = $params["keyCompare"];
        $isObject = isset($params["isObject"]) ? $params["isObject"] : false;
        $isAll = isset($params["all"]) ? $params["all"] : false;

        $result = array();

        foreach ($haystack as $key => $value) {

            if (!$isObject) {

                if (isset($value[$keyCompare])) {
                    if ($value[$keyCompare] == $needle) {
                        if (!$isAll) {

                            array_push($result, array('value' => $value, 'key' => $key));
                        } else {
                            $result[] = $value;
                        }


                    }
                }

            } else {
                if ($value->$keyCompare == $needle) {


                    if (!$isAll) {

                        array_push($result, array('value' => $value, 'key' => $key));
                    } else {
                        $result[] = $value;
                    }

                }
            }
        }
        return $result;
    }

    public function getUpperCaseTable($name_change)
    {
        $table = $name_change;
        $arrayNames = explode("_", $table);
        $model_entity = "";
        foreach ($arrayNames as $name) {
            // your code
            $model_entity .= ucfirst($name);
        }

        return $model_entity;
    }

    public function getCamelCase($table_name)
    {

        return lcfirst($this->getUpperCaseTable($table_name));
    }

    public static function getUrlManager()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $redirectTo = '';
        $businessProfile = new BusinessByEmployeeProfile();
        $resultBusiness = $businessProfile->getUserBusiness(
            array(
                'user_id' => $user_id
            )
        );


        if ($resultBusiness) {
            $redirectTo = "/managerBusiness/" . $resultBusiness->business_id . '/managerDashboard';
        } else {
            $role = new Role();
            $redirectTo = $role->getUrlCurrentUser();
        }

        return $redirectTo;
    }


    public static function searchModules($params)
    {
        $haystack = $params['haystack'];
        $needle = $params['needle'];
        $isParentManager = $params['isParent'];
        $result = array();
        foreach ($haystack as $key => $value) {
            $isParent = $value['isParent'];
            if ($isParent) {

                if ($isParentManager) {
                    if ($isParent) {
                        $parentData = $value['parentData'];
                        foreach ($parentData as $keySubMenu => $valueMenu) {

                            if ($keySubMenu == $needle) {
                                $result = array(
                                    'parentData' => $valueMenu,
                                    'parent' => $value
                                );
                                break;
                            }
                        }

                    }
                }
            } else {
                if ($key == $needle) {
                    $result = $value;
                    break;
                }
            }

        }

        return $result;
    }

    public static function searchModulesSetActive($params)
    {
        $haystack = $params['haystack'];
        $needle = $params['needle'];
        $isParentManager = $params['isParent'];

        foreach ($haystack as $key => $value) {
            $isParent = $value['isParent'];
            if ($isParent) {

                if ($isParentManager) {
                    if ($isParent) {
                        $parentData = $value['parentData'];
                        foreach ($parentData as $keySubMenu => $valueMenu) {

                            if ($keySubMenu == $needle) {

                                $haystack[$key]['parentData'][$keySubMenu]['active'] = true;
                                $haystack[$key]['active'] = true;

                                break;
                            }
                        }

                    }
                }
            } else {
                if ($key == $needle) {
                    $haystack[$key]['active'] = true;
                    break;
                }
            }
        }

        return $haystack;
    }

    public static function getModulesInit($params)
    {
        $result = array();
        return $result;
    }

    public static function resetMenuManager($params)
    {
        $menuCurrent = $params['menuCurrent'];
        foreach ($menuCurrent as $key => $menu) {
            $isParentCurrent = $menu['isParent'];

            if ($isParentCurrent) {
                $menuCurrent[$key]['active'] = false;
                $parentData = $menu['parentData'];
                foreach ($parentData as $keyChildren => $submenu) {

                    $menuCurrent[$key]['parentData'][$keyChildren]['active'] = false;

                }
            } else {

                $menuCurrent[$key]['active'] = false;


            }
        }
        return $menuCurrent;
    }

    public static function SortByKeyValue($data, $sortKey, $sort_flags = SORT_ASC)
    {
        if (empty($data) or empty($sortKey)) return $data;

        $ordered = array();
        foreach ($data as $key => $value)
            $ordered[$value[$sortKey]] = $value;

        ksort($ordered, $sort_flags);

        return array_values($ordered); // array_values() added for identical result with multisort*
    }

    public static function getMenuFormat($menu)
    {
        $result = array();
        foreach ($menu as $key => $item) {
            $setPush = array();
            $title = $item['title'];
            $allow = $item['allow'];
            $active = $item['active'];
            $icon = $item['icon'];
            $isParent = $item['isParent'];
            $weight = isset($item['weight'])?$item['weight']:-1;

            if ($isParent) {
                $parentData = $item['parentData'];
                $itemsAll = array();
                foreach ($parentData as $keyData => $itemData) {
                    $urlCurrent = $itemData['urlCurrent'];
                    $weightChildren =  isset($itemData['weight'])?$itemData['weight']:-2;
                    $setPushItems = array(
                        'type_item' => 0,
                        'active' => $itemData['active'],
                        'name' => $itemData['title'],
                        'icon' => isset($itemData['icon']) ? $itemData['icon'] : '',
                        'link' => $urlCurrent,
                        'weight' => $weightChildren,

                    );
                    $itemsAll[] = $setPushItems;
                }

                $urlCurrent = isset($item['urlCurrent']) ? $item['urlCurrent'] : '';
                $setPush = array(
                    'type_item' => 1,
                    'active' => $active,
                    'name' => $title,
                    'icon' => $icon,
                    'link' => $urlCurrent,
                    'items' => $itemsAll,
                    'weight' => $weight,
                );
            } else {
                $urlCurrent = $item['urlCurrent'];
                $setPush = array(
                    'type_item' => 0,
                    'active' => $active,
                    'name' => $title,
                    'icon' => $icon,
                    'link' => $urlCurrent,
                    'weight' => $weight,
                );
            }
            $result[] = $setPush;
            /*   urlCurrent*/
        }

        return $result;

    }

    public static function getStructureMenuCurrent($menuItems)
    {

        $result = "";
        $level = 0;
        $cont = 1;

        foreach ($menuItems as $currentAction) {

            $type_item = $currentAction["type_item"];
            $menu = '';
            $nextItems = "";
            $nameItem = $currentAction["name"];
            $link = $currentAction["link"];

            $weight = $currentAction["weight"];
            $activeClass = isset($currentAction['active']) ? $currentAction['active'] : false;
            $active_class = 'm-menu__item' . ($activeClass ? " m-menu__item-parent--active  mm-active active" : '');
            if ($type_item == 1) {
                $liParent = "    <li id='action_{$level}_{$cont}' class='{$active_class}' weight-parent='$weight' >
                                      <a href='javascript: void(0);' class='waves-effect'>
                                        <i class='{$currentAction["icon"]}'></i>
                                            <span class=''> {$currentAction["name"]}</span>
                                            <span class='menu-arrow'></span>
                                      </a>";
                $subItems = "";
                foreach ($currentAction["items"] as $item) {
                    $subLink = url($item['link']);
                    $subText = $item['name'];
                    $weightChildren = $item["weight"];

                    $activeClass = isset($item['active']) ? $item['active'] : false;

                    $activeClassCurrent = $activeClass ? "active" : '';
                    $active_class = 'm-menu__item-children' . ($activeClass ? " m-menu__item-children--active " . $activeClassCurrent : '');

                    $subItems .= "<li id='action_{$level}_{$cont}' class='{$active_class}' weight-children='$weightChildren'>
                                     <a href='{$subLink}' class='m-menu__link {$activeClassCurrent}'>{$subText}
                                     </a>
                                   </li>";
                }
                $submenu = "      <ul class='nav-second-level' aria-expanded=\"false\">" . $subItems . "</ul>";
                $submenu .= " </li>";
                $liParent .= $submenu;
                $menu .= $liParent;
            } else {
                $link = url($link);


                $liParent = "    <li id='action_{$level}_{$cont}' class='{$active_class}' class='waves-effect' weight-not-children='$weight'>
                                      <a href='$link' class='waves-effect'>
                                        <i class='{$currentAction["icon"]}'></i>
                                            <span > {$currentAction["name"]}</span>
                                      </a>
                                </li>";
                $menu .= $liParent;
            }
            $result .= $menu;
            $cont++;


        }


        return $result;

    }


    public static function getRowsByDataBS3($params)
    {
        $haystack = $params["haystack"];
        $countData = count($haystack);
        $columnsDiv = isset($params["columnsDiv"]) ? $params["columnsDiv"] : 3;
        $rowsTotal = $countData / $columnsDiv;

        $isMultiple = is_float($rowsTotal);

        if ($isMultiple) {
            $numberSections = explode(".", $rowsTotal);
            $decimalInt = $numberSections[1];
            $decimalInt = "0." . $decimalInt;
            $valueRemaining = 1 - $decimalInt;

            $rowsTotal = $rowsTotal + $valueRemaining;

        }

        $result = array();
        $countTravel = 0;
        $rowsTotalCurrent = 0;
        $rowsTotalCurrent = $rowsTotal;
        $haystackAux = [];

        foreach ($haystack as $value) {
            $setPush = $value;
            array_push($haystackAux, $setPush);
        }
        $haystack = $haystackAux;
        for ($i = 0; $i < $rowsTotalCurrent; $i++) {

            $dataColumn = array();
            for ($j = 0; $j < $columnsDiv; $j++) {

                if (isset($haystack[$countTravel])) {
                    $setPush = $haystack[$countTravel];
                    array_push($dataColumn, $setPush);
                }
                $countTravel++;
            }
            if (count($dataColumn) > 0) {

                $setPushRow = array("data" => $dataColumn);
                array_push($result, $setPushRow);
            }


        }

        return $result;
    }


    public function getFormatArraySelect($arrayDataTypeModel, $arrayConfig = array("key" => "id", "text" => array("name")))
    {
        $result = array();
        foreach ($arrayDataTypeModel as $row) {
            $valueView = "";
            if (isset($arrayConfig["text"])) {
                foreach ($arrayConfig["text"] as $keyView) {
                    $valueView .= $row[$keyView] . " ";
                }
            }
            $result[$row[$arrayConfig["key"]]] = $valueView;
        }
        return $result;
    }

    public function getArrayByObject($object)
    {
        $setPush = json_decode(json_encode($object), true);
    }


    public static function getMenuManager($params)
    {
        $result = array();
        $id = $params['id'];
        $urlInit = isset($params['urlInit']) ? $params['urlInit'] : null;

        $typeManagerCurrent = $params['typeManager'];
        $configModules = array();
        $isParentManager = false;
        $allowModules = false;

        $keyParentManagerActive = null;
        $keyChildrenManagerActive = null;
        $msg = 'Not Message';
        $menuConfigByRole = $params['menuConfigByRole'];
        $menuCurrent = $menuConfigByRole['menuCurrent'];

        if ($urlInit) {

            foreach ($menuCurrent as $key => $menu) {
                $isParentCurrent = $menu['isParent'];
                if ($isParentCurrent) {
                    $parentData = $menu['parentData'];
                    foreach ($parentData as $keyChildren => $submenu) {
                        $typeManager = 'manager' . ucfirst($keyChildren);
                        $menuCurrent[$key]['parentData'][$keyChildren]['typeManager'] = $typeManager;
                        $urlCurrent = url($urlInit . '/' . $id . '/' . $typeManager);
                        $menuCurrent[$key]['parentData'][$keyChildren]['urlCurrent'] = $urlCurrent;

                    }
                } else {
                    $typeManager = 'manager' . ucfirst($key);
                    $menuCurrent[$key]['typeManager'] = $typeManager;
                    $urlCurrent = url($urlInit . '/' . $id . '/' . $typeManager);
                    $menuCurrent[$key]['urlCurrent'] = $urlCurrent;

                }
            }

        }
        if ($typeManagerCurrent) {
            $configModulesParent = self::searchInArray(array("haystack" => $menuCurrent, "needle" => $typeManagerCurrent, "keyCompare" => 'typeManager'));
            $searchParent = false;
            $searchChildren = false;
            $configModulesChildren = array();
            if (empty($configModulesParent)) {//Not parent has manager
                foreach ($menuCurrent as $key => $menu) {
                    $isParent = $menu['isParent'];
                    if ($isParent) {
                        $parentData = $menu['parentData'];
                        $searchManagerTypeChildren = self::searchInArray(array("haystack" => $parentData, "needle" => $typeManagerCurrent, "keyCompare" => 'typeManager'));

                        if (!empty($searchManagerTypeChildren)) {
                            $searchChildren = true;
                            $keyChildren = $searchManagerTypeChildren[0]['key'];
                            $configModulesChildren = array(
                                'keyParent' => $key,
                                'keyChildren' => $keyChildren,
                                'valueChildren' => $searchManagerTypeChildren[0]['value']
                            );
                            break;
                        }
                    }
                }
            } else {//parent manager
                $searchParent = true;
            }

            if ($searchParent || $searchChildren) {
//CHANGES ACTIVES TO PARENT AND CHILDREN
                $menuCurrent = self::resetMenuManager(array('menuCurrent' => $menuCurrent));

                $allowModules = true;
                if ($searchParent) {
                    $isParentManager = true;
                    $menuCurrent [$configModulesParent[0]['key']]['active'] = true;
                    $configModules = array(
                        'keyParent' => $configModulesParent[0]['key'],

                    );
                } else if ($searchChildren) {

                    $isParentManager = false;
                    $menuCurrent [$configModulesChildren['keyParent']]['active'] = true;
                    $menuCurrent [$configModulesChildren['keyParent']]['parentData'][$configModulesChildren['keyChildren']]['active'] = true;
                    $configModules = array(
                        'keyChildren' => $configModulesChildren['keyChildren'],
                        'keyParent' => $configModulesChildren['keyParent'],

                    );
                }

            } else if ($searchParent == false && $searchChildren == false) {
                $msg = 'not found managerType in parent not children';
                $allowModules = false;
            }
        } else {
            $isParentManager = $menuConfigByRole['isParentManager'];
            $configModules = $menuConfigByRole['configModules'];
            $allowModules = $menuConfigByRole['allowModules'];
        }
        $managerViewMain = $menuConfigByRole['managerViewMain'];
        $modulesAllow = array(
            'isParent' => $isParentManager,
            'config' => $configModules,
            'allow' => $allowModules,
            'msg' => $msg
        );
        $success = false;
        $result = array(
            'menu' => $menuCurrent,
            'configModulesAllow' => $modulesAllow,
            'success' => $success,
            'managerViewMain' => $managerViewMain

        );
        return $result;
    }

    public static function objectToArrayRecursive($object, $assoc = TRUE, $empty = '')
    {
        $res_arr = array();

        if (!empty($object)) {

            $arrObj = is_object($object) ? get_object_vars($object) : $object;

            $i = 0;
            foreach ($arrObj as $key => $val) {
                $akey = ($assoc !== FALSE) ? $key : $i;
                if (is_array($val) || is_object($val)) {
                    $res_arr[$akey] = (empty($val)) ? $empty : self::objectToArrayRecursive($val);
                } else {
                    $res_arr[$akey] = (empty($val)) ? $empty : (string)$val;
                }
                $i++;
            }
        }
        return $res_arr;
    }

    public static function getDatesInitWeek()
    {
        $from = date('Y/m/d', strtotime("this week")) . ' 00:00:00';
        $to = date('Y/m/d H:i:s');
        $result = [
            'from' => $from,
            'to' => $to,
        ];

        return $result;
    }

    public static function getDataManagerCurrentUser()
    {
        $user = Auth::user();
        $isSuperAdmin = false;
        $roles = [];
        $hasUser = false;
        if ($user) {
            $isSuperAdmin = $user->id == 1;
            $roles = $user->roles;
            $hasUser = true;

        }
        $result = [
            'user' => $user,
            'isSuperAdmin' => $isSuperAdmin,
            'roles' => $roles,
            'success' => $hasUser
        ];


        return $result;
    }

    public static function searchRolesUser($params)
    {
        $needle = $params["needle"];
        $roles = $params["roles"];

        $success = false;
        $data = array();


        foreach ($roles as $key => $role) {
            if ($needle == $role["name"]) {
                $success = true;
                $data = array("value" => $role);
                break;
            }
        }

        $result = array(
            "success" => $success,
            "data" => $data
        );
        return $result;
    }

    public static function getPathsManagementProject($params = [])
    {
        $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
        $result = [
            'baseUrlPublic' => $resourcePathServer
        ];

        return $result;

    }

    static function getFieldsSelect($fieldsCurrent, $tableCurrent)
    {
        $fieldsCurrentList = explode(",", $fieldsCurrent);
        $parts = array();
        $countTotal = count($fieldsCurrentList) - 1;
        $countAux = 0;

        foreach ($fieldsCurrentList as $row) {
            $setPush = $tableCurrent . "." . $row;
            $parts[] = $setPush;
            $countAux++;
        }

        $result = implode(",", $parts);
        return $result;
    }

    static function getFieldsByAttributes($attributes)
    {
        $result = implode(",", $attributes);
        return $result;
    }

    public static function getStructureBusiness($params, $resourcePathServer)
    {
        $business = $params['business'];

        $galleryManager = $params['gallery'];
        $tags = $params['tags'];
        $details = $params['details'];
        $amenities = $params['amenities'];
        $schedulingManager = $params['scheduling'];
        $aboutUs = $params['aboutUs'];
        $counters = $params['counters'];
        $networkSocial = $params['networkSocial'];
        $allowInformation = $business->title ? true : false;
        $scheduling = [];
        $user = [];
        $descriptions = [];
        $information = [
            'category' => '',
            'subcategory' => '',
            'subcategory_id' => '',
            'category' => '',

            'statusOpen' => '',
            'title' => '',
            'user' => $user,
            'allow' => $allowInformation
        ];
        $networkSocial = [];
        $contactUs = [
            'address' => '',
            'phone' => '',
            'email' => '',
            'web' => '',
            'networkSocial' => $networkSocial,
            'location' => [
                'lat' => 0,
                'lng' => 0,

            ]
        ];
        $currentNameDay = date("D");


        $currentNumberDay = -1;
        if ($currentNameDay == 'Sun') {
            $currentNumberDay = 6;
        } else if ($currentNameDay == 'Mon') {
            $currentNumberDay = 0;
        } else if ($currentNameDay == 'Tue') {
            $currentNumberDay = 1;
        } else if ($currentNameDay == 'Wed') {
            $currentNumberDay = 2;
        } else if ($currentNameDay == 'Thu') { // ok
            $currentNumberDay = 3;
        } else if ($currentNameDay == 'Fri') {
            $currentNumberDay = 4;
        } else if ($currentNameDay == 'Sat') {
            $currentNumberDay = 5;
        }
        if ($allowInformation) {
            if ($business->description != null && $business->description != '' && $business->description != 'null') {
                $descriptions[] = (object)['title' => 'Informacion Principal', 'description' => $business->description];
            }
            $information['category'] = $business->business_categories;
            $information['category_id'] = $business->business_categories_id;

            $information['subcategory'] = $business->business_subcategories;
            $information['subcategory_id'] = $business->business_subcategories_id;

            $information['title'] = $business->title;
            $information['srcMain'] = asset($resourcePathServer . $business->source);

            $user_name = $business->user_name;
            $user_email = $business->user_email;
            $user_id = $business->user_id;
            $urlRouteUser = route('authorSingle', app()->getLocale()) . '/' . $user_id;
            $notImage = asset($resourcePathServer . '/images/not-image.png');
            $urlImageUser = ($business->avatar == '' || $business->avatar == null) ? $notImage : ($business->provider_id == 'server' ? asset($resourcePathServer . $business->avatar) : $business->avatar);

            $information['user'] = (object)[
                'user_name' => $user_name,
                'email' => $user_email,
                'id' => $user_id,
                'url' => $urlRouteUser,
                'source' => $urlImageUser

            ];
            $address = $business->street_1 . ' ,' . $business->street_2;
            $contactUs['address'] = $address;
            $phone = $business->phone_value;
            $contactUs['phone'] = $business->countries_phone_code . '' . $phone;
            $contactUs['email'] = $business->email;
            $contactUs['location'] = [
                'lat' => $business->street_lat,
                'lng' => $business->street_lng,

            ];

            if ($business->page_url == 'null' && $business->page_url == null && $business->page_url == '') {
                $contactUs['web'] = $business->page_url;
            }
            $statusOpen = false;
            if ($schedulingManager) {
                $needle = $currentNumberDay;
                $modelbsbb = new \App\Models\BusinessScheduleByBreakdown;
                $modelBBS = new \App\Models\BusinessBySchedule;
                foreach ($schedulingManager as $key => $row) {
                    $active = false;
                    $currentClass = 'information-day ';
                    if ($needle == $row->weight_day && $row->open == 1) {
                        $statusOpen = true;
                        $active = true;
                        $currentClass = 'information-day active ';
                    } else if ($needle == $row->weight_day && $row->open == 0) {
                        $currentClass = 'information-day information-day--close ';

                    }
                    $business_by_schedule_id = $row->id;
                    $dataBreakdownCurrent = $row->type == $modelbsbb::TYPE_BREAKDOWN ? $modelbsbb->getBreakdownScheduleStructure(array("haystack" => $modelbsbb->getBreakdownSchedule(array("business_by_schedule_id" => $business_by_schedule_id)))) : array();
                    $schedulingTypeName = $row->type == $modelbsbb::TYPE_BREAKDOWN ? 'Varios Horarios' : 'Todo el dia.';
                    $schedulingType = $row->type;
                    $setPush = array(
                        "id" => $row->id,
                        "name" => "element-" . $row->id,
                        "text" => $row->name, //*
                        "type" => $schedulingType, //*
                        "schedulingType" => $schedulingTypeName, //*
                        "status" => $row->open == $modelBBS::OPEN ? 'Open' : 'Closed', //*
                        'breakdown' => (object)$dataBreakdownCurrent,
                        'currentClass' => $currentClass
                    );

                    $setPush = (object)$setPush;
                    if ($modelbsbb::TYPE_BREAKDOWN) {

                    }
                    $scheduling[] = $setPush;
                }
            }

            $information['statusOpen'] = $statusOpen;
        }
        $gallery = [];
        foreach ($galleryManager as $key => $row) {
            $setPush = array(
                "id" => $row->id,
                "name" => "element-gallery-" . $row->id,
                "text" => $row->title, //*
                "src" => asset($resourcePathServer . '' . $row->src), //*
                "description" => $row->description && $row->description != 'null' && $row->description != 'null' ? $row->description : '', //*
                "subtitle" => $row->subtitle && $row->subtitle != 'null' && $row->subtitle != 'null' ? $row->subtitle : '', //*

            );
            $gallery[] = (object)$setPush;
        }
        $urlBusiness = route('businessDetails', app()->getLocale()) . '/' . $business->id;
        $result = [
            'information' => (object)$information,
            'contactUs' => (object)$contactUs,
            'scheduling' => $scheduling,
            'gallery' => $gallery,
            'urlBusiness' => $urlBusiness

        ];
        $result['aboutUs'] = [
            'title' => __('frontend.menu.about-us'),
            'description' => $business->description
        ];
        if (count($descriptions) > 0) {
            $result['descriptions'] = $descriptions;
        }

        if (count($params['amenities']) > 0) {
            $result['amenities'] = $params['amenities'];
        }
        return $result;
    }

    public static function getDataBusinessAll($params): array
    {
        $publicAsset = env('APP_IS_SERVER') ? "public" : '';
        $resourcePathServer = $publicAsset;
        $paramsRequest = $params["paramsRequest"];
        $templateInitType = isset($params["templateInitType"]) ? $params["templateInitType"] : 0;
        $language = $paramsRequest["language"];
        $modelCategories = new ProductCategory();

        $viewPage = false;
        $inventoryConfig = [];
        $typeShopView = [];
        $dataCategoriesResult = [];
        $dataManagerPage['allowPlugins']['googleMaps'] = true;
        $dataManagerPage['type'] = $paramsRequest['type'];
        $modelBusiness = new \App\Models\Business;
        $business_id = null;
        $paramId = $paramsRequest['id'];
        $information = $modelBusiness->getDetailsBee([
            'filters' => [
                'business_id' => $paramId
            ]
        ]);
        $pageSectionsConfig = [];
        if ($information) {
            $viewPage = true;
            $business_id = $information->id;
            $modelBBS = new \App\Models\BusinessBySchedule;
            $modelBBG = new \App\Models\BusinessByGallery;
            $modelBA = new \App\Models\BusinessAmenities();
            $gallery = $modelBBG->getGalleryByBusiness([
                'filters' => [
                    "business_id" => $business_id
                ]
            ]);
            $tags = [];
            $details = [];
            $amenities = $modelBA->getAmenitiesBusiness(
                [
                    'filters' => [
                        "business_id" => $business_id
                    ]
                ]
            );
            $businessInformation = $modelBusiness->getBusinessFrontend([
                'filters' => [
                    'business_id' => $business_id
                ]
            ]);
            if ($businessInformation) {
                $pageSectionsConfig = $businessInformation;
            }
            $scheduling = $modelBBS->getSchedulesByBusiness(array("business_id" => $business_id));
            $aboutUs = [];
            $counters = [];
            $networkSocial = [];
            $informationAll = [
                'business' => $information,
                'gallery' => $gallery,
                'tags' => $tags,
                'details' => $details,
                'amenities' => $amenities,
                'scheduling' => $scheduling,
                'aboutUs' => $aboutUs,
                'counters' => $counters,
                'networkSocial' => $networkSocial,
            ];
            $dataManagerPage['business'] = Util::getStructureBusiness($informationAll, $resourcePathServer);
            $modelCounter = new \App\Models\Tracking\TrackingEvents();

            $weekVisit = $modelCounter->getCountersBusiness([
                'filters' => [
                    'business_id' => $business_id,
                    'isWeek' => true,
                ]
            ]);

            $views = $modelCounter->getCountersBusiness([
                'filters' => [
                    'business_id' => $business_id
                ]
            ]);
            $customersSatisfied = 0;
            $awards = 0;
            $reviews = 0;
            $rating = 0;
            $hearth = 0;
            $dataManagerPage['business']['counters'] = [
                'weekVisit' => [
                    'title' => '',
                    'count' => $weekVisit
                ],
                'views' => [
                    'title' => '',
                    'count' => $views
                ],
                'reviews' => [
                    'title' => '',
                    'count' => $reviews
                ],
                'rating' => [
                    'title' => '',
                    'count' => $rating
                ],
                'customersSatisfied' => [
                    'title' => '',
                    'count' => $customersSatisfied
                ],
                'awards' => [
                    'title' => '',
                    'count' => $awards
                ],
                'hearth' => [
                    'title' => '',
                    'count' => $hearth
                ],
            ];
            $dataCategoriesResult = $modelCategories->getListCategoriesManager([
                'filters' => [
                    'language' => $language,
                    'business_id' => $business_id,
                    'resourcePathServer' => $resourcePathServer

                ]
            ]);
            $colorDefault = '#FACC39';
            $dataManagerPage['allowVue'] = true;
            $dataManagerPage['categories'] = $dataCategoriesResult;
            $dataManagerPage['business_id'] = $business_id;
            $inventoryConfig = [
                'type' => 0,
                'management' => null,
                'not-manager' => true,
                'config_management_inventory' => [
                    'header_subcategories' => [
                        'content' => [
                            'styles' => [
                                'background_color' => $colorDefault
                            ]
                        ]
                    ]
                ]
            ];
            $modelCurrent = new \App\Models\BusinessByInventoryManagement();
            $inventoryConfigCurrent = $modelCurrent->getDataProfileBusiness([
                'filters' => [
                    'business_id' => $business_id
                ]
            ]);
            $typeShopView = 0;//default
            if ($inventoryConfigCurrent) {
                $config_management_inventory = [
                    'header_subcategories' => [
                        'content' => [
                            'styles' => [
                                'background_color' => $colorDefault
                            ]
                        ]
                    ]
                ];

                $typeShopView = $inventoryConfigCurrent->type;
                if ($inventoryConfigCurrent->type == 1) {
                    if ($inventoryConfigCurrent->config_management_inventory == "'{}'") {
                        $config_management_inventory = [
                            'header_subcategories' => [
                                'content' => [
                                    'styles' => [
                                        'background_color' => $colorDefault
                                    ]
                                ]
                            ]
                        ];
                    } else {
                        $config_management_inventory_data = json_decode($inventoryConfigCurrent->config_management_inventory, true);
                        $config_management_inventory = $config_management_inventory_data;
                    }
                } else {

                }

                $inventoryConfig = [
                    'type' => $inventoryConfigCurrent->type,
                    'management' => $inventoryConfigCurrent,
                    'not-manager' => false,
                    'config_management_inventory' => $config_management_inventory
                ];
            }

        }

        $dataManagerPage['inventory-config'] = $inventoryConfig;
        $dataManagerPage['typeShopView'] = $typeShopView;

        if (count($dataCategoriesResult) > 0) {
            if ($dataManagerPage['inventory-config']['type'] == 1) {
                $categoriesHtml = Util::getSliderCategoriesTypeOne([
                    'data' => $dataCategoriesResult
                ], $resourcePathServer, 1);
                $dataManagerPage['categoriesHtml'] = $categoriesHtml;
            }
        }
        $dataManagerPage["viewPage"] = $viewPage;
        $dataManagerPage["pageSectionsConfig"] = $pageSectionsConfig;
        $dataManagerPage["business_id"] = $business_id;

        return $dataManagerPage;
    }

    public static function getSliderCategoriesTypeOne($params, $resourcePathServer, $type = 0): string
    {
        $data = $params['data'];


        $result = '';
        if ($type == 0) {
            $result = '<div class="list-carousel fl-wrap card-listing " v-categories-items="{initMethod:_categoryCurrent}" >';
            $result .= '<div class="listing-carousel-data  fl-wrap ">';
            $listingHtml = '';
            $initHtml = false;
            foreach ($data as $key => $row) {

                $urlImage = asset($resourcePathServer . $row['source']);
                $currentClass = '';
                if (!$initHtml) {
                    $currentClass = 'slick-active-current';
                    $initHtml = true;
                } else {
                    $currentClass = '';
                    $initHtml = true;
                }
                $categoryHtml = '         <div class="listing-carousel-data__content-img"> ';
                $categoryHtml .= '             <img src="' . $urlImage . '" alt="">';
                $categoryHtml .= '             <div class="overlay--categories"></div>';
                $categoryHtml .= '        </div> ';
                $listingHtml .= '<div class="slick-slide-item ' . $currentClass . '" key-manager="' . $row['id'] . '" >';
                $listingHtml .= '  <div class="listing-item" key-manager="' . $row['id'] . '" >';
                $listingHtml .= '     <article class="listing-carousel-data__listing fl-wrap" key-manager="' . $row['id'] . '">';
                $listingHtml .= $categoryHtml;
                $listingHtml .= '<h3 class="listing-carousel-data__title" id="listing-carousel-data__title-' . $row['id'] . '">' . $row['value'] . '</h3>';
                $listingHtml .= '     </article>';
                $listingHtml .= '  </div>';
                $listingHtml .= '</div>';
            }
            $result .= $listingHtml;
            $result .= '   </div>';
            $result .= '</div>';
        } else {

            $result .= '         <a class="d-lg-none block-toggler" data-bs-toggle="collapse"';
            $result .= '             href="#categoriesMenu" aria-expanded="false"';
            $result .= '             aria-controls="categoriesMenu">Product Categories<span';
            $result .= '             class="block-toggler-icon"></span>';
            $result .= '       </a>';
            $result .= '      <div class="expand-lg collapse" id="categoriesMenu" role="menu">';//menu
            $titleCategories = __('shop.filters.categories');

            $result .= '           <h5 class="sidebar-heading d-none d-lg-block">'.$titleCategories.' </h5>';
            $result .= '           <div class="sidebar-icon-menu mt-4 mt-lg-0">';
            foreach ($data as $key => $rowCategory) {
                $result .= '             <div class="sidebar-icon-menu-item active" data-bs-toggle="collapse"';
                $result .= '               data-bs-target="#subcategories_'.$key.'" aria-expanded aria-controls="subcategories_'.$key.'"';
                $result .= '               role="menuitem">';
                $result .= '                 <div class="d-flex align-items-center">';
              //  $result .= '                    <svg class="svg-icon sidebar-icon">';
              //  $result .= '                     <use xlink:href="#trousers-1"></use>';
               // $result .= '                     </svg>';
                $result .= '                     <a class="sidebar-icon-menu-link fw-bold me-2" >'.$rowCategory['value'].'</a>';
                $result .= '                     <span class="sidebar-icon-menu-count not-view"> 120</span>';
                $result .= '                  </div>';

               $result .= '                    <div class="collapse show" id="subcategories_'.$key.'">';
                    $result .= '                  <ul class="sidebar-icon-menu sidebar-icon-submenu">';
                foreach ($rowCategory["data"] as $keySub => $rowSubcategory) {
                    $result .= '                     <li class="sidebar-icon-submenu-item">';
                    $result .= '                       <a class="sidebar-icon-submenu-link link-animated link-animated-light"';
                    $result .= '                      >';
                    $result .= $rowSubcategory["value"];
                    $result .= '                        </a>';

                    $result .= '                     </li>';


                }
                $result .= '                     </ul>';

                $result .= '                  </div>';
                $result .= '          </div>';

            }
            $result .= '       </div>';//mt-4
            $result .= '    </div>';//menu


        }


        return $result;
    }
}
