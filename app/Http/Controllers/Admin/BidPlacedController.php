<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\BidPlacedDataTable;
use App\Models\BidPlaced;


class BidPlacedController extends Controller
{
    public function index(BidPlacedDataTable $dataTable)
    {
        // dd($dataTable->render('admin.bid_placed.index'));

        return $dataTable->render('admin.bid_placed.index');
    }

//     public function index(BidPlacedDataTable $dataTable)
// {
//     $data = BidPlaced::with(['user', 'product', 'auctiontype', 'project'])->get();
//     dd($data); // عرض البيانات
// }

    // public function updateStatus(Request $request)
    // {
    //     $bidPlaced = BidPlaced::find($request->id);
    //     if (!$bidPlaced) {
    //         return response()->json(['message' => 'Not found'], 404);
    //     }
    //     $bidPlaced->status = $request->status;
    //     $bidPlaced->save();

    //     return response()->json(['message' => 'Status updated successfully']);
    // }

    // public function updateStatus(Request $request)
    // {
    //     $bidPlacedId = $request->input('bid_request_id');
    //     $status = $request->input('status');
    
    //     $bidPlaced = BidPlaced::find($bidPlacedId);
    
    //     if (!$bidPlaced) {
    //         return response()->json(['success' => false, 'message' => 'Bid request not found.']);
    //     }
    
    //     $bidPlaced->status = $status;
    //     $bidPlaced->save();
    
    //     $message = $status == 1 ? 'Bid request approved successfully.' : 'Bid request declined successfully.';
    
    //     return response()->json(['success' => true, 'message' => $message]);
    // }
    
    // public function updateStatus(Request $request)
    // {
    //     $bidPlacedId = $request->input('bid_request_id');
    //     $status = $request->input('status');
    
    //     $bidPlaced = BidPlaced::find($bidPlacedId);
    
    //     if (!$bidPlaced) {
    //         return response()->json(['success' => false, 'message' => 'Bid request not found.']);
    //     }
    
    //     $bidPlaced->status = $status;
    //     $bidPlaced->save();
    
    //     $message = $status == 1 ? 'Bid request approved successfully.' : 'Bid request Reject successfully.';
    
    //     return response()->json(['success' => true, 'message' => $message]);
    // }
    
    public function updateStatus(Request $request)
{
    $bidPlacedId = $request->input('bid_request_id');
    $status = $request->input('status');

    $bidPlaced = BidPlaced::find($bidPlacedId);

    if (!$bidPlaced) {
        return response()->json(['success' => false, 'message' => 'Bid request not found.']);
    }

    // التحقق من صحة قيمة الحالة
    if (!in_array($status, [0, 1, 2])) {
        return response()->json(['success' => false, 'message' => 'Invalid status value.']);
    }

    $bidPlaced->status = $status;
    $bidPlaced->save();

    // تعيين الرسالة بناءً على الحالة
    if ($status == 1) {
        $message = 'Bid request approved successfully.';
    } elseif ($status == 2) {
        $message = 'Bid request rejected successfully.';
    } else {
        $message = 'Bid request set to pending.';
    }

    return response()->json(['success' => true, 'message' => $message]);
}



}

