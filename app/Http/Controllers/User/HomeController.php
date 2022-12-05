<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\User\IHomeRepository;
use Exception;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    private IHomeRepository $homeRepo;

    public function __construct(IHomeRepository $homeRepo)
    {
        $this->homeRepo = $homeRepo;
    }

    public function index()
    {
        try {
            $categories = $this->homeRepo->getCategoryRootFeatures();
            return view('user.index', compact('categories'));
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }
}
