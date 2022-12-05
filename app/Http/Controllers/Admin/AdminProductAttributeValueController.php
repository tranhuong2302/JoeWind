<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\Admin\IProductAttributeValueRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Session;

class AdminProductAttributeValueController extends Controller
{
    use ApiResponse;

    private IProductAttributeValueRepository $productAttributeValueRepo;

    public function __construct(IProductAttributeValueRepository $productAttributeValueRepo)
    {
        $this->productAttributeValueRepo = $productAttributeValueRepo;
    }

    public function index()
    {
        try {
            return view('admin.productvalues.index');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

}
