<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Auctiontype;
use App\Models\BidPlaced;
use App\Models\BidRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Project;

use Carbon\Carbon;


use Illuminate\Support\Facades\Log;


class UserCategoryController extends Controller
{
    public function index(){

        $categories = Category::withCount('projects')->get();





        return view('frontend.categories',compact('categories'));
    }
}
