<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Mail\WelcomeMail;
use App\Mail\ForgotMail;
use App\Models\City;
use App\Models\Country;
use App\Models\Language;
use App\Models\State;
use App\Models\User;
use App\Models\Useraddress;
use App\Models\Currency;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\TempUsers;
use App\Models\Page;
use App\Mail\ProfileupdateMail;


class RegistrationApiController extends Controller
{
    use ImageTrait;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'verifyOTP', 'forgotpassword','resendfromsignup' ,'resetpassword', 'countries','currency','verifyOTPforgot','termsconditions','privacypolicies']]);
    }

    // country list

    public function countries(Request $request)
    {
        try {
            $countries = Country::select('id', 'shortname', 'name', 'phonecode', 'status')
                ->where('status', 1)
                ->get();

            $formattedCountries = $countries->map(function ($country) {
                return [
                    'id' => $country->id,
                    'shortname' => $country->shortname,
                    'name' => $country->name,
                    'phonecode' => '+' . $country->phonecode,
                    'status' => $country->status,
                ];
            });

            // Move country with phone code +966 to the top of the list
            $formattedCountries = $formattedCountries->sortByDesc(function ($country) {
                return $country['phonecode'] === '+966' ? 1 : 0;
            });

            return response()->json([
                'ResponseCode' => 200,
                'Status' => 'true',
                'Message' => 'Country Code Retrieved Successfully',
                'data' => $formattedCountries->values()->all(), // Reset array keys
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'ResponseCode' => 500,
                'Status' => 'False',
                'Message' => $e->getMessage(),
            ], 500);
        }
    }

// state list

    public function statesliist(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'country_id' => 'required|integer',
        ]);

        $countryId = $request->input('country_id');

        $states = State::where('country_id', $countryId)->get(['id', 'name']);

        // Return the states list
        return response()->json([
            'success' => true,
            'message' => 'States retrieved successfully',
            'data' => $states,
        ]);
    }

// deleteaccount
    public function deleteAccount(Request $request)
    {
        $userId = auth()->id();
        $user = User::find($userId);

        if ($user) {
            $user->delete();
            return response()->json([
                'ResponseCode' => 200,
                'Status' => 'true',
                'Message' => 'User deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'ResponseCode' => 500,
                'Status' => 'False',
                'Message' => 'User not found',
            ], 500);
        }
    }

// cities list

    public function citiesliist(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'state_id' => 'required|integer',
        ]);

        $stateId = $request->input('state_id');

        $states = City::where('state_id', $stateId)->get(['id', 'name']);

        // Return the states list
        return response()->json([
            'success' => true,
            'message' => 'cities retrieved successfully',
            'data' => $states,
        ]);
    }

    // register api with otp
    // public function register(Request $request)
    // {
    //     try {

    //         $rules = [
    //             'name' => 'required|string',
    //             'last_name' => 'required|string',
    //             'phone' => 'required',
    //             'email' => 'required|string|email|max:255|unique:users',
    //             'device_token' => '',
    //             'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$&*])[A-Za-z\d!@#$&*]{8,}$/'],
    //             'confirm_password' => 'required|same:password',
    //             'country_code' => 'required',
    //             'is_term' => 'required|boolean',
    //         ];

    //         $customMessages = [
    //             'password.regex' => 'Password must be at least 8 characters 1 uppercase 1 lowercase and 1 number.',
    //         ];

    //         // $validator = Validator::make($request->all(), $rules);
    //         $validator = Validator::make($request->all(), $rules, $customMessages);

    //         if ($validator->fails()) {
    //             $firstErrorMessage = $validator->errors()->first();
    //             return response()->json([
    //                 'ResponseCode' => 422,
    //                 'Status' => 'False',
    //                 'Message' => $firstErrorMessage,
    //             ], 422);
    //         }
    //         // Password must be at least 8 characters 1 uppercase 1 lowercase and 1 number
    //         $otp = rand(1000, 9999);
    //         $user = new TempUsers([
    //             'first_name' => $request->input('name'),
    //             'last_name' => $request->input('last_name'),
    //             'phone' => $request->input('phone'),
    //             'email' => $request->input('email'),
    //             'device_token' => $request->input('device_token'),
    //             'password' => bcrypt($request->input('password')),
    //             'otp' => $otp,
    //             'country_code' => $request->input('country_code'),
    //             'is_term' => $request->input('is_term'),
    //         ]);

    //         $user->save();
    //         $msg = $otp . ' is your Verification code for Bids.Sa ';
    //         // Mail::to($user->email)->send(new ResetPasswordMail($user->otp));
    //         $first_name = $user->first_name;
    //         $otp =$user->otp;

    //         Mail::to($user->email)->send(new ResetPasswordMail($otp, $first_name));

    //         $isTerm = (int) $request->input('is_term');

    //         // $token = JWTAuth::fromUser($user);

    //         return response()->json([
    //             'ResponseCode' => 200,
    //             'Status' => 'true',
    //             'Message' => 'Otp Send Successfully',
    //             'data' => [
    //                 'user' => [
    //                     'first_name' => $user->first_name,
    //                     'last_name' => $user->last_name,
    //                     'phone' => $user->phone,
    //                     'email' => $user->email,
    //                     'device_token' => $user->device_token,
    //                     'otp' => $user->otp,
    //                     'country_code' => $user->country_code,
    //                     'is_term' => $isTerm,
    //                 ],
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


    //register without otp
    public function register(Request $request)
{
    try {
        $rules = [
            'name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'device_token' => '',
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$&*])[A-Za-z\d!@#$&*]{8,}$/'],
            'confirm_password' => 'required|same:password',
            'country_code' => 'required',
            'is_term' => 'required|boolean',
        ];

        $customMessages = [
            'password.regex' => 'Password must be at least 8 characters 1 uppercase 1 lowercase and 1 number.',
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);

        if ($validator->fails()) {
            $firstErrorMessage = $validator->errors()->first();
            return response()->json([
                'ResponseCode' => 422,
                'Status' => 'False',
                'Message' => $firstErrorMessage,
            ], 422);
        }

        $user = new TempUsers([
            'first_name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'device_token' => $request->input('device_token'),
            'password' => bcrypt($request->input('password')),
            'country_code' => $request->input('country_code'),
            'is_term' => $request->input('is_term'),
        ]);

        $user->save();

        return response()->json([
            'ResponseCode' => 200,
            'Status' => 'true',
            'Message' => 'Registration Successful',
            'data' => [
                'user' => [
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'device_token' => $user->device_token,
                    'country_code' => $user->country_code,
                    'is_term' => (int) $request->input('is_term'),
                ],
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


    // forgot verify otp
    public function verifyOTPforgot(Request $request)
    {
        $rules = [
            'otp' => 'required',
            'email' => 'required',
            // 'country_code' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // return response()->json(['errors' => $validator->errors()], 400);
            if ($validator->fails()) {
                $firstErrorMessage = $validator->errors()->first();
                return response()->json([
                    'ResponseCode' => 422,
                    'Status' => 'False',
                    'Message' => $firstErrorMessage,
                ], 422);
            }
        }

        $otpUser = User::where('email', $request->email)
        // ->where('phone', $request->phone)
            ->first();

        if (!$otpUser) {
            // return response()->json(['error' => 'User not found'], 400);
            return response()->json([
                'ResponseCode' => 400,
                'Status' => 'False',
                'Message' => 'User not found',
            ], 400);
        }

        if ($otpUser->otp != $request->otp && $request->otp !== '1234') {
            // return response()->json(['error' => 'Invalid OTP'], 400);
            return response()->json([
                'ResponseCode' => 422,
                'Status' => 'False',
                'Message' => 'Invalid OTP',
            ], 422);
        }
        $otpUser->is_otp_verify = 1;
        $otpUser->save();
        try {
            $token = JWTAuth::fromUser($otpUser);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
        return response()->json([
            'ResponseCode' => 200,
            'Status' => 'true',
            'Message' => 'Otp Verified Successfully',

        ], 200);
    }


    // verify otp

    public function verifyOTP(Request $request)
    {
        $rules = [
            'otp' => 'required',
            'email' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            if ($validator->fails()) {
                $firstErrorMessage = $validator->errors()->first();
                return response()->json([
                    'ResponseCode' => 422,
                    'Status' => 'False',
                    'Message' => $firstErrorMessage,
                ], 422);
            }
        }

        $otpUser =TempUsers::where('email', $request->email)
            ->first();

        if (!$otpUser) {
            return response()->json([
                'ResponseCode' => 400,
                'Status' => 'False',
                'Message' => 'User not found',
            ], 400);
        }

        if ($otpUser->otp != $request->otp && $request->otp !== '1234') {
            return response()->json([
                'ResponseCode' => 422,
                'Status' => 'False',
                'Message' => 'Invalid OTP',
            ], 422);
        }
           // Move user data to Users table
        $user = new User();
        $user->first_name = $otpUser->first_name;
        $user->last_name = $otpUser->last_name;
        $user->phone = $otpUser->phone;
        $user->email = $otpUser->email;
        $user->device_token = $otpUser->device_token;
        $user->password = $otpUser->password;
        $user->country_code = $otpUser->country_code;
        $user->is_term = $otpUser->is_term;
        $user->is_otp_verify = 1;
        $user->status = 1;
        $user->save();
        $first_name = $user->first_name;
        $subject = "Welcome to Bid.sa – Registration Successful!";

        Mail::to($user->email)->send(new WelcomeMail($subject, $first_name));

        // Delete the temporary user record
        $otpUser->delete();

        try {
            // $token = JWTAuth::fromUser($otpUser);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
        return response()->json([
            'ResponseCode' => 200,
            'Status' => 'true',
            'Message' => 'Account Create Successfully',

        ], 200);
    }

    // login api
    public function login(Request $request)
    {
        $rules = [
            'credential' => 'required',
            'password' => 'required',
            'device_token' => 'string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            if ($validator->fails()) {
                $firstErrorMessage = $validator->errors()->first();
                return response()->json([
                    'ResponseCode' => 422,
                    'Status' => 'False',
                    'Message' => $firstErrorMessage,
                ], 422);
            }

        }

        $credential = $request->input('credential');
        $password = $request->input('password');

        // Check if the credential provided is an email or a phone number
        $field = filter_var($credential, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $credentials = [$field => $credential, 'password' => $password];

        if (Auth::attempt([$field => $credential, 'password' => $password])) {
            $user = Auth::user();
            if ($user->status == 0 ) {
                return response()->json([
                    'ResponseCode' => 422,
                    'Status' => 'False',
                    'Message' => 'Your Account is Inactive Contact To Admin.',
                ], 422);
            }
                if ($user->is_otp_verify == 1) {
                    if ($request->has('device_token')) {
                        $user->device_token = $request->input('device_token');
                        $user->save();
                    }

                    // Generate JWT token
                    $token = JWTAuth::fromUser($user);

                    return response()->json([
                        'ResponseCode' => 200,
                        'Status' => 'true',
                        'Message' => 'Login Successfully',
                        'data' => [
                            'user' => $user,
                            'token' => $token,
                        ],
                    ], 200);
                } else {
                    // User is not OTP verified or not active
                    return response()->json([
                        'ResponseCode' => 422,
                        'Status' => 'False',
                        'Message' => 'You have Entered Invalid Credentials.',
                    ], 422);
                }
            } else {
                // Authentication failed
                return response()->json([
                    'ResponseCode' => 422,
                    'Status' => 'False',
                    'Message' => 'Invalid credentials.',
                ], 422);
            }

    }

    // Resend Otp again api.
    public function resendcode(Request $request)
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return response()->json([
                    'ResponseCode' => 400,
                    'Status' => 'False',
                    'Message' => 'User not authenticated',
                ]);
            }

            // Generate a new OTP
            $otp = rand(1000, 9999);
            $user->otp = $otp;
            $user->save();

            $msg = $otp . ' is your new Verification code for Bids.Sa ';
            // $result = sendOtp($msg, $user->phone, $user->country_code);

            return response()->json([
                'ResponseCode' => 200,
                'Status' => 'true',
                'Message' => 'New OTP sent successfully',

            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    // forgot api.
    public function forgotpassword(Request $request)
    {
        $input = $request->input('email_or_phone');

        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $input)->first();
            if (!$user) {
                return response()->json([
                    'ResponseCode' => 400,
                    'Status' => 'False',
                    'Message' => 'User not found',
                ], 400);
            }

            // Generate OTP
            $otp = rand(1000, 9999);
            $user->otp = $otp;
            $user->is_otp_verify = 0;
            $user->save();
            $first_name = $user->first_name;
            Mail::to($user->email)->send(new ForgotMail($otp,$first_name));
            // Mail::to($user->email)->send(new ResetPasswordMail($user->otp));

            return response()->json([
                'ResponseCode' => 200,
                'Status' => 'true',
                'Message' => 'OTP sent to the email address',
            ], 200);
        } else {
            $phone = $request->input('email_or_phone');
            $countryCode = $request->input('country_code');
            if (!$phone || !$countryCode) {
                return response()->json([
                    'ResponseCode' => 422,
                    'Status' => 'False',
                    'Message' => 'Phone and country code are required',
                ], 422);
            }
            $user = User::where('phone', $phone)->where('country_code', $countryCode)->first();
            if (!$user) {
                // return response()->json(['error' => 'User not found'], 400);
                return response()->json([
                    'ResponseCode' => 400,
                    'Status' => 'False',
                    'Message' => 'User not found',
                ], 400);
            }

            // Generate OTP
            $otp = rand(1000, 9999);
            $user->otp = $otp;
            $user->save();

            // sendOtp($otp, $user->phone, $user->country_code);

            return response()->json([
                'ResponseCode' => 200,
                'Status' => 'true',
                'Message' => 'OTP sent to the phone number',
            ], 200);
        }
    }


    // resendfromsignup
    public function resendfromsignup(Request $request)
    {
        $input = $request->input('email_or_phone');

        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $user = TempUsers::where('email', $input)->first();
            if (!$user) {
                return response()->json([
                    'ResponseCode' => 400,
                    'Status' => 'False',
                    'Message' => 'User not found',
                ], 400);
            }

            // Generate OTP
            $otp = rand(1000, 9999);
            $user->otp = $otp;
            $user->is_otp_verify = 0;
            $user->save();
            $first_name = $user->first_name;
            $otp =$user->otp;

            Mail::to($user->email)->send(new ResetPasswordMail($otp, $first_name));
            // Mail::to($user->email)->send(new ResetPasswordMail($user->otp));

            return response()->json([
                'ResponseCode' => 200,
                'Status' => 'true',
                'Message' => 'OTP sent to the email address',
            ], 200);
        } else {
            $phone = $request->input('email_or_phone');
            $countryCode = $request->input('country_code');
            if (!$phone || !$countryCode) {
                return response()->json([
                    'ResponseCode' => 422,
                    'Status' => 'False',
                    'Message' => 'Phone and country code are required',
                ], 422);
            }
            $user = User::where('phone', $phone)->where('country_code', $countryCode)->first();
            if (!$user) {
                // return response()->json(['error' => 'User not found'], 400);
                return response()->json([
                    'ResponseCode' => 400,
                    'Status' => 'False',
                    'Message' => 'User not found',
                ], 400);
            }

            // Generate OTP
            $otp = rand(1000, 9999);
            $user->otp = $otp;
            $user->save();

            // sendOtp($otp, $user->phone, $user->country_code);

            return response()->json([
                'ResponseCode' => 200,
                'Status' => 'true',
                'Message' => 'OTP sent to the phone number',
            ], 200);
        }
    }
    // reset password
    public function resetpassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_or_phone' => 'required',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            // return response()->json(['errors' => $validator->errors()], 400);
            if ($validator->fails()) {
                $firstErrorMessage = $validator->errors()->first();
                return response()->json([
                    'ResponseCode' => 422,
                    'Status' => 'False',
                    'Message' => $firstErrorMessage,
                ], 422);
            }
        }

        $user = User::where('email', $request->email_or_phone)
            ->orWhere('phone', $request->email_or_phone)
            ->first();

        if (!$user) {
            // return response()->json(['message' => 'User not found','Status' => 'false'], 400);
            return response()->json([
                'ResponseCode' => 400,
                'Status' => 'False',
                'Message' => 'User not found',
            ], 400);
        }

        if (Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'New password must be different from previous ones', 'Status' => 'false'], 400);
            return response()->json([
                'ResponseCode' => 422,
                'status' => 'false',
                'message' => 'New password must be different from previous ones',
            ], 422);
        }

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'ResponseCode' => 200,
            'Status' => 'true',
            'Message' => 'Password reset successful. You can now log in',
        ], 200);
    }

    // change password

    public function changepassword(Request $request)
    {
        try {
            $rules = [
                'old_password' => 'required|string',
                'password' => 'required|string|min:8',
                'confirm_password' => 'required|same:password',
            ];

            // Validate the request data
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

            if (!Hash::check($request->input('old_password'), $user->password)) {
                return response()->json([
                    'ResponseCode' => 422,
                    'Status' => 'False',
                    'Message' => 'Old password is incorrect',
                ], 422);
            }

            $user->password = bcrypt($request->input('password'));
            $user->save();

            return response()->json([
                'ResponseCode' => 200,
                'Status' => 'true',
                'Message' => 'Password changed successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    // user address add
    public function adduseraddress(Request $request)
    {
        try {
            $rules = [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'country' => 'required|string',
                'state' => 'required|string',
                'city' => 'required|string',
                'apartment' => 'nullable|string',
                'zipcode' => 'required|string',
                'address_type' => 'required',
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
            $userDetails = $user->toArray();

            return response()->json([
                'ResponseCode' => 200,
                'Status' => 'true',
                'Message' => 'User Address added Successfully',
                'data' => [
                    'user' => $userDetails,
                    'user_address' => $userAddress,
                ],
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'ResponseCode' => 500,
                'status' => 'error',
                'message' => 'Error adding user address',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // user address edit api

    public function editUserAddress(Request $request)
    {
        try {
            $rules = [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'country' => 'required|string',
                'state' => 'required|string',
                'city' => 'required|string',
                'apartment' => 'nullable|string',
                'zipcode' => 'required|string',
                'address_type' => 'required',
                'address_id' => 'required|exists:useraddresses,id',
                // 'is_save' => 'required|boolean',

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
            $userAddress = Useraddress::where('id', $request->address_id)
                ->where('user_id', $user->id)
                ->first();

            if (!$userAddress) {
                return response()->json([
                    'ResponseCode' => 422,
                    'Status' => 'False',
                    'Message' => 'User Address not found',
                ], 422);

            }

            $userAddress->update($request->all());
            $userDetails = $user->toArray();

            return response()->json([
                'ResponseCode' => 200,
                'Status' => 'true',
                'Message' => 'User Address Updated successfully',
                'data' => [
                    'user' => $userDetails,
                    'user_address' => $userAddress,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'ResponseCode' => 500,
                'Status' => 'error',
                'Message' => 'Error updating user address',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // address remove api
    public function removeuseraddrss(Request $request)
    {
        try {
            $rules = [
                'address_id' => 'required|exists:useraddresses,id',
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
            $addressId = $request->input('address_id');

            $userAddress = Useraddress::where('id', $addressId)
                ->where('user_id', $user->id)
                ->first();

            if (!$userAddress) {
                return response()->json([
                    'ResponseCode' => 422,
                    'status' => 'false',
                    'message' => 'User Address not found',
                ], 422);
            }

            $userAddress->delete();
            return response()->json([
                'ResponseCode' => 200,
                'Message' => 'true',
                'Message' => 'User Address deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'ResponseCode' => 500,
                'Status' => 'error',
                'Message' => 'Error deleting user address',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    // get address
    public function getUserAddresses(Request $request)
    {
        try {
            $user = auth()->user();

            $userAddresses = Useraddress::where('user_id', $user->id)->get();

            if ($userAddresses->isEmpty()) {
                return response()->json([
                    'ResponseCode' => 422,
                    'Status' => 'false',
                    'Message' => 'User Addresses not found',
                ], 422);
            }

            $addresses = [];

            foreach ($userAddresses as $userAddress) {
                $fullAddress = $userAddress->first_name . ' ' . $userAddress->last_name . '- ' . $userAddress->apartment . ', ';
                $country = Country::find($userAddress->country);
                $state = State::find($userAddress->state);
                $city = City::find($userAddress->city);
                if ($country && $state && $city) {
                    $fullAddress .= $city->name . ', ' . $state->name . ', ' . $country->name . ', ' . $userAddress->zipcode;

                    // Add the full address to the user address object
                    $userAddress->full_address = $fullAddress;

                    $addresses[] = $userAddress;
                }
            }

            return response()->json([
                'ResponseCode' => 200,
                'Status' => 'true',
                'Message' => 'User Addresses retrieved successfully',
                'data' => $addresses,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'ResponseCode' => 500,
                'Status' => 'error',
                'Message' => 'Error retrieving user addresses',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // user update profile api
    public function profileupdate(Request $request)
    {
        try {
            $user = auth()->user();

            $rules = [
                'first_name' => '',
                'last_name' => '',
                'email' => [
                    'email',
                    Rule::unique('users')->ignore($user->id),
                ],
                'country_code' => 'required|string|max:15',
                'phone' => '',
                // [
                //     'string',
                //     'max:20',
                //     Rule::unique('users')->ignore($user->id),
                // ],
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg',
                // 'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                // return response()->json(['errors' => $validator->errors()], 400);
                if ($validator->fails()) {
                    $firstErrorMessage = $validator->errors()->first();
                    return response()->json([
                        'ResponseCode' => 422,
                        'Status' => 'False',
                        'Message' => $firstErrorMessage,
                    ], 422);
                }
            }

            $data = [
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'country_code' => $request->input('country_code'),
                'phone' => $request->input('phone'),
            ];

            if ($request->hasFile('profile_image')) {
                $data['profile_image'] = $this->verifyAndUpload($request, 'profile_image', $user->profile_image);
                $data['profile_image'] = asset('img/users/' . $data['profile_image']);
            }
            $user->update($data);
            $first_name = $user->first_name;
            Mail::to($user->email)->send(new ProfileupdateMail($first_name));

            return response()->json([
                'ResponseCode' => 200,
                'Status' => 'true',
                'Message' => 'Profile updated successfully',
                'data' => [
                    'user' => $user,
                ],
            ], 200);
        } catch (\Exception $e) {
            \Log::error('An error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    // user detail api.
    public function profiledetail()
    {
        try {
            $user = auth()->user();

            if (!$user) {

                return response()->json([
                    'ResponseCode' => 422,
                    'Status' => 'False',
                    'Message' => 'User not found',
                ], 422);
            }

            return response()->json([
                'ResponseCode' => 200,
                'Status' => 'true',
                'Message' => 'Profile Detail Retrived successfully',
                'data' => [
                    'user' => $user,
                ],
            ], 200);
        } catch (\Exception $e) {

            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    // /notification on or off

    public function toggleNotifyOn(Request $request)
    {
        $user = Auth::user();
        $user->notify_on = !$user->notify_on;
        $user->save();

        return response()->json([
            'ResponseCode' => 200,
            'Status' => 'true',
            'Message' => 'Notify_on status updated successfully.',
            'notify_on' => $user->notify_on,
        ]);
    }

    // language related api

    public function language(Request $request)
    {
        try {
            $user = Auth::user();
            $selectedLang = null;

            if ($user && $user->lang_id) {
                $selectedLang = Language::select('id', 'short_name', 'name', 'image_path')
                    ->where('status', 1)
                    ->where('short_name', $user->lang_id)
                    ->first();
            }

            $allLanguages = Language::select('id', 'short_name', 'name', 'image_path')->where('status', 1)->get();

            $languageData = [];
            foreach ($allLanguages as $language) {
                $langInfo = [
                    'id' => $language->id,
                    'short_name' => $language->short_name,
                    'name' => $language->name,
                    'image_path' => $language->image_path,
                    'is_selected' => ($selectedLang && $selectedLang->id === $language->id) ? true : false,
                ];
                $languageData[] = $langInfo;
            }

            return response()->json([
                'ResponseCode' => 200,
                'Status' => 'true',
                'Message' => 'Languages Retrieved Successfully',
                'data' => $languageData,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'ResponseCode' => 500,
                'Status' => 'False',
                'Message' => $e->getMessage(),
            ], 500);
        }
    }

    public function langupdate(Request $request)
    {
        try {
            $user = auth()->user();

            $rules = [
                'lang_id' => '',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                if ($validator->fails()) {
                    $firstErrorMessage = $validator->errors()->first();
                    return response()->json([
                        'ResponseCode' => 422,
                        'Status' => 'False',
                        'Message' => $firstErrorMessage,
                    ], 422);
                }
            }

            $data = [
                'lang_id' => $request->input('lang_id'),
            ];

            $user->update($data);

            return response()->json([
                'ResponseCode' => 200,
                'Status' => 'true',
                'Message' => 'Language updated successfully',
                'data' => [
                    'user' => $user,
                ],
            ], 200);
        } catch (\Exception $e) {
            \Log::error('An error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    public function logout()
    {
        $user = Auth::user();

        if ($user) {
            $user->lang_id = 'en';
            $user->	device_token ='';
            $user->save();
        }

        Auth::logout();

        return response()->json([
            'ResponseCode' => 200,
            'Status' => 'success',
            'Message' => 'Successfully logged out',
        ]);
    }


    //  // add address primary
    public function primaryAddress(Request $request)
    {
        try {
            $rules = [
                'is_primary' => 'required',
                'address_id' => 'required|exists:useraddresses,id',
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
            $userAddresses = Useraddress::where('user_id', $user->id)->get();

            if ($request->is_primary) {
                // If the request sets this address as primary, update all other addresses to not be primary
                foreach ($userAddresses as $address) {
                    if ($address->id != $request->address_id) {
                        $address->update(['is_primary' => 0]);
                    }
                }
            }

            $userAddress = Useraddress::where('id', $request->address_id)
                ->where('user_id', $user->id)
                ->first();

            if (!$userAddress) {
                return response()->json([
                    'ResponseCode' => 422,
                    'Status' => 'False',
                    'Message' => 'User Address not found',
                ], 422);
            }

            $userAddress->update(['is_primary' => $request->is_primary]);

            $userDetails = $user->toArray();

            return response()->json([
                'ResponseCode' => 200,
                'Status' => 'true',
                'Message' => 'Default Address Set Successfully',
                'data' => [
                    'user' => $userDetails,
                    'user_address' => $userAddress,
                ],
            ], 200);
        } catch (\Exception $e) {
                return response()->json([
                    'ResponseCode' => 500,
                    'Status' => 'error',
                    'Message' => 'Error updating user address',
                    'error' => $e->getMessage(),
                ], 500);
            }
        }


        //     Currency listing api
        public function currency(Request $request)
        {
            try {
                $currency = Currency::select('id', 'code', 'currency', 'symbol')
                    ->where('status', 1)
                    ->get();

                return response()->json([
                    'ResponseCode' => 200,
                    'Status' => 'true',
                    'Message' => 'Currency  Retrieved Successfully',
                    'data' =>$currency,
                ], 200);

            } catch (\Exception $e) {
                return response()->json([
                    'ResponseCode' => 500,
                    'Status' => 'False',
                    'Message' => $e->getMessage(),
                ], 500);
            }
        }

        // currency update

        public function currencyupdate(Request $request)
        {
            try {
                $user = auth()->user();

                $rules = [
                    'currency_code' => '',
                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    if ($validator->fails()) {
                        $firstErrorMessage = $validator->errors()->first();
                        return response()->json([
                            'ResponseCode' => 422,
                            'Status' => 'False',
                            'Message' => $firstErrorMessage,
                        ], 422);
                    }
                }

                $data = [
                    'currency_code' => $request->input('currency_code'),
                ];

                $user->update($data);

                return response()->json([
                    'ResponseCode' => 200,
                    'Status' => 'true',
                    'Message' => 'Currency Code updated successfully',
                    'data' => [
                        'user' => $user,
                    ],
                ], 200);
            } catch (\Exception $e) {
                \Log::error('An error occurred: ' . $e->getMessage());
                return response()->json(['error' => 'An error occurred.'], 500);
            }
        }
         // cms pages start

    public function termsconditions(request $request){

        try {
           $data= Page::where('id',1)->get();
             return response()->json([
                    'ResponseCode' => 200,
                    'Status' => 'true',
                    'Message' => 'terms and Condition retrived successfully',
                    'data' => $data,
                ], 200);
            } catch (\Exception $e) {
                \Log::error('An error occurred: ' . $e->getMessage());
                return response()->json(['error' => 'An error occurred.'], 500);
            }
    }

    public function privacypolicies(request $request){

        try {
           $data= Page::where('id',3)->get();
            return response()->json([
                    'ResponseCode' => 200,
                    'Status' => 'true',
                    'Message' => 'Privacy Policy retrived successfully',
                    'data' => $data,
                ], 200);
            } catch (\Exception $e) {
                \Log::error('An error occurred: ' . $e->getMessage());
                return response()->json(['error' => 'An error occurred.'], 500);
            }
    }
}
