<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Auctiontype;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Helpsupport;
use App\Models\Product;
use App\Models\Project;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\BidRequest;
use App\Models\Bidvalue;
use App\Models\BidPlaced;
use App\Models\Useraddress;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Support\Facades\DB;
use App\Models\Gallery;
use App\Mail\BidPlacedMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\OutbidNotification;
use App\Models\Notification;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use Dompdf\Options;





class ProductApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'verifyOTP', 'forgotpassword', 'resetpassword','generate','downloadInvoice']]);
    }
    // categories api
    public function categories(Request $request)
{
    try {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'ResponseCode' => 401,
                'Status' => 'Error',
                'Message' => 'User not authenticated',
            ], 401);
        }

        $langId = $user->lang_id; 
        $search = $request->input('search');

        // 
        $currentDateTime = now();

      
        $query = Category::where('status', 1)
            ->whereHas('projects.products', function ($query) use ($currentDateTime) {
                $query->where('end_date_time', '>=', $currentDateTime);
            })
            ->select('id','image_path');

        if ($langId == 'ar') {
            $query->addSelect(['name_ar as name']);
        } else {
            $query->addSelect(['name']);
        }

        if ($search) {
            $query = $query->where('name', 'like', '%' . $search . '%');
        }

        $categories = $query->get()->map(function ($cat) {
            $cat->image_path = asset("img/users/" . $cat->image_path);
            return $cat;
        });

        return response()->json([
            'ResponseCode' => 200,
            'Status' => 'true',
            'Message' => 'Data Retrieved Successfully',
            'data' => [
                'categories' => $categories,
            ],
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'ResponseCode' => 500,
            'Status' => 'False',
            'Message' => $e->getMessage(),
        ], 500);
    }
}

    // homepage api
    // public function homepage(Request $request)
    // {
    //     try {
    //         $user = Auth::user(); 

    //         if (!$user) {
    //             return response()->json([
    //                 'ResponseCode' => 401,
    //                 'Status' => 'Error',
    //                 'Message' => 'User not authenticated',
    //             ], 401);
    //         }

    //         $langId = $user->lang_id;
    //         $currency = $user->currency_code; 
    //         $banners = Banner::where('status', 1)->select(
    //             ($langId == 'ar') ? 'title_ar as title' : 'title',
    //             ($langId == 'ar') ? 'description_ar as description' : 'description',
    //             'image_path'
    //         )->get();
        
    //         foreach ($banners as $banner) {
    //             $banner->description = strip_tags($banner->description);
    //             $banner->image_path = asset("img/users/" . $banner->image_path);
    //         }

    //         $categories = Category::whereHas('projects.products')->where('status', 1)
    //                 ->select(
    //                     'id',
    //                     ($langId == 'ar') ? 'name_ar as name' : 'name',
    //                     'image_path'
    //                 )
    //                 // ->with(['projects' => function ($query) {
    //                 //     $query->has('products');
    //                 // }])
    //                 ->get();
    //         foreach ($categories as $cat) {
    //             $cat->image_path = asset("img/users/" . $cat->image_path);
    //         }
    //         $projects = Project::where('is_trending', 1)
    //                                 ->where('status', 1)
    //                                 ->has('products') 
    //                                 ->with(['auctionType', 'products' => function ($query) {
    //                                     $query->where('status', 1)
    //                                         ->orderBy('updated_at', 'desc')
    //                                         ->take(4); 
    //                                 }])
    //                                 ->get();
    //                                 $categorizedProjects = [];

    //                                 foreach ($projects as $project) {
    //                                     $type = $project->auctionType->type ?? 'DefaultType'; 
    //                                     if (!isset($categorizedProjects[$type])) {
    //                                         $categorizedProjects[$type] = [];
    //                                     }
    //         $isBidRequestedAndApproved = BidRequest::where('project_id', $project->id)
    //                                         ->where('status', 1)
    //                                         ->exists();

    //             $categorizedProjects[$type][] = [
    //                 'id' => $project->id,
    //                 'title' => ($langId == 'ar') ? $project->name_ar : $project->name,
    //                 'image_path' => asset("img/projects/" . $project->image_path),
    //                 'start_date_time' => Carbon::parse($project->start_date_time)->format('F j, h:i A'),
    //                 'auction_type_id' => $project->auctionType->id,
    //                 'auction_type_name' => ($langId == 'ar') ? $project->auctionType->name_ar : $project->auctionType->name,
    //                 'deposit_amount' => formatPrice($project->deposit_amount, $currency),
    //                 'is_bid' => $isBidRequestedAndApproved,
    //             ];
    //         }
    //         $mostRecentBids = BidPlaced::select(
    //             'product_id',
    //             DB::raw('MAX(bid_amount) as max_bid_amount'),
    //             DB::raw('COUNT(*) as bid_count')
    //         )
    //             ->where('status', 1)
    //             ->groupBy('product_id')
    //             ->orderBy('max_bid_amount', 'desc')
    //             ->with(['product' => function ($query) use ($langId, $currency) {
    //                 $query->select(
    //                     'id',
    //                     'lot_no',
    //                     ($langId == 'ar') ? 'title_ar as title' : 'title',
    //                     'auction_type_id',
    //                     'auction_end_date'
    //                 )
    //                     ->with(['productGalleries' => function ($query) {
    //                         $query->select('product_id', 'image_path');
    //                     }, 'auctionType' => function ($query) use ($langId, $currency) {
    //                         $query->select(
    //                             'id',
    //                             ($langId == 'ar') ? 'name_ar as name' : 'name',
    //                             );
    //                     }]);
    //             }])
    //             ->get();
    //             foreach ($mostRecentBids as $bid) {
    //                 $product = $bid->product;
    //                 $bid->max_bid_amount = formatPrice($bid->max_bid_amount, $currency);
    //             }
    
            
    //         $productauction = AuctionType::with(['products' => function ($query) {
    //                                     $query->where('status', 1)
    //                                         ->where('is_popular', 1);
    //                                 }, 'galleries'])->where('status', 1)->get();
             
    //         $popular = [];

    //         foreach ($productauction as $auctionType) {
    //             $auctionTypeName = $auctionType->name;
    //             $auctionTypeIcon = '';
    //             if ($auctionTypeName === 'Private') {
    //                 $auctionTypeIcon = asset('auctionicon/private_icon.png');
    //             } elseif ($auctionTypeName === 'Timed') {
    //                 $auctionTypeIcon = asset("auctionicon/time.png");
    //             } elseif ($auctionTypeName === 'Live') {
    //                 $auctionTypeIcon = asset("auctionicon/live.png");
    //             }

    //             $loggedInUser = Auth::user();
    //             foreach ($auctionType->products as $product) {
    //                 $id = $product->id;
    //                 $lotNumber = $product->lot_no;
    //                 $reserved = $product->reserved_price;
    //                 $productTitle = ($langId == 'ar') ? $product->title_ar : $product->title;
    //                 $productDescription = ($langId == 'ar') ? strip_tags($product->description_ar) : strip_tags($product->description);
    //                 $auctionEndDate = "";

    //                 if ($auctionTypeName === 'Private' || $auctionTypeName === 'Timed') {
    //                     if (strtotime($product->auction_end_date) > strtotime('now')) {
    //                         $timestamp = strtotime($product->auction_end_date);
    //                         $milliseconds = $timestamp * 1000;
    //                         $auctionEndDate = $milliseconds;
    //                     } else {
    //                         $auctionEndDate = 0;
    //                     }
    //                 } else {
    //                     $auctionEndDate = 0;
    //                 }
                
    //                 if ($product->galleries->isNotEmpty()) {
    //                     $imagePath = $product->galleries->first()->image_path;
    //                 } else {
    //                     $imagePath = asset('frontend/images/default-product-image.png');
    //                 }
                    
    //                 $popular[] = [
    //                     'auction_type_name' => ($langId == 'ar') ? $project->auctionType->name_ar : $project->auctionType->name,
    //                     'auction_type_icon' => $auctionTypeIcon,
    //                     'product_id' => $id,
    //                     'image_path' => $imagePath,
    //                     'reserved_price' => formatPrice($reserved, $currency),
    //                     'lot_no' => $lotNumber,
    //                     'product_title' => $productTitle,
    //                     'product_description' => $productDescription,
    //                     'auction_end_date' => $auctionEndDate,
    //                     'current_bid' => '',
    //                     'is_wishlist' => $loggedInUser ? $loggedInUser->wishlists->contains('product_id', $product->id) : false,
    //                 ];
    //             }
    //         }
    //         return response()->json([
    //             'ResponseCode' => 200,
    //             'Status' => 'true',
    //             'Message' => 'Data Retrived Successfully',
    //             'data' => [
    //                 'banners' => $banners,
    //                 'categories' => $categories,
    //                 'projects' => $categorizedProjects,
    //                 'popular' => $popular,
    //                 'most_bids' => $mostRecentBids,
    //             ],
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'ResponseCode' => 500,
    //             'Status' => 'False',
    //             'Message' => $e->getMessage(),
    //         ], 500);
    //     }
    // }
    public function homepage(Request $request)
    {
        try {
            $user = Auth::user(); 

            if (!$user) {
                return response()->json([
                    'ResponseCode' => 401,
                    'Status' => 'Error',
                    'Message' => 'User not authenticated',
                ], 401);
            }

            $langId = $user->lang_id;
            $currency = $user->currency_code; 
            // $banners = Banner::where('status', 1)->select(
            //         ($langId == 'ar') ? 'title_ar as title' : 'title',
            //         ($langId == 'ar') ? 'description_ar as description' : 'description',
            //         'image_path'
            //     )->get();
            
            // foreach ($banners as $banner) {
            //     $banner->description = strip_tags($banner->description);
            //     $banner->image_path = asset("img/users/" . $banner->image_path);
            // }
            $banners = Banner::where('status', 1)->select(
                'id',
                ($langId == 'ar') ? 'title_ar as title' : 'title',
                ($langId == 'ar') ? 'description_ar as description' : 'description',
                'image_path',
                'url' 
            )->get();

            foreach ($banners as $banner) {
                $banner->description = strip_tags($banner->description);
                $banner->image_path = asset("img/users/" . $banner->image_path);

                $projectDetails = Project::where('slug', $banner->url)->first();
                
                if ($projectDetails) {
                    $banner->project_ID = $projectDetails->id;
                    $banner->project_Title = ($langId == 'ar') ? $projectDetails->name_ar : $projectDetails->name;
                    $banner->project_start_date_time_actual = $projectDetails->start_date_time;
                    $banner->project_auction_type_name = ($langId == 'ar') ? $projectDetails->auctionType->name_ar : $projectDetails->auctionType->name;
                    $banner->project_end_date_time = $projectDetails->end_date_time;
                    $banner->project_is_bid = BidRequest::where('project_id', $projectDetails->id)
                                                ->where('user_id', $user->id)
                                                ->pluck('status')
                                                ->first();
                    $banner->project_depositAmount = $projectDetails->deposit_amount;
                }
            }
          
            $currentDateTime = now();

            $categories = Category::where('status', 1)
                ->whereHas('projects.products', function ($query) use ($currentDateTime) {
                    $query->where('end_date_time', '>=', $currentDateTime);
                })
                ->withCount([
                    'projects' => function ($query) use ($currentDateTime) {
                        $query->whereHas('products', function ($productQuery) use ($currentDateTime) {
                            $productQuery->where('end_date_time', '>=', $currentDateTime);
                        })->orderBy('start_date_time', 'ASC');
                    },
                ])
                ->orderBy('name', 'ASC')
                ->select(
                    'id',
                    ($langId == 'ar') ? 'name_ar as name' : 'name',
                    'image_path'
                )
                ->get();

            foreach ($categories as $cat) {
                $cat->image_path = asset("img/users/" . $cat->image_path);
            }

            $currentDateTime = now();
            $projects = Project::where('is_trending', 1)
                                    ->where('status', 1)
                                    ->orderBy('start_date_time', 'ASC')
                                    ->where('end_date_time', '>=', $currentDateTime)
                                    ->has('products') 
                                    ->with(['auctionType', 'products' => function ($query) {
                                        $query->where('status', 1)
                                            ->orderBy('updated_at', 'desc')
                                            ->take(4); 
                                    }])
                                    ->get();
                                    $categorizedProjects = [];

                                    foreach ($projects as $project) {
                                        $type = $project->auctionType->type ?? 'DefaultType'; 
                                        if (!isset($categorizedProjects[$type])) {
                                            $categorizedProjects[$type] = [];
                                        }
            // $isBidRequestedAndApproved = BidRequest::where('project_id', $project->id)
            //                                 ->where('user_id',$user->id);
            $isBidRequestedAndApproved = BidRequest::where('project_id', $project->id)
                                            ->where('user_id', $user->id)
                                            ->pluck('status')
                                            ->first();
    

                $categorizedProjects[$type][] = [
                    'id' => $project->id,
                    'title' => ($langId == 'ar') ? $project->name_ar : $project->name,
                    'image_path' => asset("img/projects/" . $project->image_path),
                    'start_date_time' => Carbon::parse($project->start_date_time)->format('F j, h:i A'),
                    'start_date_time_actual' => $project->start_date_time,
                    'auction_type_id' => $project->auctionType->id,
                    'auction_type_name' => ($langId == 'ar') ? $project->auctionType->name_ar : $project->auctionType->name,
                    'deposit_amount' => (float) number_format(str_replace(',', '', formatPrice($project->deposit_amount, $currency)), 2, '.', ''),
                    'end_date_time'  => $project->end_date_time,
                    'currency'     =>$currency,
                    'is_bid' => $isBidRequestedAndApproved,
                ];
            }

            $mostRecentBids = BidPlaced::select(
                'product_id',
                DB::raw('MAX(bid_amount) as max_bid_amount'),
                DB::raw('COUNT(DISTINCT user_id) as bid_count')
            )
                ->where('sold', 1)
                ->groupBy('product_id')
                ->orderBy('max_bid_amount', 'desc')
                ->with(['product' => function ($query) use ($langId, $currency) {
                    $query->select(
                        'id',
                        'lot_no',
                        'minsellingprice',
                        ($langId == 'ar') ? 'title_ar as title' : 'title',
                        'auction_type_id',
                        'auction_end_date',
                        'project_id',
                    
                        
                    )
                        ->with(['productGalleries' => function ($query) {
                            $query->select('product_id', 'image_path');
                        }, 'auctionType' => function ($query) use ($langId, $currency) {
                            $query->select(
                                'id',
                                ($langId == 'ar') ? 'name_ar as name' : 'name',
                                );
                        }])
                        ->with(['project' => function ($query) {
                            $query->select(
                                'id',
                                'name',
                                'start_date_time',
                                'end_date_time',
                                'deposit_amount'
                            );
                        }]);
                }])
                ->get();
                // $recentBids = [];
                
                foreach ($mostRecentBids as $bid) {
                    $product = $bid->product;
                    $bid->max_bid_amount = formatPrice($bid->max_bid_amount, $currency);
                    $bid->currency = $currency;
                    $bid->project_id = $product->project_id;
                    $bid->project_name = $product->project->name;
                    $bid->project_start_date_time = $product->project->start_date_time;
                    $bid->project_end_date_time = $product->project->end_date_time;
                    $bid->project_deposit_amount = $product->project->deposit_amount;
                     // Check if the product is in the user's wishlists
                     $loggedInUser = Auth::user(); 
                   $bid->is_wishlist = $loggedInUser ? $loggedInUser->wishlists->contains('product_id', $product->id) : false;

                    $bid->isBidRequestedAndApproved = BidRequest::where('project_id', $bid->project_id)
                                                    ->where('user_id', $user->id)
                                                    // ->where('status', 1)
                                                    // ->exists();
                                                    ->pluck('status')
                                                    ->first();
                                                   
                }
                
            $currentDateTime = now();
            $productauction = AuctionType::with(['products' => function ($query) use ($currentDateTime) {
                                        $query->where('status', 1)
                                            ->where('is_popular', 1)
                                            ->whereHas('project', function ($subquery) use ($currentDateTime) {
                                                $subquery->where('end_date_time', '>=', $currentDateTime);
                                            });
                                    }, 'galleries'])->where('status', 1)->get();
             
            $popular = [];

            foreach ($productauction as $auctionType) {
                $auctionTypeName = $auctionType->name;
                $auctionTypeIcon = '';
                if ($auctionTypeName === 'Private') {
                    $auctionTypeIcon = asset('auctionicon/private_icon.png');
                } elseif ($auctionTypeName === 'Timed') {
                    $auctionTypeIcon = asset("auctionicon/time.png");
                } elseif ($auctionTypeName === 'Live') {
                    $auctionTypeIcon = asset("auctionicon/live.png");
                }

                $loggedInUser = Auth::user();
                foreach ($auctionType->products as $product) {
                    $id = $product->id;
                    $lotNumber = $product->lot_no;
                    $reserved = $product->reserved_price;
                    $project = Project::find($product->project_id);
                    $projectname = $project ? $project->name : '';
                    $projectstartdatetime = $project ? $project->start_date_time : '';
                    $projectenddatetime = $project ? $project->end_date_time : '';
                    $prodepositamount = $project ? $project->deposit_amount : '';
                    $productTitle = ($langId == 'ar') ? $product->title_ar : $product->title;
                    $productDescription = ($langId == 'ar') ? strip_tags($product->description_ar) : strip_tags($product->description);
                    $productDescription = ($langId == 'ar') ? strip_tags($product->description_ar) : strip_tags($product->description);
                    $productDescription = trim(html_entity_decode($productDescription, ENT_QUOTES, 'UTF-8'));

                    $auctionEndDate = "";

                    if ($auctionTypeName === 'Private' || $auctionTypeName === 'Timed') {
                        if (strtotime($product->auction_end_date) > strtotime('now')) {
                            $timestamp = strtotime($product->auction_end_date);
                            $milliseconds = $timestamp * 1000;
                            $auctionEndDate = $milliseconds;
                        } else {
                            $auctionEndDate = 0;
                        }
                    } else {
                        $auctionEndDate = 0;
                    }
                
                    if ($product->galleries->isNotEmpty()) {
                        $imagePath = $product->galleries->first()->image_path;
                    } else {
                        $imagePath = asset('frontend/images/default-product-image.png');
                    }
                    $currentBid = BidPlaced::where('product_id', $product->id)
                                    // ->where('status', 1)
                                    ->orderBy('bid_amount', 'desc')
                                    ->first();
                                   
                                
                    $currentBidAmount = $currentBid ? formatPrice($currentBid->bid_amount, $currency) : '';

                    $isBidRequested = BidRequest::where('project_id', $product->project_id)
                                            ->where('user_id',$user->id)
                                            // ->where('status', 1)
                                            // ->exists();
                                            ->pluck('status')
                                            ->first();
                    $sold = BidPlaced::where('product_id', $product->id)
                                            ->where('sold', 2)
                                            ->where('status', '!=', 0)
                                            ->orderBy('bid_amount', 'desc')
                                            ->first();
                    $soldBidAmount =$sold ? formatPrice($sold->bid_amount, $currency) : '';
                    $popular[] = [
                        'auction_type_name' => ($langId == 'ar') ? $product->project->auctionType->name_ar : $product->project->auctionType->name,
                        'auction_type_icon' => $auctionTypeIcon,
                        'product_id' => $id,
                        'image_path' => $imagePath,
                        'reserved_price' => formatPrice($reserved, $currency),
                        'currency'     =>$currency,
                        'lot_no' => $lotNumber,
                        'product_title' => $productTitle,
                        'product_description' => $productDescription,
                        'auction_end_date' => $auctionEndDate,
                        'auction_end_date_actual'=>$product->auction_end_date,
                        'current_bid' => $currentBidAmount,
                        'minimumsellingprice' => $product->minsellingprice,
                        'is_wishlist' => $loggedInUser ? $loggedInUser->wishlists->contains('product_id', $product->id) : false,
                        'project_id' => $product->project_id,
                        'project_name' => $projectname,
                        'project_start_date_time' =>$projectstartdatetime,
                        'project_end_date_time' =>$projectenddatetime,
                        'project_deposit_amount' =>  $prodepositamount,
                        'is_bid' => $isBidRequested,
                        'sold'  => $soldBidAmount,
                         
                    ];
                }
            }
            if (empty($categorizedProjects)) {
                $categorizedProjects = null;
            }
            return response()->json([
                'ResponseCode' => 200,
                'Status' => 'true',
                'Message' => 'Data Retrived Successfully',
                'data' => [
                    'banners' => $banners,
                    'categories' => $categories,
                    'projects' => $categorizedProjects,
                    'popular' => $popular,
                    'most_bids' => $mostRecentBids,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'ResponseCode' => 500,
                'Status' => 'False',
                'Message' => $e->getMessage(),
            ], 500);
        }
    }

    // product list api based on project_id

    public function productlistbasedproject(Request $request)
    {
        try {
            $rules = [
                'project_id' => 'required|exists:projects,id',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $firstErrorMessage = $validator->errors()->first();
                return response()->json([
                    'ResponseCode' => 422,
                    'Status' => 'False',
                    'Message' => $firstErrorMessage,
                ], 422);
            }
            $user = Auth::user(); 

            if (!$user) {
                return response()->json([
                    'ResponseCode' => 401,
                    'Status' => 'Error',
                    'Message' => 'User not authenticated',
                ], 401);
            }

            // $langId = $user->lang_id; 
            $langId = $user->lang_id;
            $currency = $user->currency_code; 
            $project = Project::find($request->project_id);
            if (!$project) {
                return response()->json([
                    'ResponseCode' => 404,
                    'Status' => 'False',
                    'Message' => 'Project not found',
                ], 404);
            }

            $auctionType = AuctionType::find($project->auction_type_id);

            $productsQuery = Product::where('project_id', $request->project_id);

            // Search based on product title if a search term is provided
            if ($request->has('search') && !empty($request->search)) {
                $searchTerm = $request->search;
                $productsQuery->where('title', 'LIKE', '%' . $searchTerm . '%');
            }

            $products = $productsQuery->get();
            $loggedInUser = Auth::user();

            $productList = [];
            foreach ($products as $product) {
                $auctionEndDate = null;

                if ($auctionType && ($auctionType->name === 'Private' || $auctionType->name === 'Timed')) {
                    if (strtotime($product->auction_end_date) > strtotime('now')) {
                        $timestamp = strtotime($product->auction_end_date);
                        $milliseconds = $timestamp * 1000;
                        $auctionEndDate = $milliseconds;
                    } else {
                        $auctionEndDate = 0;
                    }
                } else {
                    $auctionEndDate = 0;
                }
                $productImage = null;
                if ($product->galleries->isNotEmpty()) {
                    $productImage = $product->galleries->first()->image_path;
                }
                $currentBid = BidPlaced::where('product_id', $product->id)
                                    ->where('sold', 1)
                                    ->orderBy('bid_amount', 'desc')
                                    ->first();
               $currentBidAmount = $currentBid ? formatPrice($currentBid->bid_amount, $currency) : '';
               $sold = BidPlaced::where('product_id', $product->id)
                        ->where('sold', 2)
                        ->where('status', '!=', 0)
                        ->orderBy('bid_amount', 'desc')
                        ->first();
                 $soldBidAmount =$sold ? formatPrice($sold->bid_amount, $currency) : '';
                $productList[] = [
                    'id' => $product->id,
                    'lot_no' => $product->lot_no,
                    'title' => ($langId == 'ar') ?  $product->title_ar :  $product->title,
                    'product_image' => $productImage,
                    'reserved_price' => $product->reserved_price,
                    'minsellingprice' => $product->minsellingprice,
                    'reserved_price' => formatPrice($product->reserved_price, $currency),
                    'currency'     => $currency,
                    'auction_end_date' => $auctionEndDate,
                    'auction_end_date_actual'=>$product->auction_end_date,
                    'is_wishlist' => $loggedInUser ? $loggedInUser->wishlists->contains('product_id', $product->id) : false,
                    'current_bid' => $currentBidAmount,
                    'sold'  => $soldBidAmount,
                ];
            }
            $auctionTypeName = $auctionType->name ?? null;
            $auctionTypeIcon = '';
            if ($auctionTypeName === 'Private') {
                $auctionTypeIcon = asset('auctionicon/private_icon.png');
            } elseif ($auctionTypeName === 'Timed') {
                $auctionTypeIcon = asset('auctionicon/time.png');
            } elseif ($auctionTypeName === 'Live') {
                $auctionTypeIcon = asset('auctionicon/live.png');
            }
            $isBidRequestedAndApproved = BidRequest::where('project_id', $project->id)
                                    // ->where('status', 1)
                                    // ->exists();
                                    ->where('user_id', $user->id)
                                    ->pluck('status')
                                    ->first();
                                  
            return response()->json([
                'ResponseCode' => 200,
                'Status' => 'True',
                'Message' => 'Data Retrieved Successfully',
                'data' => [
                    'project_id' => $project->id,
                    // 'project_name' => $project->name,
                    'project_name' => ($langId == 'ar') ? $project->name_ar : $project->name,
                    // 'deposit_amount' => formatPrice($project->deposit_amount, $currency),
                    'deposit_amount'  => intval(str_replace(',', '', formatPrice($project->deposit_amount, $currency))),
                    'currency'     => $currency,
                    'is_bid' => $isBidRequestedAndApproved,
                    'project_start_date' => Carbon::parse($project->start_date_time)->format('F j, h:i A'),
                    'project_start_date_actual' => $project->start_date_time,
                    'project_end_date_actual'   =>$project->end_date_time,
                    // 'auction_type_name' => $auctionType->name ?? null,
                    'auction_type_name' => ($langId == 'ar') ? $auctionType->name_ar : $auctionType->name,
                    'auction_type_icon' => $auctionTypeIcon,
                    'products' => $productList,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'ResponseCode' => 500,
                'Status' => 'False',
                'Message' => $e->getMessage(),
            ], 500);
        }
    }
    // projectlist based on auctiontype
    public function projectlistbasedauction(Request $request)
    {
        try {
            $rules = [
                'auction_type_id' => 'required|exists:auction_types,id',
                'project_name' => '',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $firstErrorMessage = $validator->errors()->first();
                return response()->json([
                    'ResponseCode' => 422,
                    'Status' => 'False',
                    'Message' => $firstErrorMessage,
                ], 422);
            }
            $user = Auth::user(); 
            $currentDateTime = now();
            if (!$user) {
                return response()->json([
                    'ResponseCode' => 401,
                    'Status' => 'Error',
                    'Message' => 'User not authenticated',
                ], 401);
            }

            $langId = $user->lang_id; 
            $currency = $user->currency_code; 
            $auctionType = AuctionType::find($request->auction_type_id);
            if (!$auctionType) {
                return response()->json([
                    'ResponseCode' => 404,
                    'Status' => 'False',
                    'Message' => 'Auction type not found',
                ], 404);
            }

            // $projectsQuery = Project::where('auction_type_id', $auctionType->id);
            $projectsQuery = Project::with('products')->where('end_date_time', '>=', $currentDateTime)->where('auction_type_id', $auctionType->id);
             
            // p($projectsQuery);
            $projectsQuery->whereHas('products', function ($query) {
                });

            // Add project name search if provided in the request
            if ($request->has('project_name')) {
                $projectsQuery->where('name', 'like', '%' . $request->project_name . '%');
            }

            $projects = $projectsQuery->get();

            $auctionTypeName = $auctionType->name ?? null;
            $auctionTypeIcon = '';

            if ($auctionTypeName === 'Private') {
                $auctionTypeIcon = asset('auctionicon/private_icon.png');
            } elseif ($auctionTypeName === 'Timed') {
                $auctionTypeIcon = asset('auctionicon/time.png');
            } elseif ($auctionTypeName === 'Live') {
                $auctionTypeIcon = asset('auctionicon/live.png');
            }

            $responseData = [
                'ResponseCode' => 200,
                'Status' => 'True',
                'Message' => 'Data Retrieved Successfully',
                'data' => [],
            ];
           
            foreach ($projects as $project) {
                  // Check if bid request exists and is approved for the project
                $isBidRequestedAndApproved = BidRequest::where('project_id', $project->id)
                                            // ->where('status', 1)
                                            // ->exists();
                                            ->where('user_id', $user->id)
                                            ->pluck('status')
                                            ->first();
                                           
                $responseData['data'][] = [
                    'id' => $project->id,
                    'title' => ($langId == 'ar') ? $project->name_ar : $project->name,
                    'image_path' => asset("img/projects/" . $project->image_path),
                    'start_date_time' => Carbon::parse($project->start_date_time)->format('F j, h:i A'),
                    'end_date_time'  => $project->end_date_time,
                    'start_date_time_actual' => $project->start_date_time,
                    'auction_type_name' => ($langId == 'ar') ? $auctionType->name_ar : $auctionType->name,
                    'auction_type_icon' => $auctionTypeIcon,
                    'deposit_amount' =>  intval(str_replace(',', '', formatPrice($project->deposit_amount, $currency))),
                    'currency'       => $currency,
                    'is_bid' => $isBidRequestedAndApproved,
                ];
            }

            return response()->json($responseData, 200);

        } catch (\Exception $e) {
            return response()->json([
                'ResponseCode' => 500,
                'Status' => 'False',
                'Message' => $e->getMessage(),
            ], 500);
        }
    }

    // projectlistbased category api
    public function projectlistbasedcategory(Request $request)
    {
        try {
            
            $rules = [
                'category_id' => 'required|exists:categories,id',
                'project_name' => 'nullable',
                'auction_type_name' => 'nullable',
            ];

            $validator = Validator::make($request->all(), $rules);
 
            if ($validator->fails()) {
                $firstErrorMessage = $validator->errors()->first();
                return response()->json([
                    'ResponseCode' => 422,
                    'Status' => 'False',
                    'Message' => $firstErrorMessage,
                ], 422);
            }
            $user = Auth::user(); 

            if (!$user) {
                return response()->json([
                    'ResponseCode' => 401,
                    'Status' => 'Error',
                    'Message' => 'User not authenticated',
                ], 401);
            }
               
            $currentDateTime = now();
            $langId = $user->lang_id; 
            $currency = $user->currency_code; 
            $cat = Category::find($request->category_id);
            if (!$cat) {
                return response()->json([
                    'ResponseCode' => 404,
                    'Status' => 'False',
                    'Message' => 'Category not found',
                ], 404);
            }
            $projectsQuery = Project::with('products')->where('category_id', $cat->id)->orderBy('start_date_time', 'ASC')->where('end_date_time', '>=', $currentDateTime);
             
            // p($projectsQuery);
            $projectsQuery->whereHas('products', function ($query) {
                });

            // Add project name search if provided in the request
            if ($request->has('project_name') && !empty($request->project_name)) {
                $projectsQuery->where('name', 'like', '%' . $request->project_name . '%');
            }
           
            if ($request->has('auction_type_name') && !empty($request->auction_type_name)) {
                $auctionTypeNames = explode(',', $request->auction_type_name);

                $auctionTypeIds = AuctionType::whereIn('name', $auctionTypeNames)->pluck('id')->toArray();

                if (!empty($auctionTypeIds)) {
                    $projectsQuery->whereIn('auction_type_id', $auctionTypeIds);
                }
            }

            $projects = $projectsQuery->get();
            $responseData = [
                'ResponseCode' => 200,
                'Status' => 'True',
                'Message' => 'Data Retrieved Successfully',
                'data' => [],
            ];

            foreach ($projects as $project) {
                $auctionType = AuctionType::find($project->auction_type_id);

                // $auctionTypeName = $auctionType ? $auctionType->name : null;
                $auctionTypeName =  ($langId == 'ar') ?  $auctionType->name_ar :  $auctionType->name ;
                $auctionTypeIcon = '';
                  // Check if bid request exists and is approved for the project
                  $isBidRequestedAndApproved = BidRequest::where('project_id', $project->id)
                                            // ->where('status', 1)
                                            // ->exists();
                                            ->where('user_id', $user->id)
                                            ->pluck('status')
                                            ->first();
                                         
                if ($auctionTypeName === 'Private') {
                    $auctionTypeIcon = asset('auctionicon/private_icon.png');
                } elseif ($auctionTypeName === 'Timed') {
                    $auctionTypeIcon = asset('auctionicon/time.png');
                } elseif ($auctionTypeName === 'Live') {
                    $auctionTypeIcon = asset('auctionicon/live.png');
                }
                $responseData['data'][] = [
                    'id' => $project->id,
                    'title' => ($langId == 'ar') ? $project->name_ar : $project->name,
                    'image_path' => asset("img/projects/" . $project->image_path),
                    'start_date_time' => Carbon::parse($project->start_date_time)->format('F j, h:i A'),
                    'end_date_time'  => $project->end_date_time,
                    'start_date_time_actual' => $project->start_date_time,
                    'auction_type_name' => $auctionTypeName,
                    'auction_type_icon' => $auctionTypeIcon,
                    // 'deposit_amount'    => $project->deposit_amount,
                    'deposit_amount' =>  intval(str_replace(',', '', formatPrice($project->deposit_amount, $currency))),
                    'currency'     =>$currency,
                    'is_bid' => $isBidRequestedAndApproved,
                ];
            }

            return response()->json($responseData, 200);

        } catch (\Exception $e) {
            return response()->json([
                'ResponseCode' => 500,
                'Status' => 'False',
                'Message' => $e->getMessage(),
            ], 500);
        }
    }

   //  product detail api
   public function getProductDetail(Request $request)
   {
       try {
           $rules = [
               'product_id' => 'required|exists:products,id',
           ];

           $validator = Validator::make($request->all(), $rules);
           if ($validator->fails()) {
               $firstErrorMessage = $validator->errors()->first();
               return response()->json([
                   'ResponseCode' => 422,
                   'Status' => 'False',
                   'Message' => $firstErrorMessage,
               ], 422);
           }
           $productId = $request->input('product_id');
           $user = Auth::user(); 

           if (!$user) {
               return response()->json([
                   'ResponseCode' => 401,
                   'Status' => 'Error',
                   'Message' => 'User not authenticated',
               ], 401);
           }

           $langId = $user->lang_id; 
           $currency = $user->currency_code; 
           $product = Product::with(['auctionType', 'galleries'])
               ->where('id', $productId)
               ->first();

           if (!$product) {
               return response()->json([
                   'ResponseCode' => 422,
                   'Status' => 'false',
                   'Message' => 'Product not found',
               ], 422);
           }
           $auctionType = AuctionType::find($product->auction_type_id);
           $now = Carbon::now();
           $auctionEndDate = null;
           if ($auctionType && ($auctionType->name === 'Private' || $auctionType->name === 'Timed')) {
               if (strtotime($product->auction_end_date) > strtotime('now')) {
                       $timestamp = strtotime($product->auction_end_date);
                       $milliseconds = $timestamp * 1000;
                       $auctionEndDate = $milliseconds;
               }else {
                   $auctionEndDate = 0;
               }
           } else {
               $auctionEndDate = 0;
           }
         
           $auctionTypeName =  ($langId == 'ar') ?  $auctionType->name_ar :  $auctionType->name ;
           $auctionTypeIcon = '';

           if ($auctionTypeName === 'Private') {
               $auctionTypeIcon = asset('auctionicon/private_icon.png');
           } elseif ($auctionTypeName === 'Timed') {
               $auctionTypeIcon = asset('auctionicon/time.png');
           } elseif ($auctionTypeName === 'Live') {
               $auctionTypeIcon = asset('auctionicon/live.png');
           }

           $loggedInUser = Auth::user();
           $project = Project::find($product->project_id);
           $isBidRequestedAndApproved = BidRequest::where('project_id', $project->id)
                                    // ->where('status', 1)
                                    // ->exists();
                                    ->where('user_id', $user->id)
                                    ->pluck('status')
                                    ->first();
            $isplaced = BidPlaced::where('product_id', $product->id)
                                        ->where('status', 1)
                                        ->exists();
           if ($project) {
               $projectName =($langId == 'ar') ? $project->name_ar : $project->name;
               $projectStartDate = $project->start_date_time ?? null;
               $projectEndDate  =  $project->end_date_time ?? null;
            //    $projectBuyerspremium = $project->buyers_premium ?? null;
               $projectBuyerspremium = formatPrice($project->buyers_premium,$currency);                
               $productDetail['project_name'] = $projectName;
               $productDetail['project_start_date_time'] = $projectStartDate;
               $productDetail['project_end_date_time'] = $projectEndDate;
               $productDetail['project_buyers_premium'] = $projectBuyerspremium;
           } else {
               $productDetail['project_name'] = null;
               $productDetail['project_start_date_time'] = null;
               $productDetail['project_end_date_time'] = null;
               $productDetail['project_buyers_premium'] = null;
           }
           // $product_id = $productId->id; 
        //    $currentBid = BidPlaced::where('product_id', $product->id)->where('status', 1)->first();
           $currentBid = BidPlaced::where('product_id', $product->id)
                            ->where('sold', 1)
                            ->orderBy('bid_amount', 'desc')
                            ->first();
       
             $currentBidAmount = $currentBid ? formatPrice($currentBid->bid_amount, $currency) : formatPrice($product->reserved_price, $currency);
             $minmumbidAmount = formatPrice($product->reserved_price, $currency);

             $sold = BidPlaced::where('product_id', $product->id)
                    ->where('sold', 2)
                    ->where('status', '!=', 0)
                    ->orderBy('bid_amount', 'desc')
                    ->first();
            $soldBidAmount =$sold ? formatPrice($sold->bid_amount, $currency) : '';
           //  return($product->id);
        //    $currentbidAmount = $currentBid ? $currentBid->bid_amount : '';
           $user = auth()->user();
           $userAddresses = Useraddress::where('user_id', $user->id)->get();
           $addresses = [];

           foreach ($userAddresses as $userAddress) {
               $fullAddress = $userAddress->first_name . ' ' . $userAddress->last_name . '- ' . $userAddress->apartment . ', ';
               $country = Country::find($userAddress->country);
               $state = State::find($userAddress->state);
               $city = City::find($userAddress->city);
               if ($country && $state && $city) {
                   $fullAddress .= $city->name . ', ' . $state->name . ', ' . $country->name . ', ' . $userAddress->zipcode;

                   $userAddress->full_address = $fullAddress;

                   $addresses[] = $userAddress;
               }
           }
     
           $productDetail = [
               'id' => $product->id,
               'lot_no' => $product->lot_no,
               'title' => ($langId == 'ar') ? $product->title_ar : $product->title,
               'start_price' =>  formatPrice($product->start_price,$currency),
               'end_price' => formatPrice($product->end_price,$currency),
               'description' => strip_tags(($langId == 'ar') ? $product->description_ar : $product->description),
               'image_paths' => $product->galleries->pluck('image_path')->toArray(),
               'current_bid' => $currentBidAmount,
               'time_remaining' => $auctionEndDate,
               'time_remaining_actual'=>$product->auction_end_date,
               'reserved_price' => formatPrice($product->reserved_price, $currency),
               'minimum_bid_amount' => $minmumbidAmount,
               'minimumsellingprice' => $product->minsellingprice,
               'auction_type_id'    =>$product->auction_type_id,
               'auction_type' =>   ($langId == 'ar') ? $product->auctionType->name_ar : $product->auctionType->name,
               'auction_type_icon' => $auctionTypeIcon,
               'project_id'   => $product->project_id,
               'project_name' => $projectName,
               'project_state_date' => $projectStartDate,
               'project_end_date' => $projectEndDate,
               'project_buyers_premium' => $projectBuyerspremium,
               'is_bid' => $isBidRequestedAndApproved,
               'is_wishlist' => $loggedInUser ? $loggedInUser->wishlists->contains('product_id', $product->id) : false,
               'userAddress' => $addresses,
               'is_bid_placed' => $isplaced,
               'sold'  => $soldBidAmount,

              
           ];

           return response()->json([
               'ResponseCode' => 200,
               'Status' => 'true',
               'Message' => 'Product details retrieved successfully',
               'data' => $productDetail,
           ], 200);
       } catch (\Exception $e) {
           return response()->json([
               'ResponseCode' => 500,
               'Status' => 'false',
               'Message' => $e->getMessage(),
           ], 500);
       }
   }

    // add to wishliist api.
    public function addOrRemoveFromWishlist(Request $request)
    {
        $productId = $request->input('product_id');
        $user = Auth::user();
        $product = Product::find($productId);

        if (!$product) {
            return response()->json([
                'ResponseCode' => 422,
                'Status' => 'false',
                'Message' => 'Product not found',
            ], 422);
        }

        $wishlistItem = $user->wishlists()->where('product_id', $productId)->first();

        if ($wishlistItem) {
            // If the product is already in the wishlist, remove it
            $wishlistItem->delete();
            $message = 'Product removed from wishlist';
        } else {
            // If the product is not in the wishlist, add it
            $wishlist = new Wishlist();
            $wishlist->user_id = $user->id;
            $wishlist->product_id = $productId;
            $wishlist->save();
            $message = 'Product added to wishlist';
        }

        return response()->json([
            'ResponseCode' => 200,
            'Status' => 'true',
            'Message' => $message,
        ], 200);
    }

// my wishlist api
    public function myWishlist(Request $request)
    {
        
        $user = auth()->user();
        $langId = $user->lang_id; 
        $currency = $user->currency_code; 
        if (!$user) {
            return response()->json([
                'ResponseCode' => 400,
                'Status' => 'false',
                'Message' => 'Unauthorized',
            ], 400);
        }

        $wishlistQuery = $user->wishlists()->with(['product' => function ($query) use ($langId) {
            $query;
        }]);
    
        // Search by product title if a search query is provided
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $wishlistQuery->whereHas('product', function ($query) use ($searchTerm) {
                $query->where('title', 'like', "%$searchTerm%");
            });
        }
         // Filter by auction type name if provided
        if ($request->has('auction_type_name') && !empty($request->auction_type_name)) {
            $auctionTypeNames = explode(',', $request->auction_type_name);
            $auctionTypeIds = AuctionType::whereIn('name', $auctionTypeNames)->pluck('id')->toArray();

            if (!empty($auctionTypeIds)) {
                $wishlistQuery->whereHas('product', function ($query) use ($auctionTypeIds) {
                    $query->whereIn('auction_type_id', $auctionTypeIds);
                });
            }
        }

    
        $wishlist = $wishlistQuery->get();
        $formattedProducts = [];

        foreach ($wishlist as $item) {
            $product = $item->product;
            $auctionEndDate = null;
            $auctionType = AuctionType::find($product->auction_type_id);
            $now = Carbon::now();
            if ($auctionType && ($auctionType->name === 'Private' || $auctionType->name === 'Timed')) {
                $timestamp = strtotime($product->auction_end_date);
                $milliseconds = $timestamp * 1000;
                $auctionEndDate = $milliseconds;
            }elseif ($auctionType && ($auctionType->name === 'Live')) {
                $auctionEndDate = 0;
            }
            
            $loggedInUser = Auth::user();
            $auctionType = AuctionType::find($product->auction_type_id);
            $auctionTypeName =  ($langId == 'ar') ? $auctionType->name_ar : $auctionType->name;
           
            $auctionTypeIcon = '';

            if ($auctionType && ($auctionType->name === 'Private')) {
                $auctionTypeIcon = asset('auctionicon/private_icon.png');
            } elseif ($auctionType && ($auctionType->name === 'Timed')) {
                $auctionTypeIcon = asset('auctionicon/time.png');
            } elseif ($auctionType && ($auctionType->name === 'Live')) {
                $auctionTypeIcon = asset('auctionicon/live.png');
            }
            $project = Project::find($product->project_id);
            if ($project) {
                $projectId = $project->id ?? null;
                $projectName =($langId == 'ar') ? $project->name_ar : $project->name;
                $projectStartDate = $project->start_date_time ?? null;
                $projectEndDate  =  $project->end_date_time ?? null;
                $projectdepositamount = $project->deposit_amount ?? null;
             //    $projectBuyerspremium = $project->buyers_premium ?? null;
                $projectBuyerspremium = formatPrice($project->buyers_premium,$currency);  
                $productDetail['project_id']      = $projectId    ;   
                $productDetail['project_name'] = $projectName;
                $productDetail['project_start_date_time'] = $projectStartDate;
                $productDetail['project_end_date_time'] = $projectEndDate;
                $productDetail['project_buyers_premium'] = $projectBuyerspremium;
                $productDetail['project_deposit_amount'] = $projectdepositamount;
            } else {
                $productDetail['project_id']      = null   ;  
                $productDetail['project_name'] = null;
                $productDetail['project_start_date_time'] = null;
                $productDetail['project_end_date_time'] = null;
                $productDetail['project_buyers_premium'] = null;
                $productDetail['project_deposit_amount'] = null;
            }
            $isBidRequestedAndApproved = BidRequest::where('project_id', $project->id)
                                            // ->where('status', 1)
                                            // ->exists();
                                            ->where('user_id', $user->id)
                                            ->pluck('status')
                                            ->first();
        //  $isplaced = BidPlaced::where('product_id', $product->id)
        //                              ->where('status', 1)
        //                              ->exists();
            // Add product details to the corresponding auction type key
            $formattedProducts[] = [
                'id' => $product->id,
                'lot_no' => $product->lot_no,
                'title' => ($langId == 'ar') ? $product->title_ar : $product->title,
                'image_path' => $product->galleries->first()->image_path ?? '',
                'reserved_price' => formatPrice($product->reserved_price, $currency),
                'currency'      => $currency,
                'time_remaining' => $auctionEndDate,
                'time_remaining_actual' =>  $product->auction_end_date,
                'project_start_date_time,' =>$projectStartDate,
                'project_end_date_time' => $projectEndDate,
                'minimumsellingprice' => $product->minsellingprice,
                'project_name'       => $projectName,
                'project_id'      => $projectId,
                'project_deposit_amount' =>$projectdepositamount,
                'current_bid' => '',
                'is_wishlist' => $loggedInUser ? $loggedInUser->wishlists->contains('product_id', $product->id) : false,
                'auction_type' => $auctionTypeName,
                'auction_type_icon' => $auctionTypeIcon,
                'is_bid' => $isBidRequestedAndApproved,
            ];
        }

        return response()->json([
            'ResponseCode' => 200,
            'Status' => 'true',
            'Message' => 'My wishlist',
            'data' => $formattedProducts,
        ], 200);
    }

    // help & support api.

    public function helpsupport(Request $request)
    {
        try {
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required',
                'mobile' => 'required|string|max:20',
                'description' => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $firstErrorMessage = $validator->errors()->first();
                return response()->json([
                    'ResponseCode' => 422,
                    'Status' => 'False',
                    'Message' => $firstErrorMessage,
                ], 422);
            }

            // Get the authenticated user's ID
            $userId = auth()->user()->id;

            $help = new Helpsupport([
                'user_id' => $userId, // Store the user's ID
                'name' => $request->input('name'),
                'mobile' => $request->input('mobile'),
                'email' => $request->input('email'),
                'description' => $request->input('description'),
            ]);

            $help->save();

            return response()->json([
                'ResponseCode' => 200,
                'Status' => 'true',
                'Message' => 'Enquiry Submitted Successfully',
                'data' => $help,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'ResponseCode' => 500,
                'Status' => 'False',
                'Message' => $e->getMessage(),
            ], 500);
        }
    }


    // bid request 
    public function bidrequest(Request $request)
    {
        try {
            $rules = [
                'project_id' => 'required',
                'auction_type_id' =>'required',
                'deposit_amount' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $firstErrorMessage = $validator->errors()->first();
                return response()->json([
                    'ResponseCode' => 422,
                    'Status' => 'False',
                    'Message' => $firstErrorMessage,
                ], 422);
            }

            // Get the authenticated user's ID
            $userId = auth()->user()->id;
            $existingBid = BidRequest::where('user_id', $request->user_id)
            ->where('project_id', $request->project_id)
            ->exists();

            if ($existingBid) {
                return response()->json(['error' => 'You have already placed a bid for this project']);
            }
              $bids=  BidRequest::create([
                    'user_id' =>  $userId,
                    'project_id' => $request->project_id,
                    'auction_type_id' => $request->auction_type_id,
                    'deposit_amount' => $request->deposit_amount,
                ]);

         $bids->save();

            return response()->json([
                'ResponseCode' => 200,
                'Status' => 'true',
                'Message' => 'Bid Request Submitted successfully',
                'data' =>  $bids,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'ResponseCode' => 500,
                'Status' => 'False',
                'Message' => $e->getMessage(),
            ], 500);
        }
    }

    // bid value 

    public function bidvalue(){
        try {
            $user = auth()->user();
             $langId = $user->lang_id;
            $currency = $user->currency_code; 
            $bidvalue = Bidvalue::select('id', 'cal_amount')
                ->where('status', 1)
                ->orderBy('cal_amount', 'asc')
                ->get();
            foreach ($bidvalue as $key => $value) {
                $bidvalue[$key]->cal_amount =  intval(str_replace(',', '', formatPrice(round($value->cal_amount), $currency)));
                $bidvalue[$key]->currency = $currency; 
            }
            return response()->json([
                'ResponseCode' => 200,
                'Status' => 'true',
                'Message' => 'Bid Value Retrieved Successfully',
                'data' =>  $bidvalue,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'ResponseCode' => 500,
                'Status' => 'False',
                'Message' => $e->getMessage(),
            ], 500);
        }
    }


      // bid create
      public function bidcreate(Request $request)
      {
          try {
              $rules = [
                  'project_id' => 'required',
                  'auction_type_id' => '',
                  'bid_amount' => 'required',
                  'product_id' => 'required',
              ];
      
              $validator = Validator::make($request->all(), $rules);
      
              if ($validator->fails()) {
                  $firstErrorMessage = $validator->errors()->first();
                  return response()->json([
                      'ResponseCode' => 422,
                      'Status' => 'False',
                      'Message' => $firstErrorMessage,
                  ], 422);
              }
      
              $userId = auth()->user()->id;
              $currency = auth()->user()->currency_code; 

              $productId = $request->input('product_id');
              $bidAmount = $request->input('bid_amount');

              // Convert bid amount to SAR if currency is USD
                if ($currency === 'USD') {
                    $bidAmount *= 3.75; 
                }
            
              $existingBid = BidPlaced::where('user_id', $userId)
                        ->where('product_id', $request->product_id)
                        ->first();

                  $highestBid = BidPlaced::where('product_id', $productId)
                                        ->where('status', 1)
                                        ->max('bid_amount');
          
                //   if ($highestBid !== null && $bidAmount <= $highestBid) {
                //       return response()->json([
                //           'ResponseCode' => 422,
                //           'Status' => 'False',
                //           'Message' => 'Bid amount should be higher than the current highest bid.',
                //       ], 422);
                //   }
      
            
                  $bids = BidPlaced::create([
                      'user_id' => $userId,
                      'product_id' => $request->product_id,
                      'auction_type_id' => $request->auction_type_id,
                      'project_id' => $request->project_id,
                      'bid_amount' => $bidAmount,
                      
                     
                  ]);
      
                  return response()->json([
                      'ResponseCode' => 200,
                      'Status' => 'true',
                      'Message' => 'First bid placed successfully',
                      'data' => $bids,
                  ], 200);
           
          } catch (\Exception $e) {
              return response()->json([
                  'ResponseCode' => 500,
                  'Status' => 'False',
                  'Message' => $e->getMessage(),
              ], 500);
          }
      }


       // bid placed update

    public function bidupdate(Request $request)
    {
        try {
            $rules = [
                'bid_id' => 'required',
                'bid_amount' => 'required',
                'buyers_premium' => 'required',
                'total_amount' => 'required',
                'outbid' => '',
                'first_name' => 'required',
                'last_name' => 'required',
                'country' => 'required',
                'state' => 'required',
                'city' => 'required',
                'apartment' => 'nullable',
                'zipcode' => 'required',
                'phone' => 'required',
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                $firstErrorMessage = $validator->errors()->first();
                return response()->json([
                    'ResponseCode' => 422,
                    'Status' => 'False',
                    'Message' => $firstErrorMessage,
                ], 422);
            }
            $currency = auth()->user()->currency_code; 
            $productId = $request->input('product_id');
            $bidAmount = $request->input('bid_amount');
            // Convert bid amount to SAR if currency is USD
            if ($currency === 'USD') {
                $bidAmount *= 3.75; 
            }
    
            // Retrieve the highest bid amount for the given product
            $highestBid = BidPlaced::where('product_id', $productId)
                ->where('status', 1)
                ->max('bid_amount');
    
            if ($highestBid !== null && $bidAmount <= $highestBid) {
                return response()->json([
                    'ResponseCode' => 422,
                    'Status' => 'False',
                    'Message' => 'Bid amount should be higher than the current highest bid.',
                ], 422);
            }
            // $existingBid = BidPlaced::where('product_id', $request->product_id)->where('status',1)->get();
            $bidId = $request->input('bid_id');
            $bidAmounts = $bidAmount;
            $buyersPremium = $request->input('buyers_premium');
            $totalAmount = $request->input('total_amount');
            $outbid = $request->input('outbid');
            $userId = auth()->user()->id;
            $tempAddressData = [
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'country' => $request->input('country'),
                'state' => $request->input('state'),
                'city' => $request->input('city'),
                'zipcode' => $request->input('zipcode'),
                'apartment' => $request->input('apartment'),
                'phone'   => $request->input('phone'),
                'user_id'  =>$userId,
               
            ];
    
            $bid = BidPlaced::find($bidId);
    
            if ($bid) {
                $bid->bid_amount = $bidAmount;
                $bid->buyers_premium = $buyersPremium;
                $bid->total_amount = $totalAmount;
                $bid->outbid = $outbid;
                $bid->status = 1;
    
                // Update TempAddress for the bid
                $tempAddress = $bid->tempAddress()->updateOrCreate([], $tempAddressData);
    
                $bid->save();
                // changes 5 april
                $user=auth()->user();
                $first_name = $user->first_name;
                $products_name= Product::where('id',$bid->product_id)->first();
                $product_name =$products_name->title;
                $pro_image =Product::where('id',$bid->product_id)->first();
                $lot_no =$pro_image->lot_no;
                $product_image =Gallery::where('lot_no', $lot_no)->orderBy('id')->value('image_path');
                $bid_amount = BidPlaced::where('product_id', $bid->product_id)->where('user_id', $user->id)->latest()->value('bid_amount');
                $auction_end_times =Project::where('id',$bid->project_id)->first();
                $auction_end_time=$auction_end_times->end_date_time;
                Mail::to($user->email)->send(new BidPlacedMail($first_name,$product_name,$product_image,$bid_amount,$auction_end_time));
                $outbidUsers = BidPlaced::where('product_id', $bid->product_id)
                            ->where('outbid', 1)
                            // ->where('user_id', '!=', auth()->id())
                            ->get();
                foreach ($outbidUsers as $outbidUser) {
                    if ($outbidUser->bid_amount < $bidAmount) {
                if ($outbidUser->user_id !== $user->id) {    
                    $first_name = $user->first_name;
                    $products_name= Product::where('id',$bid->product_id)->first();
                    $product_name =$products_name->title;
                    $product_slug =$products_name->slug;
                    $product_image =Gallery::where('lot_no',  $products_name->lot_no)->orderBy('id')->value('image_path');
                    $bid_amount = BidPlaced::where('product_id', $bid->product_id)->latest()->value('bid_amount');
                    $auction_end_times =Project::where('id',$bid->project_id)->first();
                    $auction_end_time=$auction_end_times->end_date_time;
                    Mail::to($user->email)->send(new OutbidNotification($first_name,$product_name,$product_image,$bid_amount,$auction_end_time,$product_slug));
                }
                    // Send push notification to the outbid user if device token is available
                    $firebaseToken = $outbidUser->user->device_token;
                    if ($firebaseToken) {
                        // Replace 'Controller::apiNotificationForApp' with your actual function to send push notifications
                        Controller::apiNotificationForApp($firebaseToken, "You've Been Outbid", 'default_sound.mp3', "Increase your bid before time runs out.", null);
                    }
                    // Save a notification
                    if ($outbidUser->user_id !== $user->id) {
                        $notification = new Notification();
                        $notification->type = "You've Been Outbid";
                        $notification->title = "You've Been Outbid";
                        $notification->sender_id = $user->id;
                        $notification->receiver_id = $outbidUser->user_id;
                        $notification->message = "Increase your bid before time runs out.";
                        $notification->product_id = $bid->product_id;
                        $notification->project_id = $bid->project_id;
                        $notification->save();
                    }
                }
                }
    
                return response()->json([
                    'ResponseCode' => 200,
                    'Status' => 'true',
                    'Message' => 'Bid Updated Successfully',
                    'data' => [
                        'bid' => $bid,
                        'temp_address' => $tempAddress,
                    ],
                ], 200);
            } else {
                return response()->json([
                    'ResponseCode' => 404,
                    'Status' => 'False',
                    'Message' => 'Bid not found',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'ResponseCode' => 500,
                'Status' => 'False',
                'Message' => $e->getMessage(),
            ], 500);
        }
    }


    public function mybid(Request $request){
        try {
           
            $user_id = auth()->user();
            $langId =  $user_id->lang_id; 
            $currency =  $user_id->currency_code; 
    
            // Current Bids
          
            $currentBids = BidPlaced::with(['product.project.auctionType', 'user'])
                            ->where('sold', 1)
                            ->whereIn('product_id', function($query) use ($user_id) {
                                $query->select('product_id')
                                    ->from('bid_placed');
                                    // ->where('user_id', $user_id);
                            })
                            ->orderBy('created_at', 'desc')
                            ->get();
                           
            $currentGroupedBids = $currentBids->groupBy('product_id');
            $currentBidsCountByUserAndProduct = $currentGroupedBids->count();
            
            $currentBidHistory = [];
    
            foreach ($currentGroupedBids as $productId => $productBids) {
                $product = Product::find($productId);
                $imagePath = Gallery::where('product_id', $productId)->value('image_path');
        
                $productBidHistory = [];
        
                foreach ($productBids as $bid) {
                    $username = $bid->user->first_name;
                    $bidDateTime = $bid->created_at;
                    // $auctionTypeName = $bid->product->auctionType->name;
                    $auctionType = AuctionType::find($bid->product->auction_type_id);
                    $auctionTypeName =  ($langId == 'ar') ? $auctionType->name_ar : $auctionType->name;
                    $bidAmount = $bid->bid_amount;
                    $totalAmount = $bid->total_amount;
                    $status = $bid->status;
        
                    $productBidHistory[] = [
                        'Bidder' => $username,
                        'Bid Date/Time' => $bidDateTime,
                        'Auction Type' => $auctionTypeName,
                        'Amount' => $bidAmount,
                        'total_amount' => $totalAmount,
                        'Status' => $status,
                        'currency'      => $currency,
                        'bid_placed_id' => $bid->id,
                        'user_id'     =>$bid->user_id,
                    ];
                }
        
                $bidPlacedStatus = $productBids->contains('user_id', $user_id) ? 1 : 2;
        
                $currentBidHistory[] = [
                    'product_id' => $product->id,
                    'product_image' => $imagePath,
                    'lot_no' => $product->lot_no,
                    'title' => ($langId == 'ar') ? $product->title_ar : $product->title,
                    'start_date_time' => $product->project->start_date_time,
                    'start_price' => $product->start_price,
                    'end_price' => $product->end_price,
                    'auction_type_name' => $auctionTypeName,
                    'bid_placed_status' => $bidPlacedStatus,
                    'bid_history' => $productBidHistory,
                ];
            }
    
            // Past Bids
          
            $pastBids = BidPlaced::with(['product.project.auctionType'])
                        ->where('sold',2)
                        ->whereIn('product_id', function($query) use ($user_id) {
                            $query->select('product_id')
                                ->from('bid_placed');
                                // ->where('user_id', $user_id);
                        })
                        ->orderBy('created_at', 'desc')
                        ->get();
                       
           
            $pastGroupedBids = $pastBids->groupBy('product_id');
            $pastBidsCountByUserAndProduct = $pastGroupedBids->count();
            
            $pastBidHistory = [];
        
            foreach ($pastGroupedBids as $productId => $productBids) {
                $product = Product::find($productId);
                $imagePath = Gallery::where('product_id', $productId)->value('image_path');
                $sold = $pastBids = BidPlaced::where('product_id', $productId)
                            ->where('status', 2)->where('sold',2)->get('bid_amount');
        
                $productBidHistory = [];
        
                foreach ($productBids as $bid) {
                    $username = $bid->user->first_name;
                    $bidDateTime = $bid->created_at;
                    $auctionTypeName = $bid->product->auctionType->name;
                    $bidAmount = $bid->bid_amount;
                    $totalAmount = $bid->total_amount;
                    $status = $bid->status;
        
                    $productBidHistory[] = [
                        'Bidder' => $username,
                        'Bid Date/Time' => $bidDateTime,
                        'Auction Type' => $auctionTypeName,
                        'Amount' => $bidAmount,
                        'total_amount' => $totalAmount,
                        'Status' => $status,
                        'currency'      => $currency,
                        'bid_placed_id' => $bid->id, 
                        'user_id'     =>$bid->user_id,
                    ];
                }
        
                $bidPlacedStatus = $productBids->contains('user_id', $user_id) ? 1 : 2;
        
                $pastBidHistory[] = [
                    'product_id' => $product->id,
                    'product_image' => $imagePath,
                    'lot_no' => $product->lot_no,
                    'title' => $product->title,
                    'start_date_time' => $product->project->start_date_time,
                    'start_price' => $product->start_price,
                    'end_price' => $product->end_price,
                    'auction_type_name' => $auctionTypeName,
                    'bid_placed_status' => $bidPlacedStatus,
                    'sold_price'      => $sold,
                    'bid_history' => $productBidHistory,
                ];
            }
    
            return response()->json([
                'ResponseCode' => 200,
                'Status' => 'true',
                'Message' => 'Bid History Retrieved Successfully',
                'data' => [
                    'current_bid' => $currentBidHistory,
                    'past_bid'  => $pastBidHistory,
                    'current_bid_count' => $currentBidsCountByUserAndProduct,
                    'past_bid_count' => $pastBidsCountByUserAndProduct,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'ResponseCode' => 500,
                'Status' => 'False',
                'Message' => $e->getMessage(),
            ], 500);
        }
    }

    public function downloadInvoice(Request $request) {
        try {
            $bidplacedId = $request->bid_placed_id;
            $pdfContent = $this->generatePDF($bidplacedId); 
            
            return response($pdfContent)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="invoice.pdf"');
        } catch (\Throwable $th) {
           
            Log::error($th->getMessage());
            return response()->json([
                'ResponseCode' => 500,
                'Status' => 'False',
                'Message' => $th->getMessage(),
            ], 500);
        }
    }
    
    public function generatePDF($bidplacedId) {
        // Retrieve the authenticated user
        $user = auth('api')->user();
        
        // Check if the user is authenticated
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
       
        $bidspast = BidPlaced::with(['product.project.auctionType'])
            ->where('sold', 2)
            ->where('status', 2)
            ->where('id',$bidplacedId)
            ->whereIn('product_id', function ($query) use ($user) {
                $query->select('product_id')
                    ->from('bid_placed')
                    ->where('user_id', $user->id); 
            })
            ->orderBy('created_at', 'desc')
            ->first();
    
        if ($bidspast->isNotEmpty()) {
            $invoiceNumber = 'Inv-' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
            $currentDate = now()->format('Y-m-d');
            $invoiceData = [
                'invoiceNumber' => $invoiceNumber,
                'date' => $currentDate,
            ];
            $options = new Options();
            $options->set('isRemoteEnabled', true);
            $dompdf = new Dompdf($options);
            // $dompdf = new Dompdf();
            $html = view('frontend.invoice', compact('invoiceData', 'bidspast'))->render();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            
            return $dompdf->output();
        } else {
            return response()->json(['error' => 'Booking not found'], 404);
        }
    }

    
    
    public function generate(Request $request) {
        try {
          
            $user = auth('api')->user();
            
         
            $validator = Validator::make($request->all(), [
                'bid_placed_id' => 'required',
            ]);
            
            if ($validator->fails()) {
                return $this->sendError('Validation error.', $validator->errors());
            }
            
            // Retrieve bid placed data
            $bidspast = BidPlaced::with(['product.project.auctionType'])
                ->where('sold', 2)
                ->where('status', 2)
                ->where('id', $request->bid_placed_id)
                ->whereIn('product_id', function($query) use ($user) {
                    $query->select('product_id')
                        ->from('bid_placed')
                        ->where('user_id', $user->id);
                })
                // ->orderBy('created_at', 'desc')
                ->get();
            
            // Generate invoice data
            $invoiceNumber = 'INV-' . uniqid();
            $currentDate = now()->format('Y-m-d');
            $invoiceData = [
                'invoiceNumber' => $invoiceNumber,
                'date' => $currentDate,
            ];
    
            // Generate PDF
            $options = new Options();
            $options->set('isRemoteEnabled', true);
            $dompdf = new Dompdf($options);
            // $dompdf = new Dompdf();
            $html = view('frontend.invoice', compact('invoiceData', 'bidspast'))->render();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $pdfContent = $dompdf->output();

            $pdfFilePath = ("frontend/images/invoice_$invoiceNumber.pdf");
            file_put_contents($pdfFilePath, $pdfContent);

            $downloadUrl = URL::temporarySignedRoute(
                'download.invoice',
                now()->addMinutes(60),
                ['bid_placed_id' => $request->bid_placed_id]
            ) . '.pdf';
         
            $response = [
                'download_url' => $downloadUrl,
            ];
            return response()->json([
                'ResponseCode' => 200,
                'Status' => 'true',
                'Message' => 'Invoice Generated',
                'data' => [
                    // 'invoice_url' => $response,
                    'pdf_file_path' => url($pdfFilePath),
                   
                ],
            ], 200);
            
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'ResponseCode' => 500,
                'Status' => 'False',
                'Message' => $th->getMessage(),
            ], 500);
        }
    }
    
    
    
    
    
    
    
    // past auction

    public function pastauction(Request $request){
        try {
                $user = auth()->user();
                $langId = $user->lang_id; 
                $currency = $user->currency_code; 
                if (!$user) {
                    return response()->json([
                        'ResponseCode' => 400,
                        'Status' => 'false',
                        'Message' => 'Unauthorized',
                    ], 400);
                }
                 
                $currentDateTime = now();
                $projectsQuery = Project::where('end_date_time', '<=', $currentDateTime)->orderBy('start_date_time', 'ASC')
                        ->with('products');
            
                if ($request->has('project_name')) {
                    $projectsQuery->where('name', 'like', '%' . $request->project_name . '%');
                }
            
                $projects = $projectsQuery->get();
                $responseData = [
                    'ResponseCode' => 200,
                    'Status' => 'True',
                    'Message' => 'Data Retrieved Successfully',
                    'data' => [],
                ];
                // $responseData = ['data' => []]; 
            
                foreach ($projects as $project) {
                
                    $auctionType = AuctionType::find($project->auction_type_id);
            
                
                    $auctionTypeIcon = '';
                    if ($auctionType) {
                        if ($auctionType->name === 'Private') {
                            $auctionTypeIcon = asset('auctionicon/private_icon.png');
                        } elseif ($auctionType->name === 'Timed') {
                            $auctionTypeIcon = asset('auctionicon/time.png');
                        } elseif ($auctionType->name === 'Live') {
                            $auctionTypeIcon = asset('auctionicon/live.png');
                        }
                    }
                    $isBidRequestedAndApproved = BidRequest::where('project_id', $project->id)
                            ->where('status', 1)
                            ->exists();
                    
                    $responseData['data'][] = [
                        'id' => $project->id,
                        'title' => ($langId == 'ar') ? $project->name_ar : $project->name,
                        'image_path' => asset("img/projects/" . $project->image_path),
                        'start_date_time' => Carbon::parse($project->start_date_time)->format('F j, h:i A'),
                        'end_date_time'  => $project->end_date_time,
                        'start_date_time_actual' => $project->start_date_time,
                        'auction_type_name' => ($langId == 'ar') ? $auctionType->name_ar : $auctionType->name,
                        'auction_type_icon' => $auctionTypeIcon,
                        'deposit_amount' =>  intval(str_replace(',', '', formatPrice($project->deposit_amount, $currency))),
                        'currency'       => $currency,
                        'is_bid' => $isBidRequestedAndApproved,
                    ];
                }
                
                return response()->json($responseData, 200);
            } catch (\Exception $th) {
                return response()->json([
                    'ResponseCode' => 500,
                    'Status' => 'False',
                    'Message' => $th->getMessage(),
                ], 500);
            }
    }
    
    public function notificationlist(Request $request)
    {
        $user = auth()->user();
        try {
            $notificationCount = Notification::where('receiver_id', $user->id)->where('is_read', 0)->count();
            $notificationlist = Notification::with('users', 'projects', 'products')->where('receiver_id', $user->id)->orderBy('id', 'desc')->get();
    
            foreach ($notificationlist as $notification) {
                $project = $notification->projects->first();
                
                if ($project) {
                   
                    $auctionType = AuctionType::find($project->auction_type_id);
                    
                  
                    $project_auction_type_name = $auctionType ? $auctionType->name : null;
                    
                   
                    $isBidRequestedAndApproved = BidRequest::where('project_id', $project->id)
                        ->where('status', 1)
                        ->exists();
                    
                    // Assign additional information to the project object
                    $project->is_bid = $isBidRequestedAndApproved;
                    $project->auction_type_name = $project_auction_type_name;
                }
            }
    
            return response()->json([
                'ResponseCode' => 200,
                'Status' => 'true',
                'Message' => 'Notification list retrieved successfully',
                'data' => [
                    'notification_count' => $notificationCount,
                    'notification_list' => $notificationlist,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'ResponseCode' => 500,
                'Status' => 'False',
                'Message' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function markasread(Request $request)
    {
            $user = auth()->user();
        try {
            $user = auth('api')->user();
        
            $userspay= Notification::where('receiver_id',$user->id)->where('id',$request->notification_id)
                     ->update(['is_read' => 1]);

        return response()->json([
                'ResponseCode' => 200,
                'Status' => 'true',
                'Message' => 'Mark as read Successfully',
                'data' => $userspay,
         ], 200);
        
          
        } catch (\Exception $e) {
            return response()->json([
                'ResponseCode' => 500,
                'Status' => 'False',
                'Message' => $e->getMessage(),
            ], 500);
        }
    }


    public function notificationcount(Request $request)
    {
        $user = auth()->user();
        try {
            $notificationCount = Notification::where('receiver_id', $user->id)->where('is_read', 0)->count();
            
            $responseData = [
                'count' => $notificationCount
            ];
    
            return response()->json([
                'ResponseCode' => 200,
                'Status' => 'true',
                'Message' => 'Notification count retrieved successfully',
                'data' => $responseData,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'ResponseCode' => 500,
                'Status' => 'False',
                'Message' => $e->getMessage(),
            ], 500);
        }
    }
    


}
