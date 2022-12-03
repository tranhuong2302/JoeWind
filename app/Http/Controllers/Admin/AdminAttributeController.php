<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Attribute\AttributeRequest;
use App\Repositories\Interfaces\Admin\IAttributeRepository;
use App\Traits\ApiResponse;
use App\Traits\ToastNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminAttributeController extends Controller
{
    use ToastNotification;
    use ApiResponse;

    private $attributeRepo;

    public function __construct(IAttributeRepository $attributeRepo)
    {
        $this->attributeRepo = $attributeRepo;
    }

    public function index()
    {
        try {
            return view('admin.attributes.index');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }

    }

    public function create()
    {
        try {
            return view('admin.attributes.add');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function store(AttributeRequest $request)
    {
        try {
            DB::BeginTransaction();
            $data = [
                'attribute_name' => $request->input('name'),
                'attribute_description' => $request->input('description'),
            ];
            $values = $request->input('value');
            $attribute = $this->attributeRepo->createData($data);
            foreach ($values as $value) {
                if ($value != null) {
                    $attribute->values()->create([
                        'attribute_value_name' => $value
                    ]);
                }
            }
            if ($attribute) {
                $this->toastSuccess("Create attribute success", "Success");
                DB::commit();
                return redirect()->route('attributes.create');
            } else  return redirect()->back();
        } catch (Exception $e) {
            DB::rollback();
            $this->toastError("Error creating attribute", "Error");
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        try {
            $attribute = $this->attributeRepo->findDataById($id);
            return view('admin.attributes.update', compact('attribute'));
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function update(AttributeRequest $request, $id)
    {
        try {
            DB::BeginTransaction();
            $data = [
                'attribute_name' => $request->input('name'),
                'attribute_description' => $request->input('description'),
            ];
            $values = $request->input('value');
            $attribute = $this->attributeRepo->updateDataById($id, $data);
            foreach ($values as $idValue => $value) {
                if ($value != null) {
                    $attributeValue = $attribute->values()->find($idValue);
                    if ($attributeValue) {
                        $attributeValue->update([
                            'attribute_value_name' => $value
                        ]);
                    } else {
                        $attribute->values()->create([
                            'attribute_value_name' => $value
                        ]);
                    }
                }
            }
            if ($attribute) {
                $this->toastSuccess("Updated attribute successfully", "Success");
                DB::commit();
                return redirect()->route('attributes.index');
            } else  return redirect()->back();
        } catch (Exception $e) {
            DB::rollback();
            $this->toastError("Error updating attribute", "Error");
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function deleteAttributeById($id)
    {
        try {
            $this->attributeRepo->deleteDataById($id);
            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'Delete attribute success',
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function deleteAttributeValueById(Request $request, $id)
    {
        try {
            $attributeValuesId = $request->input('id');
            $attribute = $this->attributeRepo->findDataById($id);
            $attribute->values()->find($attributeValuesId)->delete();
            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'Delete attribute success',
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function deleteSelected(Request $request)
    {
        try {
            $ids = $request->input('ids');
            $this->attributeRepo->deleteMultipleData($ids);
            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'Delete selected attribute success',
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
