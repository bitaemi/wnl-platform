<?php

namespace App\Http\Controllers\Ajax;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentAjaxController extends Controller
{
	private $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function setPaymentMethod()
	{
		$sessionId = $this->request->get('sess_id');
		$method = $this->request->get('payment');

		$order = Order::where(['session_id' => $sessionId])->update(['method' => $method]);

		if (!$order) {
			return response()->json(['status' => 'not_found'], 404);
		}

		return response()->json(['status' => 'success']);
	}

	public function checkOrderPaymentStatus()
	{
		$orderId = $this->request->get('orderId');
		$order = Order::find($orderId);

		if (!$order) {
			return response()->json(['status' => 'not_found'], 404);
		}

		return response()->json([
			'status'     => 'success',
			'orderPaid' => $order->paid,
		]);
	}
}
