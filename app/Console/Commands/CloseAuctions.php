<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\BidPlaced;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Mail\AuctionWinnerAdminMail;
use App\Mail\AuctionWinnerUserMail;
use Carbon\Carbon;

class CloseAuctions extends Command
{
    protected $signature = 'auctions:close';

    protected $description = 'Close auctions whose end date has passed and process the winners.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $products = Product::where('status', 'open')
            ->where('auction_end_date', '<=', Carbon::now())
            ->get();

        foreach ($products as $product) {
            try {
                $bids = BidPlaced::where('product_id', $product->id)
                    ->where('status', 1)
                    ->get();

                if ($bids->isEmpty()) {
                    Log::info('No bids found for product', [
                        'product_id' => $product->id,
                    ]);
                    $product->status = 'closed';
                    $product->save();
                    continue;
                }

                $highestBid = $bids->sortByDesc('bid_amount')->first();
                $highestBid->status = 3;
                $highestBid->save();

                $winningUser = $highestBid->user;

                if (!$winningUser) {
                    Log::error('Winning user not found', [
                        'user_id' => $highestBid->user_id,
                    ]);
                    continue;
                }

                $adminEmail = env('ADMIN_EMAIL', 'ebrahimhosny511@gmail.com');
                $logData = [
                    'product' => [
                        'product_id' => $product->id,
                        'product_title' => $product->title,
                        'product_status' => $product->status,
                        'auction_end_date' => $product->auction_end_date,
                    ],
                    'winning_user' => [
                        'user_id' => $winningUser->id,
                        'user_name' => $winningUser->first_name,
                        'user_email' => $winningUser->email,
                        'user_phone' => $winningUser->phone,
                    ],
                    'winning_bid' => [
                        'amount' => $highestBid->bid_amount,
                    ],
                    'admin_email' => $adminEmail,
                ];

                Log::info('Auction closure details:', $logData);

                $product->status = 'closed';
                $product->save();

                Mail::to($adminEmail)->send(new AuctionWinnerAdminMail([
                    'winner_name' => $winningUser->first_name,
                    'product_title' => $product->title,
                    'product_image' => $product->image_path ?? 'No Image',
                    'winning_amount' => $highestBid->bid_amount,
                    'auction_end_date' => $product->auction_end_date,
                    'winner_email' => $winningUser->email,
                    'winner_phone' => $winningUser->phone,
                ]));

                Mail::to($winningUser->email)->send(new AuctionWinnerUserMail([
                    'name' => $winningUser->first_name,
                    'product_title' => $product->title,
                    'product_image' => $product->image_path ?? 'No Image',
                    'winning_amount' => $highestBid->bid_amount,
                    'auction_end_date' => $product->auction_end_date,
                    'payment_link' => route('myfatoorah.pay', ['bid_place_id' => $highestBid->id]),
                ]));

                $this->sendSMS($winningUser->phone, "تهانينا! لقد فزت بمزاد {$product->title}. تحقق من بريدك للمزيد.");

            } catch (\Exception $e) {
                Log::error('Error in auction closure', [
                    'product_id' => $product->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    private function sendSMS($phone, $message)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post('https://api.taqnyat.sa/v1/messages', [
                'headers' => [
                    'Authorization' => 'Bearer c933affa6c2314484d105c45a0e1adc7',
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'recipients' => '966' . ltrim($phone, '0'),
                    'body' => $message,
                    'sender' => 'MazadBid',
                ],
            ]);

            Log::info('SMS sent successfully', [
                'recipients' => '966' . ltrim($phone, '0'),
                'status' => $response->getStatusCode(),
            ]);
        } catch (\Exception $e) {
            Log::error('Error sending SMS', [
                'recipients' => '966' . ltrim($phone, '0'),
                'error' => $e->getMessage(),
            ]);
        }
    }
}
