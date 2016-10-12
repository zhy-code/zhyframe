<?php

namespace App\Http\Controllers\Admin\Order;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Config;
use Redirect;
use Session;
use DB;
use App\Model\Orders;

class OrderController extends Controller
{
	/*
	 * 订单列表
	 */
	public function index(Request $request, $id = null) {
		$model = Orders::orderBy('order_id', 'desc');
		if ($request->has('order_sn')) {
			$model->where('order_sn', $request->get('order_sn'));
		}
		$result = $model->paginate(10);

		return view('admin.order.order_index', ['orders' => $result]);
	}

	/*
	 * 退货列表
	 */
	public function returnGoods(Request $request, $id) {
		$model = Orders::orderBy('order_id', 'desc');
		if ($request->has('order_sn')) {
			$model->where('order_sn', $request->get('order_sn'));
		}
		$model = $model->where('service_state' , 1);
		$result = $model->paginate(10);

		return view('admin.order.order_return_goods', ['orders' => $result]);
	}

	/*
	 * 退款列表
	 */
	public function refund(Request $request, $id) {
		$model = Orders::orderBy('order_id', 'desc');
		if ($request->has('order_sn')) {
			$model->where('order_sn', $request->get('order_sn'));
		}
		$model = $model->where('service_state' , 2);
		$result = $model->paginate(10);
		return view('admin.order.order_refund', ['orders' => $result]);
	}


	/*
 * 订单详情
 */
	public function detail(Request $request, $id) {
        $orderGoods = Orders::with('orderGoods')->find($id);
		return view('admin.order.order_detail', ['orderGoods' => $orderGoods]);
	}

}