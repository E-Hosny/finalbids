<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BidPlaced;
use App\Models\City;
use App\Models\Project;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Country;
use App\Models\Useraddress;
use App\Models\Bidvalue;
use Illuminate\Support\Facades\Log;
use App\Models\TempAddress;
use Illuminate\Support\Facades\Mail;
use App\Mail\OutbidNotification;
use App\Models\Gallery;
use App\Mail\BidPlacedMail;
use App\Models\Notification;
use App\Models\Appnotification;
use App\Mail\AdminBidPlacedNotification; // إضافة كلاس البريد للإدمن
use App\Models\User; // تأكد من استيراد نموذج User
use Illuminate\Validation\ValidationException;


class BiddingController extends Controller
{
    public function getStates($countryId)
    {
        $states = State::where('country_id', $countryId)->get(['id', 'name']);

        return response()->json(['states' => $states]);
    }

    public function getCities($stateId)
    {
        $cities = City::where('state_id', $stateId)->get(['id', 'name']);

        return response()->json(['cities' => $cities]);
    }

    public function checkout(Request $request)
    {
        dd("here");
        $currency = session()->get('currency');
        $bidPlacedId = $request->input('bid_placed_id');
        $productId = $request->input('product_id');
        $products= Product::where('id',$productId)->first();
        $lastBid = BidPlaced::where('id', $bidPlacedId)
                            ->where ('status',1)
                            ->orderBy('created_at', 'desc')
                            ->first();

            $lastBidAmount = $lastBid ? $lastBid->bid_amount : null;
            if ($lastBidAmount === null) {
                $lastBidAmount = $products->reserved_price;
            }
            
            $users = Auth::user();
            $countries = Country::get();
            $states = State::all();
            $cities = City::get();
            $userAddresses = [];
            $selectedAddress = null;
            $bidPlacedList = BidPlaced::where('id', $bidPlacedId)
                            ->where('product_id', $products->id)
                            ->orderBy('created_at', 'desc')
                            ->get();
    
        $bidPlacedAmount = $bidPlacedList->first() ? $bidPlacedList->first()->bid_amount : null;
    
        $bidValues = BidValue::where('cal_amount', '>', $bidPlacedAmount)->orderBy('cal_amount', 'asc')->get();

                            
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
       
        return view('frontend.products.checkout',compact('products','lastBidAmount','selectedAddress','userAddresses', 'countries', 'states', 'cities','bidPlacedList','bidPlacedId','bidValues','bidPlacedAmount','currency'));
    }

    // public function bidingplaced(Request $request)
    // {
    //  try {
    //      $validatedData = $request->validate([
    //          'user_id' => 'required|numeric',
    //          'product_id' => 'required',
    //          'project_id' => 'required',
    //          'bid_amount' => 'required',
    //          'buyers_premium' => 'required',
    //          'total_amount' => 'required',
    //          'outbid' => '',
    //          'status' => '',
    //          'first_name' => '', 
    //          'last_name' => '', 
    //          'country' => '', 
    //          'state' => '', 
    //          'city' => '', 
    //          'zipcode' => '', 
    //          'phone' => '', 
    //      ]);
 
            
    //      $bidPlacedId = $request->input('bid_placed_id');
 
    //      if (Auth::check()) {
    //          if ($bidPlacedId) {
    //              $bidPlaced = BidPlaced::where('id', $bidPlacedId)->where('user_id', auth()->id())
    //                                  ->latest()
    //                                  ->first();
 
    //              if ($bidPlaced) {
    //                  $bidPlaced->update($validatedData);
 
    //                  $user = Auth::user();
    //                  $addressData = [
    //                      'first_name' => $request->input('first_name'),
    //                      'last_name' => $request->input('last_name'),
    //                      'country' => $request->input('country'),
    //                      'state' => $request->input('state'),
    //                      'city' => $request->input('city'),
    //                      'zipcode' => $request->input('zipcode'),
    //                      'apartment' => $request->input('apartment'),
    //                      'phone' => $request->input('phone'),
    //                      'bid_placed_id' => $bidPlaced->id,
    //                      'user_id' => $user->id,
    //                  ];
 
    //                   TempAddress::updateOrCreate(['bid_placed_id' => $bidPlacedId], $addressData);
    //                    // Send outbid notification emails
    //                          $product_id = $request->input('product_id');
    //                          $new_bid_amount = $request->input('bid_amount');
                             
    //                          $product = Product::find($product_id);
    //                          $last_bid_amount = $bidPlaced->bid_amount; 
    //                          $imagePath = Gallery::where('lot_no', $product->lot_no)->orderBy('id')->value('image_path');
    //                          $outbidUsers = BidPlaced::where('product_id', $product_id)
    //                                          ->where('outbid', 1)
    //                                          ->where('user_id', '!=', auth()->id())
    //                                          ->get();
    //                                         //  changes 4april
    //                         $first_name = $user->first_name;
    //                         $products_name= Product::where('id',$product->id)->first();
    //                         $product_name =$products_name->title;
    //                         $product_image =Gallery::where('lot_no', $product->lot_no)->orderBy('id')->value('image_path');
    //                         $bid_amount = BidPlaced::where('product_id', $product_id)->where('user_id', $user->id)->latest()->value('bid_amount');
    //                         $auction_end_times =Project::where('id',$product->project_id)->first();
    //                         $auction_end_time=$auction_end_times->end_date_time;
    //                         Mail::to($user->email)->send(new BidPlacedMail($first_name,$product_name,$product_image,$bid_amount,$auction_end_time));
 
    //                          foreach ($outbidUsers as $outbidUser) {
    //                              if ($outbidUser->bid_amount < $new_bid_amount) {
    //                                  // Send email notification to the outbid user
    //                                  $first_name = $user->first_name;
    //                             $products_name= Product::where('id',$product->id)->first();
    //                             $product_name =$products_name->title;
    //                             $product_slug =$products_name->slug;
    //                             $product_image =Gallery::where('lot_no', $product->lot_no)->orderBy('id')->value('image_path');
    //                             $bid_amount = BidPlaced::where('product_id', $product_id)->latest()->value('bid_amount');
    //                             $auction_end_times =Project::where('id',$product->project_id)->first();
    //                             $auction_end_time=$auction_end_times->end_date_time;
    //                             Mail::to($user->email)->send(new OutbidNotification($first_name,$product_name,$product_image,$bid_amount,$auction_end_time,$product_slug));
    //                             // if ($outbidUser->user->notify_on == 0) {
    //                              // Send push notification to the outbid user if device token is available
    //                             $firebaseToken = $outbidUser->user->device_token;
    //                             if ($firebaseToken) {
    //                                 // Replace 'Controller::apiNotificationForApp' with your actual function to send push notifications
    //                                 Controller::apiNotificationForApp($firebaseToken, "You've Been Outbid", 'default_sound.mp3', "Increase your bid before time runs out.", null);
    //                             }
    //                             // Save a notification
    //                                 $notification = new Notification();
    //                                 $notification->type = "You've Been Outbid";
    //                                 $notification->title = "You've Been Outbid";
    //                                 $notification->sender_id = $user->id;
    //                                 $notification->receiver_id = $outbidUser->user_id;
    //                                 $notification->message = "Increase your bid before time runs out.";
    //                                 $notification->product_id = $bidPlaced->product_id;
    //                                 $notification->project_id = $bidPlaced->project_id;
    //                                 $notification->save();

    //                                 $appnotification = new Appnotification();
    //                                 $appnotification->title = "You've Been Outbid";
    //                                 $appnotification->user_id = auth()->id();
    //                                 $appnotification->message = "Increase your bid before time runs out";
    //                                 $appnotification->project_id =$bidPlaced->project_id;
    //                                 $appnotification->product_id = $bidPlaced->product_id;

    //                                 $appnotification->save();
    //                              }
    //                             // }
    //                          }
    //                  return response()->json(['message' => 'Bid request updated successfully']);
    //              } else {
    //                  return response()->json(['message' => 'Bid Placed ID not found or invalid'], 400);
    //              }
    //          } else {
    //              return response()->json(['message' => 'Bid Placed ID is not set'], 400);
    //          }
    //      } else {
    //          return response()->json(['message' => 'User not authenticated'], 401);
    //      }
    //  } catch (ValidationException $e) {
    //      return response()->json(['message' => $e->errors()], 422);
    //  } catch (\Exception $e) {
    //      Log::error('An error occurred: ' . $e->getMessage());
    //      return response()->json(['message' => 'Failed to update bid request'], 500);
    //  }
    // }
    public function bidingplaced(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|numeric',
                'product_id' => 'required',
                'project_id' => 'required',
                'bid_amount' => 'required',
                'buyers_premium' => 'required',
                'total_amount' => 'required',
                'outbid' => '',
                //'status' => '',
                'first_name' => '',
                'last_name' => '',
                'country' => '',
                'state' => '',
                'city' => '',
                'zipcode' => '',
                'phone' => '',
            ]);
            


            $bidPlacedId = $request->input('bid_placed_id');

            if (Auth::check()) {
                if ($bidPlacedId) {
                    $bidPlaced = BidPlaced::where('id', $bidPlacedId)
                                          ->where('user_id', auth()->id())
                                          ->latest()
                                          ->first();

                    if ($bidPlaced) {

                        $validatedData['status'] = BidPlaced::STATUS_PENDING;
                        $bidPlaced->update($validatedData);

                        $user = Auth::user();
                        $addressData = [
                            'first_name' => $request->input('first_name'),
                            'last_name' => $request->input('last_name'),
                            'country' => $request->input('country'),
                            'state' => $request->input('state'),
                            'city' => $request->input('city'),
                            'zipcode' => $request->input('zipcode'),
                            'apartment' => $request->input('apartment'),
                            'phone' => $request->input('phone'),
                            'bid_placed_id' => $bidPlaced->id,
                            'user_id' => $user->id,
                        ];

                        TempAddress::updateOrCreate(['bid_placed_id' => $bidPlacedId], $addressData);

                        // **** إضافة الكود لإرسال بريد إلكتروني للإدمن ****

                        // جلب بريد الإدمن (صاحب المعرف 1)
                        // $admin = User::find(1);
                        // if ($admin) {
                        //     $adminEmail = $admin->email;

                        //     $product = Product::find($validatedData['product_id']);
                        //     $project = Project::find($validatedData['project_id']);

                        //     $bidDetails = [
                        //         'user_name' => $user->first_name . ' ' . $user->last_name,
                        //         'product_name' => $product ? $product->title : 'N/A',
                        //         'project_name' => $project ? $project->name : 'N/A',
                        //         'bid_amount' => $validatedData['bid_amount'],
                        //         'buyers_premium' => $validatedData['buyers_premium'],
                        //         'total_amount' => $validatedData['total_amount'],
                        //         'admin_panel_link' => route('admin.bid-placed.index'),
                        //     ];

                        //     Mail::to($adminEmail)->send(new AdminBidPlacedNotification($bidDetails));
                        // }

                        // $adminEmail = 'elkhouly@gmail.com';
                        $adminEmail = env('ADMIN_EMAIL', 'ebrahimhosny511@gmail.com');

                        $product = Product::find($validatedData['product_id']);
                        $project = Project::find($validatedData['project_id']);
                        $bidDetails = [
                            'user_name' => $user->first_name . ' ' . $user->last_name,
                            'product_name' => $product->title ?? 'N/A',
                            'project_name' => $project->name ?? 'N/A',
                            'bid_amount' => $validatedData['bid_amount'],
                            'buyers_premium' => $validatedData['buyers_premium'],
                            'total_amount' => $validatedData['total_amount'],
                            'admin_panel_link' => route('admin.bid-placed.index'),
                        ];

                        Mail::to($adminEmail)->send(new AdminBidPlacedNotification($bidDetails));

                        Mail::to($user->email)->send(new BidPlacedMail(
                            $user->first_name,
                            $product->title,
                            Gallery::where('lot_no', $product->lot_no)->orderBy('id')->value('image_path'),
                            $bidPlaced->bid_amount,
                            $project->end_date_time
                        ));

                        Log::info('Sending email to: ' . $user->email);
                        Log::info('Bid Details: ', [
                            'First Name' => $user->first_name,
                            'Product Name' => $product->title ?? 'Unknown Product',
                            'Image' => Gallery::where('lot_no', $product->lot_no)->orderBy('id')->value('image_path') ?? 'No Image',
                            'Bid Amount' => $bidPlaced->bid_amount ?? '0',
                            'Auction End Time' => $project->end_date_time ?? 'No End Date',
                        ]);
                        // **** نهاية الكود المضاف ****

                        // إرسال بريد للمستخدم
                        $first_name = $user->first_name;
                        $products_name = Product::where('id', $bidPlaced->product_id)->first();
                        $product_name = $products_name->title;
                        $product_image = Gallery::where('lot_no', $products_name->lot_no)->orderBy('id')->value('image_path');
                        $bid_amount = BidPlaced::where('product_id', $bidPlaced->product_id)
                                               ->where('user_id', $user->id)
                                               ->latest()
                                               ->value('bid_amount');
                        $auction_end_times = Project::where('id', $products_name->project_id)->first();
                        $auction_end_time = $auction_end_times->end_date_time;
                        Mail::to($user->email)->send(new BidPlacedMail($first_name, $product_name, $product_image, $bid_amount, $auction_end_time));

                        // إرسال إشعارات للمزايدين الآخرين
                        $product_id = $request->input('product_id');
                        $new_bid_amount = $request->input('bid_amount');

                        $product = Product::find($product_id);
                        $last_bid_amount = $bidPlaced->bid_amount;
                        $imagePath = Gallery::where('lot_no', $product->lot_no)->orderBy('id')->value('image_path');
                        $outbidUsers = BidPlaced::where('product_id', $product_id)
                                                ->where('outbid', 1)
                                                ->where('user_id', '!=', auth()->id())
                                                ->get();

                        foreach ($outbidUsers as $outbidUser) {
                            if ($outbidUser->bid_amount < $new_bid_amount) {
                                // إرسال بريد إلكتروني للمستخدم الذي تم تجاوزه
                                $first_name = $outbidUser->user->first_name;
                                $products_name = Product::where('id', $product->id)->first();
                                $product_name = $products_name->title;
                                $product_slug = $products_name->slug;
                                $product_image = Gallery::where('lot_no', $product->lot_no)->orderBy('id')->value('image_path');
                                $bid_amount = BidPlaced::where('product_id', $product_id)->latest()->value('bid_amount');
                                $auction_end_times = Project::where('id', $product->project_id)->first();
                                $auction_end_time = $auction_end_times->end_date_time;
                                Mail::to($outbidUser->user->email)->send(new OutbidNotification($first_name, $product_name, $product_image, $bid_amount, $auction_end_time, $product_slug));

                                // إرسال إشعار Push Notification إذا كان متاحًا
                                $firebaseToken = $outbidUser->user->device_token;
                                if ($firebaseToken) {
                                    Controller::apiNotificationForApp($firebaseToken, "You've Been Outbid", 'default_sound.mp3', "Increase your bid before time runs out.", null);
                                }

                                // حفظ إشعار في قاعدة البيانات
                                $notification = new Notification();
                                $notification->type = "You've Been Outbid";
                                $notification->title = "You've Been Outbid";
                                $notification->sender_id = $user->id;
                                $notification->receiver_id = $outbidUser->user_id;
                                $notification->message = "Increase your bid before time runs out.";
                                $notification->product_id = $bidPlaced->product_id;
                                $notification->project_id = $bidPlaced->project_id;
                                $notification->save();

                                $appNotification = new AppNotification();
                                $appNotification->title = "You've Been Outbid";
                                $appNotification->user_id = $outbidUser->user_id;
                                $appNotification->message = "Increase your bid before time runs out";
                                $appNotification->project_id = $bidPlaced->project_id;
                                $appNotification->product_id = $bidPlaced->product_id;
                                $appNotification->save();
                            }
                        }

                        return response()->json(['message' => 'Bid request updated successfully']);
                    } else {
                        return response()->json(['message' => 'Bid Placed ID not found or invalid'], 400);
                    }
                } else {
                    return response()->json(['message' => 'Bid Placed ID is not set'], 400);
                }
            } else {
                return response()->json(['message' => 'User not authenticated'], 401);
            }
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to update bid request'], 500);
        }
    }
    // 02 may changes
    public function bidingplacedlive(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => '',
            'product_id' => '',
            'project_id' => '',
            'bid_amount' => '',
            'buyers_premium' => '',
            'total_amount' => '',
            'outbid' => '',
            'status' => '',
        
        ]);
       
        try {
            
           $bid= BidPlaced::create($validatedData);
    
            return response()->json(['message' => 'Bid request stored successfully','bid'=>$bid]);
        } catch (\Exception $e) {
            \Log::error('An error occurred: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to store bid request'], 500);
        }
    }

}
