<?php

namespace App\Http\Controllers;

use MyFatoorah\Library\PaymentMyfatoorahApiV2;
use Illuminate\Http\Request;
use App\Models\BidPlaced;

class MyFatoorahController extends Controller {

    public $mfObj;

//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     * create MyFatoorah object
     */

    public function __construct()
{
    $this->mfObj = new PaymentMyfatoorahApiV2(
        config('myfatoorah.api_key'),
        config('myfatoorah.country_iso'),
        config('myfatoorah.test_mode')
    );
}

//-----------------------------------------------------------------------------------------------------------------------------------------
   /**
     * create MyFatoorah Invoice
     */
public function index(Request $request)
{
    try {
        $paymentMethodId = 0; // 0 لفاتورة MyFatoorah أو 1 لـ Knet في وضع الاختبار
        $bidPlaceId = $request->input('bid_place_id');
        if (!$bidPlaceId) {
            return back()->with('error', 'لم يتم تقديم معلومات العطاء بشكل صحيح.');
        }
        $curlData = $this->getPayLoadData($bidPlaceId);
        $data = $this->mfObj->getInvoiceURL($curlData, $paymentMethodId);
        if ($data && isset($data['invoiceURL'])) {
            return redirect($data['invoiceURL']);
        } else {
            return back()->with('error', 'حدث خطأ أثناء إنشاء فاتورة الدفع.');
        }
    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }
}

//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     *
     * @param int|string $orderId
     * @return array
     */

	private function getPayLoadData($bidPlaceId)
	{
		$callbackURL = route('myfatoorah.callback');
		$bidPlaced = BidPlaced::with(['user', 'product'])->findOrFail($bidPlaceId);

		$paymentUrl = config('myfatoorah.test_mode')
			? config('myfatoorah.test_payment_url')
			: config('myfatoorah.live_payment_url');

		return [
			'CustomerName'       => $bidPlaced->user->first_name . ' ' . $bidPlaced->user->last_name,
			'InvoiceValue'       => $bidPlaced->bid_amount,
			'DisplayCurrencyIso' => config('myfatoorah.currency'),
			'CustomerEmail'      => $bidPlaced->user->email,
			'CallBackUrl'        => $callbackURL,
			'ErrorUrl'           => $callbackURL,
			'MobileCountryCode'  => config('myfatoorah.countrycode'),
			'CustomerMobile'     => $bidPlaced->user->phone,
			'Language'           => session('locale') == 'ar' ? 'ar' : 'en',
			'CustomerReference'  => $bidPlaced->id,
			'SourceInfo'         => 'Laravel ' . app()::VERSION . ' - MyFatoorah Package ' . MYFATOORAH_LARAVEL_PACKAGE_VERSION,
			'PaymentUrl'         => $paymentUrl,
		];
	}
//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     * Get MyFatoorah payment information
     *
     * @return \Illuminate\Http\Response
     */

	public function callback(Request $request)
	{
		try {
			$paymentId = $request->input('paymentId');
			$data = $this->mfObj->getPaymentStatus($paymentId, 'PaymentId');

			if ($data->InvoiceStatus == 'Paid') {
				// Search for the record in the database using multiple fields
				$bidPlaced = BidPlaced::where('myfatoorah_payment_id', $paymentId)
					->orWhere([
						'user_id' => $data->CustomerReference,
						'product_id' => $data->CustomerReference,
						'total_amount' => $data->InvoiceValue,
					])
					->first();

				if ($bidPlaced) {
					$bidPlaced->update([
						'payment_status' => 'paid',
						'myfatoorah_payment_id' => $paymentId, // Update the myfatoorah_payment_id field
						'myfatoorah_invoice_reference' => $data->InvoiceReference,
						'myfatoorah_invoice_id' => $data->InvoiceId,
						'payment_data' => json_encode($data),
						'paid_at' => now(),
					]);

					if (session('locale') == 'ar') {
						return redirect()->route('auction')->with('success', 'تم دفع الفاتورة بنجاح.');
					} else {
						return redirect()->route('auction')->with('success', 'Invoice paid successfully.');
					}
				} else {
					if (session('locale') == 'ar') {
						return response()->json(['IsSuccess' => 'false', 'Message' => 'لم يتم العثور على سجل مطابق.']);
					} else {
						return response()->json(['IsSuccess' => 'false', 'Message' => 'No matching record found.']);
					}
				}
			} else {
				if (session('locale') == 'ar') {
					return response()->json(['IsSuccess' => 'false', 'Message' => 'لم يتم دفع الفاتورة.']);
				} else {
					return response()->json(['IsSuccess' => 'false', 'Message' => 'Invoice is not paid.']);
				}
			}
		} catch (\Exception $e) {
			if (session('locale') == 'ar') {
				return response()->json(['IsSuccess' => 'false', 'Message' => $e->getMessage()]);
			} else {
				return response()->json(['IsSuccess' => 'false', 'Message' => $e->getMessage()]);
			}
		}
	}

//-----------------------------------------------------------------------------------------------------------------------------------------
}
