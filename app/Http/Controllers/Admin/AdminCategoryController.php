<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CategoryRequest;
use App\Repositories\Interfaces\Admin\ICategoryRepository;
use App\Traits\ApiResponse;
use App\Traits\ToastNotification;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use CloudinaryLabs\CloudinaryLaravel\MediaAlly;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Request;

class AdminCategoryController extends Controller
{
    use ToastNotification;
    use MediaAlly;
    use ApiResponse;

    private $categoryRepo;

    public function __construct(ICategoryRepository $categoryRepository)
    {
        $this->categoryRepo = $categoryRepository;
    }

    public function index()
    {
        try {
            $html = $this->categoryRepo->getDataTableRecursivePermissions();
            return view('admin.categories.index', compact('html'));
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }

    }

    public function create()
    {
        try {
            $htmlOptions = $this->categoryRepo->getSelectRecursivePermissions(0);
            return view('admin.categories.add', compact('htmlOptions'));
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function store(CategoryRequest $request)
    {
        try {
            DB::BeginTransaction();
            $data = [
                'name' => $request->get('name'),
                'parent_id' => $request->get('parent_id'),
                'description' => $request->get('description'),
                'slug' => Str::slug($request->get('name'))
            ];
            $image_path = $request->hasFile('image_path');
            if ($image_path) {
                // Upload an Image File to Cloudinary with One line of Code
                $uploadedFileUrl = Cloudinary::upload($request->file('image_path')->getRealPath(), [
                    'folder' => 'Category',
                ])->getSecurePath();
                if (!empty($uploadedFileUrl)) {
                    $data['image_path'] = $uploadedFileUrl;
                }
            }
            $category = $this->categoryRepo->createData($data);
            if ($category) {
                $this->toastSuccess("Create category success", "Success");
                DB::commit();
                return redirect()->route('categories.create');
            } else  return redirect()->back();
        } catch (Exception $e) {
            DB::rollback();
            $this->toastError("Error creating category", "Error");
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        try {
            $category = $this->categoryRepo->findDataById($id);
            $htmlOptions = $this->categoryRepo->getSelectRecursivePermissions($category->parent_id);
            return view('admin.categories.update', compact('category', 'htmlOptions'));
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function update(CategoryRequest $request, $id)
    {
        try {
            DB::BeginTransaction();
            $data = [
                'name' => $request->get('name'),
                'parent_id' => $request->get('parent_id'),
                'description' => $request->get('description'),
                'slug' => Str::slug($request->get('name'))
            ];
            $image_path = $request->hasFile('image_path');
            if ($image_path) {
                // Upload an Image File to Cloudinary with One line of Code
                $uploadedFileUrl = Cloudinary::upload($request->file('image_path')->getRealPath(), [
                    'folder' => 'Category',
                ])->getSecurePath();
                if (!empty($uploadedFileUrl)) {
                    $data['image_path'] = $uploadedFileUrl;
                }
            }
            $category = $this->categoryRepo->updateDataById($id, $data);
            if ($category) {
                $this->toastSuccess("Updated category successfully", "Success");
                DB::commit();
                return redirect()->route('categories.index');
            } else  return redirect()->back();

        } catch (Exception $e) {
            DB::rollback();
            $this->toastError("Error updating category", "Error");
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function deleteCategoryById($id)
    {
        try {
            $this->categoryRepo->deleteDataById($id);
            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'Delete category success',
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function deleteSelected(Request $request)
    {
        try {
            $ids = $request->get('ids');
            $this->categoryRepo->deleteMultipleData($ids);
            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'Delete selected category success',
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
