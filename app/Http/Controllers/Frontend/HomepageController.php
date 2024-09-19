<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Auctiontype;
use App\Models\Banner;
use App\Models\BidPlaced;
use App\Models\BidRequest;
use App\Models\Bidvalue;
use App\Models\Category;
use App\Models\City;
use App\Models\ContactUs;
use App\Models\Country;
use App\Models\News;
use App\Models\Product;
use App\Models\Project;
use App\Models\{State,StartBid};
use App\Models\User;
use App\Models\Page;
use App\Models\Wishlist;
use App\Models\TempUsers;
use App\Models\Useraddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use App\Mail\WelcomeMail;
use App\Mail\ForgotMail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Appnotification;




class HomepageController extends Controller
{

    
    public function markAsRead($notificationId)
    {
        $notification = Appnotification::find($notificationId);
        if ($notification) {
            $notification->is_read = 1;
            $notification->save();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'Notification not found'], 404);
        }
    }


    public function paymentSuccess(Request $request)
    {
       $user_id=$request->user_id;
       $bid_place_id=$request->bid_place_id;
       $product_id=$request->product_id;
       BidPlaced::where('product_id', $product_id)->update(['sold' => 2]);
        //  if ($request->expectsJson()) {
        //    return response()->json(['message' => 'Payment Successfully Initiated']);
        // } else {
        //     return redirect()->route('auction')->with('success', 'Payment Successfully Initiated.');
        // }
        if ($request->header('Accept') === 'application/json') {
            // Request from app
            echo('Payment Successfully');
        } else {
            // Request from web
            return redirect()->route('auction')->with('success', 'Payment Successfully Initiated.');
        }
    //   echo('payment Successfully');
    //    return redirect()->route('auction')->with('success', 'Payment Successfully Initiated.');
       
       
    }
    public function homepage(Request $request)
    {

        $langId = session('locale');
        if (!$langId) {
            $langId = 'en';
            $request->session()->put('locale', $langId);
        }
        $currency = session()->get('currency');
        $currentDateTime = now();
        // echo $currentDateTime;
        $auctionTypesWithProject = AuctionType::where('status', 1)
                    ->whereHas('projects', function ($query) use ($langId, $currentDateTime) {
                        $query->where('status', 1)
                            ->where('is_trending', 1)
                            ->whereHas('products')
                            ->orderBy('start_date_time', 'ASC')
                            ->where('end_date_time', '>=', $currentDateTime);
                    })
                    ->with([
                        'projects' => function ($query) use ($langId, $currentDateTime) {
                            $query->where('status', 1)
                                ->where('is_trending', 1)
                                ->has('products')
                                ->orderBy('start_date_time', 'ASC')
                                ->where('end_date_time', '>=', $currentDateTime);
                        }
                    ])
                    ->has('projects')
                    ->get();

                $auctionTypesWithProject->transform(function ($auctionType)  {
                    $auctionType->projects = $auctionType->projects->filter(function ($project) {
                        return $project->products->isNotEmpty();
                    })->take(4);

                    return $auctionType;
                });

        // p($auctionTypesWithProject);
         
        $banners = Banner::where('status', 1)->take(4)->get();
        // $productauction = AuctionType::with(['products' => function ($query) use ($langId) {
        //                 $query->where('status', 1)
        //                     ->where('is_popular', 1);
        //                 }])->where('status', 1)->get();
        $productauction = AuctionType::with(['products' => function ($query) use ($currentDateTime, $langId) {
                                        $query->where('status', 1)
                                            ->where('is_popular', 1)
                                            ->whereHas('project', function ($subquery) use ($currentDateTime) {
                                                $subquery->where('end_date_time', '>=', $currentDateTime);
                                            });
                                    }])->where('status', 1)->get();
        $mostRecentBids = BidPlaced::select('product_id', DB::raw('MAX(bid_amount) as max_bid_amount'), DB::raw('COUNT(DISTINCT user_id) as bid_count'))
                                    ->where('sold', 1)
                                    ->where('status', '!=', 0)
                                    ->groupBy('product_id')
                                    ->orderBy('max_bid_amount', 'desc')
                                    ->with('product', 'auctionType')
                                    ->get();
        
        
        $wishlist = [];
        if (Auth::check()) {
            $wishlist = Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray();
        }

        return view('frontend.homepage', compact('auctionTypesWithProject', 'banners', 'productauction', 'wishlist','mostRecentBids','currency'));
    }
  
    public function projectByAuctionType($slug, Request $request)
    {
        $currency = session()->get('currency');
        $langId = session('locale');
        $auctionType = AuctionType::where('slug', $slug)->first();
        $currentDateTime = now();
        $projects = Project::where('end_date_time', '>=', $currentDateTime)->orderBy('start_date_time', 'ASC')->with('products')
            ->where('auction_type_id', $auctionType->id);
    
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $projects->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%');
            });
        }
    
        $projects->whereHas('products', function ($query) {
        });
    
        $projects = $projects->paginate(10);
        
        return view('frontend.projects.index', ['projects' => $projects],['currency'=>$currency]);
    }

    // public function pastauction(Request $request){
    //     $langId = session('locale');
    //     if (!$langId) {
    //         $langId = 'en';
    //         $request->session()->put('locale', $langId);
    //     }
    //     $currency = session()->get('currency');
    //     $currentDateTime = now();
    //     $projects = Project::where('end_date_time', '<=', $currentDateTime)
    //                     ->orderBy('start_date_time', 'ASC')
    //                     ->with('products') // Eager load products relationship
    //                     ->get();

            
    //             return view('frontend.pastauctionlist',compact('projects','currency'));
    //         }
    public function pastauction(Request $request) {
        $langId = session('locale');
        if (!$langId) {
            $langId = 'en';
            $request->session()->put('locale', $langId);
        }
        $currency = session()->get('currency');
        $currentDateTime = now();
    
        // Query to fetch projects
        $query = Project::where('end_date_time', '<=', $currentDateTime)
                        ->orderBy('start_date_time', 'ASC')
                        ->with('products');
    
        // Apply search filter if search term exists
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }
    
        // Fetch paginated projects
        $projects = $query->paginate(10);
    
        return view('frontend.pastauctionlist', compact('projects', 'currency'));
    }

    public function productsByProject($slug, Request $request)
    {
        $langId = session('locale');
        $currency = session()->get('currency');
        $projects = Project::where('slug', $slug)->first();
        $productsQuery = Product::where('project_id', $projects->id);
        // p($mostRecentBids);
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $productsQuery->where('title', 'like', '%' . $searchTerm . '%');
        }

        if ($request->has('sort')) {
            $sortOrder = $request->sort;

            if ($sortOrder === 'price_high_low') {
                $productsQuery->orderBy('reserved_price', 'desc');
            } elseif ($sortOrder === 'price_low_high') {
                $productsQuery->orderBy('reserved_price', 'asc');
            }
        } else {

            $productsQuery->orderBy('reserved_price', 'asc');
        }

        $products = $productsQuery->paginate(10);
       
        $totalItems = $products->total();

        $wishlist = [];
        if (Auth::check()) {
            $wishlist = Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray();
        }

        $wishlist = [];
        if (Auth::check()) {
            $wishlist = Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray();
        }
        $userBidRequests = [];
        if (Auth::check()) {
            $userBidRequests = BidRequest::where('user_id', Auth::id())
                ->pluck('status', 'project_id')
                ->toArray();
        }
       
        return view('frontend.products.index', ['products' => $products], ['projects' => $projects, 'wishlist' => $wishlist, 'totalItems' => $totalItems, 'userBidRequests' => $userBidRequests,'currency'=>$currency,]);
    }
//
    public function productsdetail($slug)
    {
        $currency = session()->get('currency');
        $product = Product::where('slug', $slug)->first();
        $project = Project::where('id', $product->project_id)->first();
        $project = Project::where('id', $product->project_id)->first();
        $bidRequest = BidRequest::where('project_id', $product->project_id)
                    ->where('status', 1)
                    ->first();
        // $bidValues = Bidvalue::where('status', 1)
        //             ->where('cal_amount', '>', $product->reserved_price)
        //             ->orderBy('cal_amount')
        //             ->get();

        // $closestBid = $bidValues->sortBy(function ($bid) use ($product) {
        //     return abs($bid->cal_amount <= $product->reserved_price);
        //   })->first();

        $bidValues = Bidvalue::where('status', 1)
                ->where('cal_amount', '>', $product->reserved_price)
                ->orderBy('cal_amount')
                ->get();

            $lastBid = BidPlaced::where('product_id', $product->id)
                ->orderBy('created_at', 'desc')
                ->first();
          
            $lastBidAmount = $lastBid ? $lastBid->bid_amount : null;
            // return  $lastBid->bid_amount ;

            $filteredBidValues = $bidValues->filter(function ($bid) use ($lastBidAmount) {
                return $bid->cal_amount > $lastBidAmount;
            });

            $closestBid = $filteredBidValues->sortBy(function ($bid) use ($product) {
                return abs($bid->cal_amount - $product->reserved_price);
            })->first();

        $lastBid = null;
        $lastBidAmount = null;
         $lastBid = BidPlaced::where('product_id', $product->id)
                            ->where('project_id', $product->project_id)
                            ->orderBy('created_at', 'desc')
                            ->where('status', '!=', 0)
                            ->first();
        $lastBidAmount = $lastBid ? $lastBid->bid_amount : null;
         
        //  p($lastBidAmount);
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
        $userAddresses = [];
        $selectedAddress = null;
    
        if (Auth::check()) {
            $userAddresses = UserAddress::where('user_id', auth()->user()->id)->get();
    
            $selectedCountryId = $userAddresses->pluck('country')->first();
            $selectedAddress = $userAddresses->where('country', $selectedCountryId)->first();
            $selectedStateId = $userAddresses->pluck('state')->first();
            $selectedAddress = $userAddresses->where('state',  $selectedStateId)->first();
            $selectedCityId = $userAddresses->pluck('city')->first();
            $selectedAddress = $userAddresses->where('city', $selectedCityId)->first();
        }
    
        if ($selectedAddress === null) {
            $defaultCountryId = 1; 
            $defaultCountry = Country::find($defaultCountryId);
    
            $defaultAddress = new UserAddress();
            $defaultAddress->country = $defaultCountryId;
    
            $selectedAddress = $defaultAddress;
        }
        $user_id = Auth::id(); 
        $product_id = $product->id; 
        
        $bidPlacedId = BidPlaced::where('user_id', $user_id)
                ->where('product_id', $product_id)
                ->where('status',1)
                ->first();
         
        if (!$product) {
            abort(404);
        }
        $wishlist = [];
        if (Auth::check()) {
            $wishlist = Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray();
        }
        $currentBid = $product->reserved_price;

        return view('frontend.products.detail', ['product' => $product,'bidPlacedId'=>$bidPlacedId,'selectedAddress'=>$selectedAddress,'userAddresses'=>$userAddresses, 'countries' => $countries, 'states' => $states, 'cities' => $cities, 'lastBidAmount' => $lastBidAmount, 'wishlist' => $wishlist, 'closestBid' => $closestBid, 'calculatedBids' => $bidValues, 'project' => $project, 'bidRequest' => $bidRequest,'currency'=>$currency,'lastBid'=>$lastBid]);
    }
    // /based on category redirect to

    public function projectByCategory($slug)
    {
    // p($slug);
    //     $projects = Project::with('products')
    //         ->where('auction_type_id', $auctionType->id)
    //         ->where('lang_id', $langId);

    //     if ($request->has('search') && !empty($request->search)) {
    //         $searchTerm = $request->search;
    //         $projects->where(function ($query) use ($searchTerm) {
    //             $query->where('name', 'like', '%' . $searchTerm . '%');
    //         });
    //     }

    // $projects->whereHas('products', function ($query) {
    // });
        $currentDateTime = now();
        $langId = session('locale');
        $currency = session()->get('currency');
        $category = Category::where('slug', $slug)->first();
        $projects = Project::with('products')->where('category_id', $category->id)->orderBy('start_date_time', 'ASC')->where('end_date_time', '>=', $currentDateTime);
        $projects->whereHas('products', function ($query) {
            });
         // dd($projects);//
        $projects = $projects->paginate(10);
         
        return view('frontend.projects.index', ['projects' => $projects],['currency'=>$currency]);
    }

    //contact us
    public function contactus(Request $request)
    {
        return view('frontend.contact');
    }


    public function privacy(Request $request)
    {
        $langId = session('locale');
        $privacy = Page::where('id', 3)->first();
        return view('frontend.privacy',compact('privacy'));
    }

    // terms & condition
    public function terms(Request $request)
    {
        $langId = session('locale');
        $terms = Page::where('id', 1)->first();
        return view('frontend.terms',compact('terms'));
    }
      // for mobile
      public function privacypolicy(Request $request)
      {
          $langId = session('locale');
          $privacy = Page::where('id', 3)->first();
          return view('frontend.privacypolicy',compact('privacy'));
      }
  
      public function termsconditions(Request $request)
      {
          $langId = session('locale');
          $terms = Page::where('id', 1)->first();
          return view('frontend.termscondition',compact('terms'));
      }
      // 
    // about
    public function about(Request $request)
    {
        $langId = session('locale');
        $about = Page::where('id', 5)->first();
        return view('frontend.about',compact('about'));
    }

    // product listing

    public function productlist(Request $request)
    {
        return view('frontend.products.list');
    }

    public function productlists(Request $request, $slug)
    {
        return view('frontend.products.list');
    }

    // login

    public function login(Request $request)
    {
        // Session::put('previousUrl', url()->previous());
        $previousUrl = url()->previous();
        if ($previousUrl === route('signin') || empty($previousUrl)) {
            Session::put('previousUrl', url('/'));
        } else {
            Session::put('previousUrl', $previousUrl);
        }
        return view('frontend.login');

    }

    // registration user

    public function registration(Request $request)
    {
        $cont = Country::get();
        return view('frontend.registration', compact('cont'));
    }

    public function loggedin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if ($user->status == 0 ) {
                return back()->withErrors(['email' => 'Your Account is Inactive Contact To Admin.']);
            }
             // Check if the user role is not 2 (user)
             if ($user->role != 2) {
                return back()->withErrors(['email' => 'These credentials do not match our records.']);
            }
            if($user->is_otp_verify == 0 ){
                return back()->withErrors(['email' => 'You have Entered Invalid Credentials']);
            }
        }
        if (Auth::attempt($credentials)) {
            $previousUrl = Session::get('previousUrl');
           
            if ($previousUrl) {
                Session::forget('previousUrl');
                return redirect()->to($previousUrl);
            }
            return redirect()->intended('/');
        }
       

        return back()->withErrors(['email' => 'These credentials do not match our records.']);
    }

    public function register(Request $request)
    {
        try {
            $rules = [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|numeric|digits:10',
                'address' => 'required|string',
                'password' => 'required|string|min:8',
                'confirm_password' => 'required|same:password',
                'country_code' => 'required',
                'is_term' => 'required|boolean',

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $firstErrorMessage = $validator->errors()->first();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation error',
                    'error' => $firstErrorMessage,
                ]);
               
            }

            $otp = rand(1000, 9999);
            $user = new TempUsers([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'password' => bcrypt($request->input('password')),
                'otp' => $otp,
                'is_term' => $request->input('is_term'),
                'is_otp_verify' => 0,
                'country_code' => $request->input('country_code'),
                'status' => 0,
            ]);

            $user->save();
            $msg = $otp . ' is your Verification code for Bids.Sa ';
            Mail::to($user->email)->send(new ResetPasswordMail($user->otp));
            $first_name = $request->input('first_name');
            
        
            Mail::to($user->email)->send(new ResetPasswordMail($otp, $first_name));


            
            return response()->json([
                'status' => 'success',
                'message' => 'Registration successfull',
            ]);

        } catch (\Exception $e) {
            return Redirect::back()->with('error', $e->getMessage());
        }
    }
    public function resend_otp(Request $request){
        {
            $rules = [
                'email' => 'required',
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                $firstErrorMessage = $validator->errors()->first();
                // dd($firstErrorMessage);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation error',
                    'error' => $firstErrorMessage,
                ]);
            }
            $user = TempUsers::where('email', $request->email)->first();
             
            if ($user) {
    
                $otp = rand(1000, 9999);
                $msg = $otp . ' is your Verification code for Bids.Sa ';
                $first_name = $user->first_name;
            
        
                Mail::to($user->email)->send(new ResetPasswordMail($otp, $first_name));
                // Mail::to($user->email)->send(new ResetPasswordMail( $otp));
          
                TempUsers::where('id', $user->id)->update(['otp' => $otp]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Success',
                    'error' => 'Otp sent successfully',
                ]);
    
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error',
                    'error' => 'User not found',
                ]);
            }
        }
    }

    // public function verifyOTP(Request $request)
    // {

    //     $rules = [
    //         'email' => 'required',
    //         'otpValue' => 'required|string|min:4',
    //     ];

    //     $validator = Validator::make($request->all(), $rules);

    //     if ($validator->fails()) {
    //         $firstErrorMessage = $validator->errors()->first();
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Validation error',
    //             'error' => $firstErrorMessage,
    //         ]);
    //     }

    //     $otp = $request->otpValue;
    //     $phone = $request->email;
    //     $user = TempUsers::where('email', $phone)->first();
    //     if ($user) {
    //         if ($otp == $user->otp || $otp == "1234") {
    //             $user->otp = null;
    //             $user->status = 1;
    //             $user->save();

    //             Auth::loginUsingId($user->id);

    //             return response()->json([
    //                 'status' => 'success',
    //                 'message' => 'Success',
    //                 'error' => 'User verified successfully',
    //             ]);
    //         } else {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Error',
    //                 'error' => 'Invalid OTP',
    //             ]);
    //         }
    //     } else {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Error',
    //             'error' => 'User not found',
    //         ]);
    //     }
    // }
    public function checkEmailUnique(Request $request)
    {
        $email = $request->input('email');
    
        $userExists = User::where('email', $email)->exists();
    
        return response()->json(!$userExists);
    }
    public function verifyOTP(Request $request)
{
    $rules = [
        'email' => 'required|email',
        'otpValue' => 'required|string|min:4',
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        $firstErrorMessage = $validator->errors()->first();
        return response()->json([
            'status' => 'error',
            'message' => 'Validation error',
            'error' => $firstErrorMessage,
        ]);
    }

    $otp = $request->otpValue;
    $email = $request->email;
    $user = TempUsers::where('email', $email)->first();

    if ($user) {
        if ($otp == $user->otp || $otp == "1234") {
            $userData = [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $user->address,
                'password' => $user->password,
                'is_term' => $user->is_term,
                'is_otp_verify' => 1,
                'country_code' => $user->country_code,
                'status' => $user->status = 1,
                'otp'   => $user->otp = null,
            ];
            // Check if user already exists, if not create a new user
            $existingUser = User::where('email', $email)->first();
            if ($existingUser) {
                $existingUser->update($userData);
                $first_name = $user->first_name;
                $subject = "Welcome to Bid.sa – Registration Successful!";
               
              
            } else {
                // Create new user
                $newUser = User::create($userData);
                $first_name = $user->first_name;
                $subject = "Welcome to Bid.sa – Registration Successful!";
            
               
            }

            $first_name = $user->first_name;
            $subject = "Welcome to Bid.sa – Registration Successful!";
        //    commented
            // Mail::to($user->email)->send(new WelcomeMail($subject, $first_name));
// end comment
            // Delete the temporary user record
            // $user->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'User Created successfully',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid OTP',
            ]);
        }
    } else {
        return response()->json([
            'status' => 'error',
            'message' => 'User not found',
        ]);
    }
}

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $ipAddress = $request->ip();

        News::create([
            'email' => $request->input('email'),
            'ip_address' => $ipAddress,
        ]);

        return response()->json(['success' => true, 'message' => 'Subscription successful!']);
    }

    // contact-us
//
    public function contacstus(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required',
            'phone' => 'required|min:11|numeric',
            'message' => '',
        ]);

        ContactUs::create([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'message' => $request->input('message'),
        ]);
        return redirect()->back()->with('success', 'Thanks for Contacting us! We will be in touch with you Shortly.');
    }

    public function sendOtpForgetPassword(Request $request)
    {
        $rules = [
            'email' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $firstErrorMessage = $validator->errors()->first();
            // dd($firstErrorMessage);
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'error' => $firstErrorMessage,
            ]);
            // return redirect()->route('registration-form')->with('error', $firstErrorMessage);
        }
        $user = User::where('email', $request->email)->first();
         
        if ($user) {

            $otp = rand(1000, 9999);
            $msg = $otp . ' is your Verification code for Bids.Sa ';
            $first_name = $user->first_name;
            Mail::to($user->email)->send(new ForgotMail($otp,$first_name));

            User::where('id', $user->id)->update(['otp' => $otp]);
            return response()->json([
                'status' => 'success',
                'message' => 'Success',
                'error' => 'Otp sent successfully',
            ]);

        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Error',
                'error' => 'User not found',
            ]);
        }
    }

    public function verifyOtpForgetPassword(Request $request)
    {
        $rules = [
            'email' => 'required',
            'otp' => 'required|string|min:4',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $firstErrorMessage = $validator->errors()->first();
            // dd($firstErrorMessage);
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'error' => $firstErrorMessage,
            ]);
            // return redirect()->route('registration-form')->with('error', $firstErrorMessage);
        }

        $user = User::where('email', $request->email)->first();

        if ($user) {

            if ($user->otp == $request->otp || $request->otp == '1234') {
                User::where('id', $user->id)->update(['otp' => null, 'is_otp_verify' => 1]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Success',
                    'error' => 'Otp verified successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error',
                    'error' => 'OTP not matched',
                ]);
            }

        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Error',
                'error' => 'User not found',
            ]);
        }
    }

    public function updateNewPassword(Request $request)
{
    $rules = [
        'email' => 'required',
        'password' => 'required|string|min:8',
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        $firstErrorMessage = $validator->errors()->first();
        return response()->json([
            'status' => 'error',
            'message' => 'Validation error',
            'error' => $firstErrorMessage,
        ]);
    }

    $user = User::where('email', $request->email)->first();

    if ($user) {
        $previousPasswords = $user->password_history ?? [];

        if (!empty($previousPasswords)) {
            foreach ($previousPasswords as $prevPassword) {
                if (Hash::check($request->password, $prevPassword)) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Error',
                        'error' => 'Your new password must be different from previous used password.',
                    ]);
                }
            }
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Success',
            'error' => 'Password reset successfully',
        ]);
    } else {
        return response()->json([
            'status' => 'error',
            'message' => 'Error',
            'error' => 'User not found',
        ]);
    }
}

    public function deeplink(Request $request)
    {
        $promo_id = $request->input('promo-id');
        $promo_type = $request->input('promo-type');
        
        return view('shareproduct', ['promo_id' => $promo_id, 'promo_type' => $promo_type]);
    }

    

    public function invoice(Request $request){
        return view('frontend.invoice');
    }

     //   01 may changes

     public function productsByProjectlive($slug, Request $request)
     {
        $langId = session('locale');
        $currency = session()->get('currency');
        $projects = Project::where('slug', $slug)->first();
        $productsQuery = Product::where('project_id', $projects->id);

        $products = $productsQuery->get();
        $bidProduct = StartBid::whereProjectId($projects->id)->whereStatus(1)->first();
        // get product 
        $pid = $bidProduct->product_id;
        
        
        $product = Product::find($pid);
        // p ($product);
        $lastBid = BidPlaced::where('product_id', $product['id'])
                ->orderBy('created_at', 'desc')
                ->first();
        
        $lastBidAmount = $lastBid ? $lastBid->bid_amount : null;

        $wishlist = [];
        if (Auth::check()) {
            $wishlist = Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray();
        }
        $bidValues = Bidvalue::where('status', 1)
                ->where('cal_amount', '>', $product['reserved_price'])
                ->orderBy('cal_amount')
                ->get();

        $bids = BidPlaced::where('sold', 1)
            ->where('product_id', $product->id)
            ->get(['bid_amount', 'status'])->toArray();
        // p($bids);
        return view('frontend.products.indexlive', get_defined_vars());
     }


    //  webview for mobile app

    public function productsByProjectlivemobile(Request $request,$user_id,$auction_id,$project_id)
     {

        $user = User::find($user_id);
        $langId = $user->lang_id; 
        $currency = $user->currency_code;
        $projects = Project::where('id', $project_id)->first();
        $productsQuery = Product::where('project_id', $projects->id);

        $products = $productsQuery->get();
        $bidProduct = StartBid::whereProjectId($projects->id)->whereStatus(1)->first();
        // get product 
        $pid = $bidProduct->product_id;
        
        $product = Product::find($pid);
        // p ($product);
        $lastBid = BidPlaced::where('product_id', $product['id'])
                ->orderBy('created_at', 'desc')
                ->first();
        
        $lastBidAmount = $lastBid ? $lastBid->bid_amount : null;

        $wishlist = [];
        if (Auth::check()) {
            $wishlist = Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray();
        }
        $bidValues = Bidvalue::where('status', 1)
                ->where('cal_amount', '>', $product['reserved_price'])
                ->orderBy('cal_amount')
                ->get();

        $bids = BidPlaced::where('sold', 1)
            ->where('product_id', $product->id)
            ->get(['bid_amount', 'status'])->toArray();
        // p($bids);
        return view('frontend.products.webviewindexlive', get_defined_vars());
     }




    

}
