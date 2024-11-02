<?php

namespace App\Http\Controllers\Frontend;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Traits\ImageTrait;
use App\Models\Useraddress;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Mail\ProfileupdateMail;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use App\Models\{BidRequest,BidPlaced,User,Wishlist};







class DashboardController extends Controller
{
    use ImageTrait;

    public function userdashboard(Request $request)
    {
        $users = Auth::user();
        return view('frontend.dashboard.myaccount', compact('users'));
    }

    public function auction(){

        $currency = session()->get('currency');
        $user_id = Auth::id();

        $bids = BidPlaced::with(['product.project.auctionType'])
                            ->where('sold', 1)
                            ->whereIn('product_id', function($query) use ($user_id) {
                                $query->select('product_id')
                                    ->from('bid_placed')
                                    ->where('user_id', $user_id);
                            })
                            ->orderBy('created_at', 'desc')
                            ->get();

        $groupedBids = $bids->groupBy('product_id');
        $bidsCountByUserAndProduct = BidPlaced::where('status', 1)
                                ->where('sold',1)
                                ->where('user_id', $user_id)
                                ->groupBy('product_id')
                                ->selectRaw('product_id, count(distinct user_id) as count')
                                ->get();

        // for past bids
        $bidspast = BidPlaced::with(['product.project.auctionType'])
                                ->where('sold',2)
                                ->whereIn('product_id', function($query) use ($user_id) {
                                    $query->select('product_id')
                                        ->from('bid_placed')
                                        ->where('user_id', $user_id);
                                })
                                ->orderBy('created_at', 'desc')
                                ->get();
        $groupedBidspast = $bidspast->groupBy('product_id');
        $bidsCountByUserAndProductPast = BidPlaced::where('status', 1)
                                ->where('user_id', $user_id)
                                ->where('sold',2)
                                ->groupBy('product_id')
                                ->selectRaw('product_id, count(distinct user_id) as count')
                                ->get();
        return view('frontend.auction',compact('groupedBids','bidsCountByUserAndProduct','currency','groupedBidspast','bidsCountByUserAndProductPast'));
    }
    // pdf generate
    public function generatePdf($view, $data, $filename) {
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->setBasePath('https://bid.sa/img/settings/');
        $dompdf->loadHtml(View::make($view, $data)->render());
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream($filename);
    }

    public function downloadInvoice()
    {
        $invoiceNumber = 'Inv-' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);

        // Current date
        $currentDate = now()->format('Y-m-d');
        $user_id = Auth::id();
        $bidspast = BidPlaced::with(['product.project.auctionType'])
                    ->where('sold',2)
                    ->where('status',2)
                    ->whereIn('product_id', function($query) use ($user_id) {
                        $query->select('product_id')
                            ->from('bid_placed')
                            ->where('user_id', $user_id);
                    })
                    ->orderBy('created_at', 'desc')
                    ->get();
                    // $groupedBidspast = $bidspast->groupBy('product_id');
                    $invoiceData = [
                        'invoiceNumber' => $invoiceNumber,
                        'date' => $currentDate,

                    ];

        return $this->generatePdf('frontend.invoice', compact('invoiceData', 'bidspast'), 'invoice.pdf');
    }
    public function profileupdate(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();
        $user_id = $user->id;

        $todo = User::find($user_id);


        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $this->verifyAndUpload($request, 'profile_image', $user->profile_image);
            $data['profile_image'] = asset('img/users/' . $data['profile_image']);
            $todo->profile_image = $data['profile_image'];
        }

        $todo->first_name = $request->first_name;
        $todo->last_name = $request->last_name;
        $todo->phone = $request->phone;
        $todo->save();
        $first_name = $todo->first_name;
        Mail::to($user->email)->send(new ProfileupdateMail($first_name));

        if ($todo) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function changepassword(Request $request)
    {
        // $users = Auth::user();
        return view('frontend.dashboard.change-password');
    }

    public function changePass(Request $request)
    {
        $rules = [
            'current_password' => 'required',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.',
            ], 404);
        }

        if (Hash::check($request->current_password, $user->password)) {
            // Password match, proceed with updating the password
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            $notification_msg = 'You changed your password successfully';

                // Send a notification if user has a device token
                if ($user->notify_on == 0) {
                $firebaseToken = $user->device_token;
                if ($firebaseToken) {
                    Controller::apiNotificationForApp($firebaseToken, 'Change Password', 'default_sound.mp3', $notification_msg, null);
                }

                // Save a notification
                $notification = new Notification();
                $notification->type = 'Change Password';
                $notification->title = 'Change Password';
                $notification->sender_id = $user->id;
                $notification->receiver_id = $user->id;
                $notification->message = $notification_msg;
                $notification->save();
              }
            return redirect()->route('userdashboard')->with('success', true);

        } else {
            // Incorrect current password
            return redirect()->route('updateinfo')->with('error', 'Current password is incorrect.');
        }

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('homepage');
    }

    // user Address

    public function useraddress(Request $request)
    {
        $userAddresses = Useraddress::where('user_id', auth()->user()->id)->get();
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
            $defaultCountryId = 247;
            $defaultCountry = Country::find($defaultCountryId);

            $defaultAddress = new UserAddress();
            $defaultAddress->country = $defaultCountryId;

            $selectedAddress = $defaultAddress;
        }

        return view('frontend.dashboard.useraddress', compact('userAddresses','selectedAddress','userAddresses','countries','states','cities'));
    }


    // addaddress

    public function adduseraddress(Request $request)
    {
        $rules = [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'apartment' => 'nullable|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'state' => 'required|string',
            'zipcode' => 'required|string',
            'is_save' => 'required|boolean',
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

        $user = auth()->user();
        $userAddress = new Useraddress($request->all());
        $userAddress->user_id = $user->id;
        $userAddress->save();

        return redirect()->back()->with('success', 'User address added successfully');
    }

    public function addresseedit(Request $request,$id){
        $data =Useraddress::where('id',$id)->first();
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
            $defaultCountryId = 247;
            $defaultCountry = Country::find($defaultCountryId);

            $defaultAddress = new UserAddress();
            $defaultAddress->country = $defaultCountryId;

            $selectedAddress = $defaultAddress;
        }
        return view ('frontend.dashboard.editaddress',compact('data','selectedAddress','userAddresses','countries','states','cities'));
    }

    // delete address

    public function delete($id)
    {
        $userAddress = Useraddress::find($id);

        if (!$userAddress) {
            return redirect()->route('user.addresses')->with('error', 'Address not found');
        }

        $userAddress->delete();

        return redirect()->back()->with('success', 'Address deleted successfully');
    }

    public function primary($id)
{
    $userAddress = Useraddress::find($id);

    if (!$userAddress) {
        return response()->json(['error' => 'Address not found'], 404);
    }

    $userId = $userAddress->user_id;

    Useraddress::where('user_id', $userId)
        ->where('id', '!=', $id)
        ->update(['is_primary' => 0]);

    // Set the selected address as primary
    $userAddress->update([
        'is_primary' => 1,
    ]);

    return response()->json(['success' => 'Address updated successfully'], 200);
}




    // edit update

    public function edit($id)
    {
        $address = UserAddress::find($id);

        return view('user.addresses.edit', compact('address'));
    }

    public function update(Request $request, $id)
    {
        $address = UserAddress::find($id);
        $address->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'apartment' => $request->input('apartment'),
            'city' => $request->input('city'),
            'country' => $request->input('country'),
            'state' => $request->input('state'),
            'zipcode' => $request->input('zipcode'),
        ]);

        // Return JSON response indicating success
        return response()->json(['success' => true]);
    }
    public function validateCurrentPassword(Request $request)
    {

        $currentPassword = $request->input('current_password');
        $user = auth()->user();

        if (!password_verify($currentPassword, $user->password)) {
            return response('invalid', 422);
        }

        return response('valid');
    }

    public function getwishlist(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $wishlistItems = Wishlist::with('products')->where('user_id', $user->id)->paginate(10);
            return view('frontend.products.wishlist', ['wishlistItems' => $wishlistItems]);
        }

        return view('frontend.products.wishlist');
    }

        // bid store
        public function bidstore(Request $request)
        {
            $existingBid = BidRequest::where('user_id', $request->user_id)
            ->where('project_id', $request->project_id)
            ->exists();

                if ($existingBid) {
                    return response()->json(['error' => 'You have already placed a bid for this project']);
                }
            BidRequest::create([
                'user_id' => $request->user_id,
                'project_id' => $request->project_id,
                'auction_type_id' => $request->auction_type_id,
                'deposit_amount' => $request->deposit_amount,
            ]);

            return response()->json(['message' => 'Bid request stored successfully']);
        }

     // bidding place

     public function bidplaced(Request $request)
     {
         $validatedData = $request->validate([
             'user_id' => 'required',
             'project_id' => 'required',
             'auction_type_id' => 'required',
             'bid_amount' => 'required',
             'product_id' => 'required'
         ]);

         try {

            $bid= BidPlaced::create($validatedData);

             return response()->json(['message' => 'Bid request stored successfully','bid'=>$bid]);
         } catch (\Exception $e) {
             Log::error('An error occurred: ' . $e->getMessage());
             return response()->json(['message' => 'Failed to store bid request'], 500);
         }
     }

    //  Paynow dummy
    public function paynow(Request $request){
        $productId = $request->input('product_id');


        BidPlaced::where('product_id', $productId)->update(['sold' => 2]);

        return response()->json(['success' => true]);
    }


}
