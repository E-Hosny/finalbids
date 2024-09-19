<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use App\Models\BidPlaced;
use DateTime;
use DateTimeZone;
use App\Mail\WinnerMail;
use App\Mail\notwinnerMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Gallery;
use App\Models\Notification;







class WinnerCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:winner';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Update bid statuses for expired auctions';
    /**
     * Execute the console command.
     */
    public function handle()
    {
        // \Log::info("Cron is working fine!"); 
        $currentDateTimeUTC = new DateTime('now');
        $currentDateTimeUTC->setTimezone(new DateTimeZone('Asia/Kolkata'));
        $formattedDateTime = $currentDateTimeUTC->format('Y-m-d H:i:s');
        $auctiontypeid = 2;
       

        $expiredBids = BidPlaced::whereHas('product', function ($query) use ( $formattedDateTime) {
            $query->where('auction_end_date', '<=',  $formattedDateTime);
        })->get();

        $updateliveBids = BidPlaced::whereHas('product', function ($query) use ( $auctiontypeid) {
            $query->where('auction_type_id', $auctiontypeid); 
        })->get();
        
        foreach ($expiredBids as $bid) {
            $productId = $bid->product_id;
            $highestBid = BidPlaced::where('product_id', $productId)->orderByDesc('bid_amount')->first();

            if ($highestBid) {
                $highestBid->update(['status' => 2]);
            }
        }
       
        foreach ($updateliveBids as $bids) {
            $product = $bids->product;
    
            if ($auctiontypeid == 2 && $bids->bid_amount >= $product->minsellingprice) {
                // Update status to 2
                $bids->update(['status' => 2]);
    
                // Send Winner mail if mail not already sent
                if (!$bids->mail_sent) {
                    $user = User::find($bids->user_id);
                    $first_name = $user->first_name;
                    $product_name = $product->title;
                    $product_image = Gallery::where('lot_no', $product->lot_no)->orderBy('id')->value('image_path');
                    $bid_amount = $bids->bid_amount;
                    $auction_end_time = $product->project->end_date_time;
                    // Mail::to($user->email)->send(new WinnerMail($first_name, $product_name, $product_image, $bid_amount, $auction_end_time));
    
                    $bids->update(['mail_sent' => 1]);
                     // $notificationMessage = 'You are a winner for this product.';
                    // $firebaseToken = User::where('id', $user->id)->whereNotNull('device_token')->pluck('device_token')->first();

                    // if ($firebaseToken) {
                    //     Controller::apiNotificationForApp($firebaseToken, 'Bid', 'default_sound.mp3', $notificationMessage, null);
                    // }
                
                    // $notification = new Notification();
                    // $notification->type = 'You won This Auction';
                    // $notification->title = 'You won This Auction';
                    // $notification->sender_id = $user->id;
                    // $notification->receiver_id = $user->id;
                    // $notification->message = $notificationMessage;
                    // $notification->product_id = $bids->product_id;
                    // $notification->project_id = $bids->project_id;
                    // $notification->save();
                }
            } else {
                // Update status to 1 (Not winner)
                $bids->update(['status' => 1]);
    
                // Send Not Winner mail if mail not already sent
                if (!$bids->mail_sent) {
                    $user = User::find($bids->user_id);
                    $first_name = $user->first_name;
                    $product_name = $product->title;
                    $product_image = Gallery::where('lot_no', $product->lot_no)->orderBy('id')->value('image_path');
                    $bid_amount = $bids->bid_amount;
                    $auction_end_time = $product->project->end_date_time;
                    // Mail::to($user->email)->send(new NotWinnerMail($first_name, $product_name, $product_image, $bid_amount, $auction_end_time));
    
                    $bids->update(['mail_sent' => 1]);
                }
            }
        }
   
        
        $this->info('WinnerCron executed successfully!');
    }
    
}
