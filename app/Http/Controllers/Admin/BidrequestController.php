<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\BidRequestDataTable;
use App\Models\BidRequest;
use App\Models\Notification;
use App\Models\User;
use App\Models\Appnotification;




class BidrequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BidRequestDataTable $dataTable)
    {
        return $dataTable->render('admin.bidrequest.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $user = BidRequest::find($id);
        if ($user) {
            $user->delete();
            return redirect()->back()->with('success', 'Bid request deleted successfully.');
        } else {
            return response()->json(['message' => 'BidRequest not found'], 404);
        }
        // $bidRequest->delete();
        // return redirect()->back()->with('success', 'Bid request deleted successfully.');

    }


    public function updateStatus(Request $request)
    {
        $bidRequestId = $request->input('bid_request_id');
        $status = $request->input('status');

        $bidRequest = BidRequest::find($bidRequestId);

        if (!$bidRequest) {
            return response()->json(['success' => false, 'message' => 'Bid Request not found']);
        }
        $bidRequest->status = ($status == 1) ? true : false;
        $bidRequest->save();
        // If status is approved (1), send a notification to the user
            if ($status == 1) {
                $notification_msg = 'Congratulations! Your Bid request has been approved. Now you can participate in auction';

                $firebaseToken = User::where('id', $bidRequest->user_id)->where('notify_on',1)->whereNotNull('device_token')->pluck('device_token')->first();

                if ($firebaseToken) {
                    Controller::apiNotificationForApp($firebaseToken, 'Bid', 'default_sound.mp3', $notification_msg, null);
                }

                $notification = new Notification();
                $notification->type = 'Approve Bid Request From admin';
                $notification->title = 'Approve Bid Request From admin';
                $notification->sender_id = auth()->id();
                $notification->receiver_id = $bidRequest->user_id;
                $notification->message = $notification_msg;
                $notification->project_id =$bidRequest->project_id;
                $notification->save();

                $appnotification = new Appnotification();
                $appnotification->title = 'Approve Bid Request From admin';
                $appnotification->user_id = auth()->id();
                $appnotification->message = $notification_msg;
                $appnotification->project_id =$bidRequest->project_id;
                $appnotification->save();
            }

        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }
}
