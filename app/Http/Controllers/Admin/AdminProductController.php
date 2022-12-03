<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\ProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Repositories\Interfaces\Admin\IAttributeRepository;
use App\Repositories\Interfaces\Admin\IAttributeValueRepository;
use App\Repositories\Interfaces\Admin\ICategoryRepository;
use App\Repositories\Interfaces\Admin\IProductRepository;
use App\Traits\ApiResponse;
use App\Traits\ToastNotification;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    use ToastNotification;
    use ApiResponse;

    private IProductRepository $productRepo;
    private ICategoryRepository $categoryRepo;
    private IAttributeRepository $attributeRepo;
    private IAttributeValueRepository $attribute_valueRepo;

    public function __construct(IProductRepository   $productRepository, ICategoryRepository $categoryRepository,
                                IAttributeRepository $attributeRepository, IAttributeValueRepository $attribute_valueRepo)
    {
        $this->productRepo = $productRepository;
        $this->categoryRepo = $categoryRepository;
        $this->attributeRepo = $attributeRepository;
        $this->attribute_valueRepo = $attribute_valueRepo;
    }

    public function index()
    {
        try {
            return view('admin.products.index');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            $attributes = $this->attributeRepo->getAll();
            $htmlOptions = $this->categoryRepo->getSelectRecursiveCategory(0);
            return view('admin.products.add', compact('attributes', 'htmlOptions'));
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }

    }

    public function store(ProductRequest $request)
    {
        try {
            DB::BeginTransaction();
            $data = [
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'discount' => $request->input('discount'),
                'quantity' => $request->input('quantity'),
                'description' => $request->input('description'),
                'status' => $request->input('status'),
                'is_feature' => $request->input('is_feature'),
                'slug' => Str::slug($request->input('name')),
            ];
            $category_id = $request->input('category_id');
            $attribute_value = $request->input('attribute_value');

            $product = $this->productRepo->createData($data);
            $product->productCategories()->attach($category_id);
            $product->productAttributeValues()->attach($attribute_value);

            $image_path = $request->hasFile('image_path');
            if ($image_path) {
                foreach ($request->file('image_path') as $image) {
                    $uploadedFileUrl = Cloudinary::upload($image->getRealPath(), [
                        'folder' => 'Product',
                    ])->getSecurePath();
                    $product->images()->create([
                        'image_path' => $uploadedFileUrl,
                    ]);
                }
            }
            $this->toastSuccess("Create Product Success", "Success");
            DB::commit();
            return redirect()->route('products.index');
        } catch (Exception $e) {
            DB::rollback();
            $this->toastError("Error creating product", "Error");
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }

    }

    public function edit($id)
    {
        try {
            $product = $this->productRepo->findDataById($id);

            //get Categories
            $catsId = array();
            $categoriesOfProduct = $this->productRepo->getCategoryIdsByProductId($id);
            foreach ($categoriesOfProduct as $cat) {
                $catsId[] = $cat->category_id;
            }
            $htmlOptions = $this->categoryRepo->getMultiSelectRecursiveCategory($catsId);

            //get Attribute, Attribute values
            $attributesOfProduct = $product->productAttributeValues;
            $attributes = $this->attributeRepo->getAll();
            $attributeId = array();
            foreach ($attributesOfProduct as $attributeOfProduct) {
                array_push($attributeId, $attributeOfProduct->attribute_id);
            }
            if (array_key_exists(0, $attributeId))
                $attribute_values = $this->attribute_valueRepo->getAttributeValueByAttributeId($attributesOfProduct[0]->attribute_id);
            else {
                $attribute_values = $this->attribute_valueRepo->getAll();
                $attributesOfProduct = [0 => null];
            }
            return view('admin.products.update', compact('product', 'htmlOptions', 'attributes', 'attribute_values', 'attributesOfProduct'));
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }

    }

    public function update(UpdateProductRequest $request, $id)
    {
        try {
            DB::BeginTransaction();
            $data = [
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'discount' => $request->input('discount'),
                'quantity' => $request->input('quantity'),
                'description' => $request->input('description'),
                'status' => $request->input('status'),
                'is_feature' => $request->input('is_feature'),
                'slug' => Str::slug($request->input('name')),
            ];
            $category_id = $request->input('category_id');
            $attribute_value = $request->input('attribute_value');

            $product = $this->productRepo->updateDataById($id, $data);
            $product->productCategories()->sync($category_id);
            $product->productAttributeValues()->sync($attribute_value);

            $image_path = $request->hasFile('image_path');
            if ($image_path) {
                $product->images()->delete();
                foreach ($request->file('image_path') as $image) {
                    $uploadedFileUrl = Cloudinary::upload($image->getRealPath(), [
                        'folder' => 'Product',
                    ])->getSecurePath();
                    $product->images()->create([
                        'image_path' => $uploadedFileUrl,
                    ]);
                }
            }
            $this->toastSuccess("Update Product Success", "Success");
            DB::commit();
            return redirect()->route('products.index');
        } catch (Exception $e) {
            DB::rollback();
            $this->toastError("Error updating product", "Error");
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }

    }

    public function deleteProductById($id)
    {
        try {
            $this->productRepo->deleteDataById($id);
            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'Delete product success',
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function deleteSelected(Request $request)
    {
        try {
            $ids = $request->input('ids');
            $this->productRepo->deleteMultipleData($ids);
            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'Delete selected products success',
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
