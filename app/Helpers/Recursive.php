<?php

namespace App\Helpers;

class Recursive
{
    private $data;
    private $html;
    private $stringUrl;
    private $permission;

    public function __construct($data, $stringUrl, $permission)
    {
        $this->data = $data;
        $this->stringUrl = $stringUrl;
        $this->permission = $permission;

    }

    public function dataTableRecursive($id = 0, $text = '')
    {
        foreach ($this->data as $value) {
            if ($value->parent_id == $id) {
                $this->html .=
                    '<tr id="sid' . $value->id . '">
                        <td>
                            <input type="checkbox" name="ids" class="form-check-input checkBoxClass"
                            value="' . $value->id . '">
                        </td>
                        <td>' . $value->id . '</td>
                        <td>' . $text . $value->name . '</td>';
                if ($value->display_name != '') {
                    $this->html .= '<td>' . $value->display_name . '</td>';
                }
                if ($value->image_path != '') {
                    $this->html .= '<td><img class="rounded-circle" width="50" height="50"
                                        src="' . $value->image_path . '" alt="" />
                                    </td>';
                }
                if (empty($value->image_path) && $this->stringUrl != 'permissions') {
                    $this->html .= '<td><img class="rounded-circle" width="50" height="50"
                                        src="" alt="" />
                                    </td>';
                }
                if ($value->status != '') {
                    $status = $value->status;
                    if ($status == 1) {
                        $this->html .= '<td><span class="badge bg-label-primary me-1">Active</span></td>';
                    } elseif ($status == 0) {
                        $this->html .= '<td><span class="badge bg-label-danger me-1">Block</span></td>';
                    }
                }
                if ($value->is_feature != '') {
                    $is_feature = $value->is_feature;
                    if ($is_feature == 1) {
                        $this->html .= '<td><span class="badge bg-label-info me-1">On</span></td>';
                    } elseif ($is_feature == 0) {
                        $this->html .= '<td><span class="badge bg-label-warning me-1">Off</span></td>';
                    }

                }
                $this->html .= '
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">';
                if (auth()->user()->checkPermissionAccess("edit-$this->permission")) {
                    $this->html .= '<a class="dropdown-item"
                                        href="/admin/' . $this->stringUrl . '/' . $value->id . '/edit">
                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                    </a>';
                }
                if (auth()->user()->checkPermissionAccess("delete-$this->permission")) {
                    $this->html .= '<form method = "POST" class="action_deleteRecursive"
                                          data-url = "/admin/' . $this->stringUrl . '/' . $value->id . '/delete"
                                          action = "/admin/' . $this->stringUrl . '/' . $value->id . '/delete"
                                              >
                                       <input type = "hidden" name = "_token" value = "' . csrf_token() . '" />
                                       <input type = "hidden" name = "_method" value = "DELETE" />
                                        <button class="dropdown-item" type = "submit" >
                                            <i class="bx bx-trash me-1" ></i > Delete
                                        </button >
                                    </form >';
                }
                $this->html .= '</div >
                            </div >
                        </td >
                     </tr > ';
                $this->dataTableRecursive($value->id, $text . '--');
            }
        }
        return $this->html;
    }

    public function dataMultiSelectRecursive($categoriesOfProduct, $id = 0, $text = '')
    {
        foreach ($this->data as $value) {
            if ($value->parent_id == $id) {
                if (in_array($value->id, $categoriesOfProduct)){
                    $this->html .= "<option selected value= " . $value->id . " >" . $text . $value->name . "</option>";
                } else {
                    $this->html .= "<option value= " . $value->id . " >" . $text . $value->name . "</option>";
                }
                $this->dataMultiSelectRecursive($categoriesOfProduct, $value->id, $text . '--');
            }
        }
        return $this->html;
    }

    public function dataSelectRecursive($parent_id, $id = 0, $text = '')
    {
        foreach ($this->data as $value) {
            if ($value->parent_id == $id) {
                if (!empty($parent_id) && $parent_id == $value->id) {
                    $this->html .= "<option selected value= " . $value->id . " >" . $text . $value->name . "</option>";
                } else {
                    $this->html .= "<option value= " . $value->id . " >" . $text . $value->name . "</option>";
                }
                $this->dataSelectRecursive($parent_id, $value->id, $text . '--');
            }
        }
        return $this->html;
    }
}
