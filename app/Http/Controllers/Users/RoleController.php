<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\MyBaseController;
use App\Models\ExportExcel\ActionsDataExport;
use App\Models\Role;
use App\Models\RoleAction;
use App\Models\User;
use Exception;
use DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use View;
use Form;
use Validator;

use Response;
use Lang;
use Auth;
use Redirect;
use Illuminate\Support\Arr;

class RoleController extends MyBaseController
{

    public function getIndex()
    {
        $this->layout->content = View::make('role.index', [
        ]);
    }

    public function getListRoles()
    {
        $data = Request::all();
        $query = Role::query();
        $recordsTotal = $query->get()->count();
        $datatable = !empty($data['datatable']) ? $data['datatable'] : [];
        $datatable = array_merge(['pagination' => [], 'sort' => [], 'query' => []], $datatable);

        $sort = !empty($datatable['sort']['sort']) ? $datatable['sort']['sort'] : 'asc';
        $field = !empty($datatable['sort']['field']) ? $datatable['sort']['field'] : 'name';
        $page = !empty($datatable['pagination']['page']) ? (int)$datatable['pagination']['page'] : 1;
        $perpage = !empty($datatable['pagination']['perpage']) ? (int)$datatable['pagination']['perpage'] : -1;

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
        $data = $query->get()->toArray();
        $meta = [
            'page' => $page,
            'pages' => $pages,
            'perpage' => $perpage,
            'total' => $total,
        ];
        $sort = [
            'sort' => $sort,
            'field' => $field,
        ];
        $result = array(
            'meta' => $meta + $sort,
            'data' => $data
        );
        return Response::json(
            $result
        );
    }

    public function getFormRole($id = null)
    {
        $method = 'POST';
        $actionsArray = array();
        $totalAdd = 0;
        if (isset($id) && $id != 1) {

            $role = Role::find($id);
            $resultData = self::getRoleActions(null, $id);

            $actionsArray = Arr::flatten($resultData);
            $totalAdd = count($actionsArray);

        } else {
            $role = new Role();
        }

        $actions = $role->get_actions(null);

        $actions_html = "<table><tbody>";

        if (count($actions) > 0) {

            $actions_html .= $this->drawSonActions($actions, $actionsArray);
        }
        $actions_html .= " </tbody></table>";

        $view = View::make('role.loads._form', [
            'method' => $method,
            'role' => $role,
            'actions' => $actions_html,
            'totalAdd' => $totalAdd,

        ])->render();
        return Response::json(array(
            'html' => $view
        ));
    }

    public function getListSelect2()
    {
        $data = Request::all();
        $query = Role::query()->select('id', 'name as text');
        if (isset($data['q']) && !empty($data['q'])) {
            $query->where('name', 'like', '%' . $data['q'] . '%');
        }
        if (isset($data['id']) && !empty($data['id'])) {
            $query->where('id', '=', $data['id']);
        }
        $query->where('status', '=', Role::STATUS_ACTIVE);
        $query->where('id', '!=', Role::ROL_SUPERADMIN);
        $query->limit(10)->orderBy('name', 'asc');
        $rolesList = $query->get()->toArray();
        return Response::json(
            $rolesList
        );
    }

    private function getTrActionTreeView($params)
    {
        $id = $params['id'];
        $actions = $params['actions'];
        $son_actions = $params['son_actions'];
        $i = $params['i'];
        $linkCurrent = $params['linkCurrent'];
        $typeActionManager = $params['typeActionManager'];
        $typeCondition = $params['typeCondition'];//
        $weight = $params['weight'];//
        $typeActionName = $params['typeActionName'];//

        $valueCurrent = $id;
        $checkedCurrent = "";
        if (in_array($id, $actions)) {
            $checkedCurrent = "checked";
        }
        $hasChildren = count($son_actions[$i]['son_actions']) > 0 ? "has-children" : "";
        $inputCheckbox = '<input parent_id="' . $son_actions[$i]['parent_id'] . '" id="' . $id . '"  name="actions[]" type="checkbox" value="' . $valueCurrent . '" ' . $checkedCurrent . '>';
        $valueExtraOpen = "";
        $valueExtraClose = "";
        $classSpan = '';
        $htmlParentId = "";
        $htmlParentIdRow = "";

        $htmlParentId = 'parent_id="' . $son_actions[$i]['parent_id'] . '"';
        if ($typeCondition == 'condition-001') {
            $valueExtraOpen = "";
            $valueExtraClose = "";
            $htmlParentIdRow = 'id="' . $id . '"' . 'parent-id="' . $son_actions[$i]['parent_id'] . '"';


        } else {
            $valueExtraOpen = "<b>";
            $valueExtraClose = "</b>";
            $classSpan = 'leaflet';
            $htmlParentIdRow = 'id="' . $id . '"';


        }

        $managerElement = $typeActionManager == 2 ? $valueExtraOpen . $son_actions[$i]['id'] . "-" . $son_actions[$i]['name'] . $valueExtraClose : ($typeActionManager == 0 ? "<a href='$linkCurrent' target='_blank'>" . $son_actions[$i]['id'] . "-" . $son_actions[$i]['name'] . "</a>" : $valueExtraOpen . $son_actions[$i]['id'] . "-" . $son_actions[$i]['name'] . $valueExtraClose);
        $htmlWeight = '-Peso:<span class="badge badge-danger rounded-circle  weight-span ' . $classSpan . '">' . $weight . '</span>';

        $row = "     <tr class='tr-action-type-" . $typeActionName . "'   " . $typeCondition . "   " . $hasChildren . "   $htmlParentIdRow  >
                              <td id=\"label_" . $son_actions[$i]['id'] . "\" class=\"col-md-8\"   $htmlParentId >" . $valueExtraOpen . $managerElement . $valueExtraClose . $htmlWeight . "</td>
                               <td class=\"col-md-2\">
                              " . $inputCheckbox . "
                             </td>
                    </tr>";

        $result = [
            'row' => $row
        ];
        return $result;
    }

    private function getTrAction($params)
    {
        $id = $params['id'];
        $actions = $params['actions'];
        $son_actions = $params['son_actions'];
        $i = $params['i'];
        $linkCurrent = $params['linkCurrent'];
        $typeActionManager = $params['typeActionManager'];
        $typeCondition = $params['typeCondition'];//
        $weight = $params['weight'];//
        $typeActionName = $params['typeActionName'];//

        $valueCurrent = $id;
        $checkedCurrent = "";
        if (in_array($id, $actions)) {
            $checkedCurrent = "checked";
        }
        $hasChildren = count($son_actions[$i]['son_actions']) > 0 ? "has-children" : "";
        $inputCheckbox = '<input parent_id="' . $son_actions[$i]['parent_id'] . '" id="' . $id . '"  name="actions[]" type="checkbox" value="' . $valueCurrent . '" ' . $checkedCurrent . '>';
        $valueExtraOpen = "";
        $valueExtraClose = "";
        $classSpan = '';
        $htmlParentId = "";
        $htmlParentIdRow = "";

        $htmlParentId = 'parent_id="' . $son_actions[$i]['parent_id'] . '"';
        if ($typeCondition == 'condition-001') {
            $valueExtraOpen = "";
            $valueExtraClose = "";
            $htmlParentIdRow = 'id="' . $id . '"' . 'parent-id="' . $son_actions[$i]['parent_id'] . '"';


        } else {
            $valueExtraOpen = "<b>";
            $valueExtraClose = "</b>";
            $classSpan = 'leaflet';
            $htmlParentIdRow = 'id="' . $id . '"';


        }

        $managerElement = $typeActionManager == 2 ? $valueExtraOpen . $son_actions[$i]['id'] . "-" . $son_actions[$i]['name'] . $valueExtraClose : ($typeActionManager == 0 ? "<a href='$linkCurrent' target='_blank'>" . $son_actions[$i]['id'] . "-" . $son_actions[$i]['name'] . "</a>" : $valueExtraOpen . $son_actions[$i]['id'] . "-" . $son_actions[$i]['name'] . $valueExtraClose);
        $htmlWeight = '-Peso:<span class="badge badge-danger rounded-circle  weight-span ' . $classSpan . '">' . $weight . '</span>';
        $classSelected = 'tr-not-selected';
        if ($checkedCurrent == 'checked') {
            $classSelected = 'tr-selected';
        }
        $row = "     <tr  linkCurrent='".$linkCurrent."'   class='tr-action-type-" . $typeActionName . "    " . $classSelected . "'   " . $typeCondition . "   " . $hasChildren . "   $htmlParentIdRow  >
                              <td id=\"label_" . $son_actions[$i]['id'] . "\" class=\"col-md-8\"   $htmlParentId >" . $valueExtraOpen . $managerElement . $valueExtraClose . $htmlWeight . "</td>
                               <td class=\"col-md-2\">
                              " . $inputCheckbox . "
                             </td>
                    </tr>";

        $result = [
            'row' => $row
        ];
        return $result;
    }

    private function getTrActionData($params)
    {
        $id = $params['id'];
        $actions = $params['actions'];
        $son_actions = $params['son_actions'];
        $i = $params['i'];
        $linkCurrent = $params['linkCurrent'];
        $typeActionManager = $params['typeActionManager'];
        $typeCondition = $params['typeCondition'];//
        $weight = $params['weight'];//
        $typeActionName = $params['typeActionName'];//

        $valueCurrent = $id;
        $checkedCurrent = "";
        if (in_array($id, $actions)) {
            $checkedCurrent = "checked";
        }
        $hasChildren = count($son_actions[$i]['son_actions']) > 0 ? "has-children" : "";
        $inputCheckbox = '<input parent_id="' . $son_actions[$i]['parent_id'] . '" id="' . $id . '"  name="actions[]" type="checkbox" value="' . $valueCurrent . '" ' . $checkedCurrent . '>';
        $valueExtraOpen = "";
        $valueExtraClose = "";
        $classSpan = '';
        $htmlParentId = "";
        $htmlParentIdRow = "";

        $htmlParentId = 'parent_id="' . $son_actions[$i]['parent_id'] . '"';
        if ($typeCondition == 'condition-001') {
            $valueExtraOpen = "";
            $valueExtraClose = "";
            $htmlParentIdRow = 'id="' . $id . '"' . 'parent-id="' . $son_actions[$i]['parent_id'] . '"';


        } else {
            $valueExtraOpen = "<b>";
            $valueExtraClose = "</b>";
            $classSpan = 'leaflet';
            $htmlParentIdRow = 'id="' . $id . '"';


        }

        $managerElement = $typeActionManager == 2 ? $valueExtraOpen . $son_actions[$i]['id'] . "-" . $son_actions[$i]['name'] . $valueExtraClose : ($typeActionManager == 0 ? "<a href='$linkCurrent' target='_blank'>" . $son_actions[$i]['id'] . "-" . $son_actions[$i]['name'] . "</a>" : $valueExtraOpen . $son_actions[$i]['id'] . "-" . $son_actions[$i]['name'] . $valueExtraClose);
        $htmlWeight = '-Peso:<span class="badge badge-danger rounded-circle  weight-span ' . $classSpan . '">' . $weight . '</span>';


        $row = "     <tr class='tr-action-type-" . $typeActionName . "'   " . $typeCondition . "   " . $hasChildren . "   $htmlParentIdRow  >
                              <td id=\"label_" . $son_actions[$i]['id'] . "\" class=\"col-md-8\"   $htmlParentId >" . $valueExtraOpen . $managerElement . $valueExtraClose . $htmlWeight . "</td>
                               <td class=\"col-md-2\">
                              " . $inputCheckbox . "
                             </td>
                    </tr>";

        $result = [
            'row' => $row
        ];
        return $result;
    }

    private function drawSonActionsData($son_actions, $actions = array())
    {
        $son_actions_html = [];
        if (count($son_actions) > 0) {
            for ($i = 0; $i < count($son_actions); $i++) {
                $valueAction = $son_actions[$i];
                array_push($son_actions_html, $valueAction);

                if (count($son_actions[$i]['son_actions']) > 0) {
                    $dataSon = $this->drawSonActionsData($son_actions[$i]['son_actions'], $actions);

                    $son_actions_html = array_merge($son_actions_html, $dataSon);
                }
            }
        }
        return $son_actions_html;
    }

    private function drawSonActions($son_actions, $actions = array())
    {
        $son_actions_html = "";
        if (count($son_actions) > 0) {
            for ($i = 0; $i < count($son_actions); $i++) {

                $id = $son_actions[$i]['id'];
                $typeActionManager = $son_actions[$i]["type"];
                $linkManager = $son_actions[$i]["link"];
                $linkCurrent = "";
                $typeActionName = $typeActionManager == 2 ? "root" : ($typeActionManager == 0 ? "url-manager" : "method");
                $weight = $son_actions[$i]['weight'];

                if ($linkManager !== '#') {
                    $linkCurrent = url($linkManager);
                }
                $paramsSend = [
                    'id' => $id,
                    'actions' => $actions,
                    'son_actions' => $son_actions,
                    'i' => $i,
                    'typeActionManager' => $typeActionManager,
                    'linkCurrent' => $linkCurrent,
                    'weight' => $weight,
                    'typeActionName' => $typeActionName,

                ];

                if ($son_actions[$i]['parent_id']) {//if-001
                    $paramsSend['typeCondition'] = 'condition-001';

                } else {
                    $paramsSend['typeCondition'] = 'condition-002';
                }
                $resultTr = $this->getTrAction($paramsSend);
                $son_actions_html .= $resultTr['row'];
                if (count($son_actions[$i]['son_actions']) > 0) {
                    $son_actions_html .= $this->drawSonActions($son_actions[$i]['son_actions'], $actions);
                }
            }
        }
        return $son_actions_html;
    }

    private function drawSonActionsTreeView($son_actions, $actions = array())
    {
        $son_actions_html = "";
        if (count($son_actions) > 0) {
            for ($i = 0; $i < count($son_actions); $i++) {

                $id = $son_actions[$i]['id'];
                $typeActionManager = $son_actions[$i]["type"];
                $linkManager = $son_actions[$i]["link"];
                $linkCurrent = "";
                $typeActionName = $typeActionManager == 2 ? "root" : ($typeActionManager == 0 ? "url-manager" : "method");
                $weight = $son_actions[$i]['weight'];

                if ($linkManager !== '#') {
                    $linkCurrent = url($linkManager);
                }
                $paramsSend = [
                    'id' => $id,
                    'actions' => $actions,
                    'son_actions' => $son_actions,
                    'i' => $i,
                    'typeActionManager' => $typeActionManager,
                    'linkCurrent' => $linkCurrent,
                    'weight' => $weight,
                    'typeActionName' => $typeActionName,

                ];

                if ($son_actions[$i]['parent_id']) {//if-001
                    $paramsSend['typeCondition'] = 'condition-001';

                } else {
                    $paramsSend['typeCondition'] = 'condition-002';
                }
                $resultTr = $this->getTrActionTreeView($paramsSend);
                $son_actions_html .= $resultTr['row'];
                if (count($son_actions[$i]['son_actions']) > 0) {
                    $son_actions_html .= $this->drawSonActionsTreeView($son_actions[$i]['son_actions'], $actions);
                }
            }
        }
        return $son_actions_html;
    }

    public function postSave()
    {
        try {
            $data = Request::all();
            if ($data['role_id'] == '') { //Create
                $role = new Role();
                $role->status = 'ACTIVE';
            } else { //Update
                $role = Role::find($data['role_id']);
                if (isset($data['status']))
                    $role->status = $data['status'];
            }
            $role->name = trim($data['name']);

            $role->save();
            $role->actions()->sync($data['actions']);
            return Response::json(true);
        } catch (Exception $e) {
            return Response::json(false);
        }
    }

    public function postIsNameUnique()
    {
        $validation = Validator::make(Request::all(),
            ['name' => 'unique:roles,name,' . Request::input('id')]);

        return Response::json($validation->passes() ? true : false);

    }

    private function getRoleActions($option, $role)
    {
        $role_aux = new Role();

        $this_level_items = $role_aux->getActionsCurrent($option, $role);

        $result = array();
        if ($this_level_items != false) { //if exist this level

            foreach ($this_level_items as $current_item) {

                $result[] = $current_item->id;
                $next = self::getRoleActions($current_item->id, $role);

                if ($next != '') {
                    $result[] = $next;
                }
            }
        } else {
            return $result;
        }

        return $result;
    }

    public function getListAll()
    {
        $data = Request::all();
        $model = new Role;
        $result = $model->getListAll($data);
        return Response::json(
            $result
        );
    }
}
