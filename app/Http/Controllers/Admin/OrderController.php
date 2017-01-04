<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Pay\WxPayRefundController as WxRefund;
use App\Http\Controllers\Sms\AliSmsController as AliSms;

use View;
use Session;
use Redirect;
use App\Model\Order;

class OrderController extends Controller
{
	/**
	 * 后台订单列表
	 */
	public function orderList()
	{
		$order_list = Order::get()->toArray();
		$order_list_json = json_encode($order_list);
		return View::make('admin.order.orderlist', ['orderlist'=>$order_list_json]);
	}
	
	/**
	 * 后台订单备注
	 */
	public function toOrderRemark(Request $request)
	{
        $id = $request->get('id');
        $re = Order::where('order_id',$id)->update(['order_remark'=>$request->get('content')]);
        if ($re) {
            $jsonData = [
                'status'  => '1',
                'message' => '备注成功',
            ];
        } else {
            $jsonData = [
                'status'  => '0',
                'message' => '备注失败',
            ];
        }
        return response()->json($jsonData);
	}

    /**
     * 后台订单详情
     */
    public function orderDetails($orderid)
    {
        $order_info = Order::where('order_id',$orderid)->first();
        return View::make('admin.order.orderdetails', ['orderinfo'=>$order_info]);
    }

}