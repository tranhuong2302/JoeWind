<?php

namespace App\Helpers;

class Recursive
{
    private $data;
    private $html;

    public function __construct($data)
    {
        $this->data = $data;

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
                        <td>' . $text . $value->name . '</td>
                        <td>' . $value->display_name . '</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item"  href="/admin/permissions/' . $value->id . '/edit">
                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                    </a>
                                    <form method="POST" class="action_deleteRecursive"
                                          data-url="/api/admin/permissions/' . $value->id . '/delete"
                                          action="/api/admin/permissions/' . $value->id . '/delete"
                                    >
                                       <input type="hidden" name="_token" value="' . csrf_token() . '"/>
                                       <input type="hidden" name="_method" value="DELETE" />
                                        <button class="dropdown-item" type="submit" >
                                            <i class="bx bx-trash me-1"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                     </tr>';
                $this->dataTableRecursive($value->id, $text . '--');
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
