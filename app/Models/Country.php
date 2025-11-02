<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Province;

class Country extends Model
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    const ECUADOR_ID=18;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'countries';

    protected $fillable = array('name', 'status', 'iso_codes', 'phone_code');

    public $timestamps = true;

    public function getCountries($params = array())
    {
        $sort = isset($params['sort']) ? $params['sort'] : 'asc';
        $field = isset($params['field']) ? $params['field'] : 'name';
        $select = "*";
        $query = Country::query()->select($select);
        $status = self::STATUS_ACTIVE;
        $query->where("status", '=', $status);
        $query->orderBy($field, $sort);

        $data = $query->get()->toArray();

        return $data;
    }

    public function getStructureDrop($haystack)
    {
        $result = array();

        foreach ($haystack as $key => $value) {
            $name = $value["name"];
            $id = $value["id"];
            $result[$id] = $name;

        }

        return $result;
    }

    public function getStructureLocation($haystack)
    {
        $result = array();
        $modelP = new \App\Models\Province();
        $modelCY = new \App\Models\City();
        $modelZ = new \App\Models\Zone();

        foreach ($haystack as $key => $value) {
            $allowPush = false;
            $id = $value["id"];
            $setPush = [];
            $dataStateProvincesManager = $modelP->getListStatesProvinces([
                'filters' => [
                    'country_id' => $id
                ]
            ]);
            $dataProvince = [];
            if ($dataStateProvincesManager) {


                $allowPush = true;

                foreach ($dataStateProvincesManager as $keyProvince => $valueProvince) {
                    $province_id = $valueProvince->id;
                    $dataCitiesManager = $modelCY->getListCities([
                        'filters' => [
                            'province_id' => $province_id
                        ]
                    ]);
                    $dataCities = [];
                    if ($dataCitiesManager) {
                        $allowPush = true;
                        foreach ($dataCitiesManager as $keyCity => $valueCity) {
                            $city_id = $valueCity->id;
                            $dataZonesManager = $modelZ->getListZones([
                                'filters' => [
                                    'city_id' => $city_id
                                ]
                            ]);
                            if ($dataZonesManager) {
                                $allowPush = true;
                                $setPushCity = [
                                    'id' => $valueCity->id,
                                    'value' => $valueCity->name,
                                    'data' => $dataZonesManager
                                ];
                                $dataCities[$city_id] = $setPushCity;
                            } else {
                                $allowPush = false;

                            }
                        }
                        if (count($dataCities) > 0) {

                            $setPushProvince = [
                                'id' => $valueProvince->id,
                                'value' => $valueProvince->name,
                                'data' => $dataCities
                            ];
                            $dataProvince[$province_id] = $setPushProvince;
                        }
                    } else {
                        $allowPush = false;
                    }

                }
                if (count($dataProvince) > 0) {
                    $setPush = [
                        'id' => $id,
                        'value' => $value["name"],
                        'data' => $dataProvince
                    ];
                }

            } else {
                $allowPush = false;
            }

            if (count($dataProvince) > 0) {
                $result[$id] = $setPush;
            }

        }

        return $result;
    }

    public function getListS2Countries($params)
    {

        $query = DB::table($this->table);
        $selectString = "$this->table.id ,$this->table.name as text ";

        $select = DB::raw($selectString);
        $query->select($select);
        if (isset($params['filters']["search_value"]["term"])) {

            $like = $params['filters']["search_value"]["term"];

            $query->where($this->table . '.name', 'like', '%' . $like . '%');

        }
        $query->whereNotIn($this->table . '.id', function ($q) {
            $q->select('countries_id')->from('people_nationality');
        });
        $query->limit(10)->orderBy($this->table . '.name', 'asc');
        $result = $query->get()->toArray();
        return $result;
    }

    public function getListCountries($params = [])
    {

        $query = DB::table($this->table);
        $selectString = "$this->table.id ,$this->table.name";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->orderBy($this->table . '.name', 'asc');
        $result = $query->get()->toArray();
        return $result;
    }

    public function getProvincesByDataCountries($dataCountries)
    {
        $model = new Province();
        $result = [];
        foreach ($dataCountries as $key => $row) {
            $result[$row->id]['id'] = $row->id;
            $result[$row->id]['text'] = $row->name;
            $result[$row->id]['data'] = $model->getListStatesProvinces(
                [
                    'filters' => [
                        'country_id' => $row->id
                    ]
                ]
            );


        }
        return $result;

    }
}
