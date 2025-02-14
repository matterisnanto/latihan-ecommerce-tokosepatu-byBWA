<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Shoe;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    //
    protected $frontService;

    public function __construct(FrontService $frontService) //depedencies injection point
    {
        $this->frontService = $frontService;
    }

    public function index()
    {
        $products = $this->frontService->getLatestProducts();
        return view('front.index', compact('products'));
    }

    public function details(Shoe $shoe){ //model bindings
        return view('front.details', compact('shoe'));//compact itu menginject
    }

    public function category(Category $category){
        return view('front.category', compact('category'));
    }
}