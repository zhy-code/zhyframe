<?php

namespace App\Http\Controllers\Admin\Goods;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Config;
use Redirect;
use Session;
use App\Model\Goods;

class GoodsController extends Controller
{
	/*
	 * 列表
	 */
	public function index(Request $request, $id) {
		$model = Goods::orderBy('goods_id', 'desc');
		if ($request->has('goods_name')) {
			$model->where('goods_name', 'LIKE', '%'.$request->get('goods_name').'%');	
		}
        if ($request->has('store_name')) {
            $model->where('store_name', 'LIKE', '%'.$request->get('store_name').'%');
        }
        if ($request->has('goods_state')) {
            $model->where('goods_state', '!=', 1);
        }
		$result = $model->paginate(10);
		return View::make('admin.goods.goods_index', ['data' => $result]);
	}
	

	/*
	 * 违规下架
	 */
	public function editState(Request $request) {
		$data['goods_stateremark'] = $request->get('goods_stateremark');
		$data['goods_state'] = 10;
		$result = Goods::where(['goods_id' => $request->get('goods_id')])->update($data);
		$state = $result ? 200 : 0;
		return response()->json(['state' => $state]);
	}
	
}