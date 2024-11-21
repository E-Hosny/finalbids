<?php
namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Product;
use App\Models\BidPlaced;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;


class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            // جلب المنتجات التي انتهى مزادها ولم تُغلق بعد
            $expiredProducts = Product::where('is_closed', false)
                ->where('auction_end_date', '<', now())
                ->get();

            foreach ($expiredProducts as $product) {
                // إغلاق المنتج
                $product->is_closed = true;
                $product->save();

                // جلب أعلى عرض في المزاد
                $highestBid = BidPlaced::where('product_id', $product->id)
                    ->orderBy('bid_amount', 'desc')
                    ->first();

                if ($highestBid) {
                    // إرسال الإشعارات
                    $this->notifyWinner($highestBid);

                    // تحديث حالة الإرسال
                    $highestBid->mail_sent = 1;
                    $highestBid->save();
                }
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    /**
     * Notify the winner via SMS and Email.
     */
    protected function notifyWinner($highestBid)
    {
        // // إرسال رسالة SMS
        // Http::post('https://api.taqnyat.sa/v1/messages', [
        //     'recipients' => $highestBid->user->phone,
        //     'body' => 'تهانينا! لقد فزت بالمزاد. يرجى متابعة البريد الإلكتروني لدفع القيمة.',
        //     'sender' => 'BID_SA',
        //     'api_key' => env('TAQNYAT_API_KEY'),
        // ]);
      
      /*  إرسال رسالة SMS */

        $client = new Client();
        $url = 'https://api.taqnyat.sa/v1/messages';

        $response = $client->post($url, [
            'headers' => [
                'Authorization' => 'Bearer c933affa6c2314484d105c45a0e1adc7',
            ],
            'json' => [
                // 'recipients' => [$phone],
              'recipients' => '966' . ltrim($highestBid->user->phone, '0'),
              'body' => 'تهانينا! لقد فزت بالمزاد. يرجى متابعة البريد الإلكتروني لدفع القيمة.',
               'sender' => 'MazadBid',
            ],
        ]);

        return $response->getStatusCode() == 200;
  

        // إرسال البريد الإلكتروني
        Mail::send('emails.winner', ['bid' => $highestBid], function ($message) use ($highestBid) {
            $message->to($highestBid->user->email)
                ->subject('تهانينا بفوزك بالمزاد')
                ->from('sales@bid.sa', 'Bid SA');
        });
    }
}
