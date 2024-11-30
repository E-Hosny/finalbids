<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductWishController extends Controller
{

    public function addToWishlist(Request $request)
    {
        if (Auth::check()) {
            $productId = $request->input('product_id');
            $userId = Auth::id();

            $existingWishlistItem = Wishlist::where('user_id', $userId)
                ->where('product_id', $productId)
                ->first();

            if ($existingWishlistItem) {
                Wishlist::where('user_id', Auth::id())->where('product_id', $productId)->delete();
            }

            // If not already in the wishlist, create a new entry
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId,
            ]);

            return response()->json(['message' => 'Product added to wishlist']);
        }

        return response()->json(['error' => 'User not authenticated'], 401);
    }

    public function removeFromWishlist(Request $request)
    {
        if (Auth::check()) {
            $productId = $request->input('product_id');

            Wishlist::where('user_id', Auth::id())->where('product_id', $productId)->delete();

            return response()->json(['message' => 'Product removed from wishlist']);
        }

        return response()->json(['error' => 'User not authenticated'], 401);
    }

    // public function addToWishlist(Request $request)
    // {
        
    //     $productId = $request->input('product_id');
    //     $userId = Auth::id();
    //     if (Auth::check()) {
    //         $wishlistdata = Wishlist::where([['product_id',$productId],['user_id',$userId]])->first();
    //         if (empty($wishlistdata)) {
    //             $wishlist = new Wishlist;
    //             $wishlist->user_id = $user->id;
    //             $wishlist->product_id = $productId;
    //             $wishlist->save();
    //         }

    //         $sign = '<i class="fa fa-heart" aria-hidden="true"></i>';

    //         $wish_data = '<img class="lke-icn1" onclick="remove_to_wish('.$productId.',this)" src="'.url('/public/frontend/').'/assets/img/union.svg"  alt="">';

    //         return response()->json([
    //             'status' => 1,
    //             'message' => 'Product add to wishlist successfully.',
    //             'wish_data' => $wish_data,
    //         ]);
            
    //     }else{
    //         return response()->json(['status' => 2,'msg' => 'Please Login First.']);
    //     }

    // }

    // public function removeFromWishlist(Request $request){
    //     $productId = $request->input('product_id');

    //     $user= Auth::id();
    //     $wishlist = Wishlist::where(['user_id'=>$user->id,'product_id'=>$productId])->first();
    //     $wishlist->delete();
    //     $wish_data = '<img class="lke-icn" onclick="add_to_wish('.$hotel_id.',this)" src="'.url('/public/frontend/').'/assets/img/like-icn.svg" alt="">';

    //     return response()->json(['status' => 1,
    //         'msg' => 'product Remove to wishlist successfully.',
    //         'wish_data' => $wish_data,

    //     ]);
    // }

}
