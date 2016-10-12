<?php

namespace App\Http\Controllers\Admin\Goods;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Config;
use Redirect;
use Session;
use DB;
use App\Model\Type;
use App\Model\Spec;
use App\Model\Brand;
use App\Model\Attribute;


class TypeController extends Controller
{
	/*
	 * 列表
	 */
	public function index($id) {
		$result = Type::with('goodsclass')->paginate(10);
		return view('admin.goods.type_index', ['data' => $result]);
	}


	/*
	 * 新增
	 */
	public function create($id) {
		$result = $this->specBrand(0);
		return view('admin.goods.type_create', ['data' => $result]);
	}


	private function specBrand($type_id) {

		if ($type_id) {
			
			$resultSpec = Spec::with(array('typeSpec' => function($q) use ($type_id) {
				$q->where(['type_id' => $type_id]);
			}))->get();
			$resultBrand = Brand::with(array('typeBrand' => function($q) use ($type_id) {
				$q->where(['type_id' => $type_id]);
			}))->get();

		} else {
			$resultSpec = Spec::where(array('class_id' => 0))->get();
			$resultBrand = Brand::get();
		}
		
		return ['spec'=> $resultSpec, 'brand'=> $resultBrand];
	}


	/*
	 * 修改
	 */
	public function edit($id, $type_id) {
		$specBrandData = $this->specBrand($type_id);
		$result = Type::with('goodsclass')->where(array('type_id' => $type_id))->first();
		$skuData = Attribute::where(array('type_id' => $type_id))->get();
		return view('admin.goods.type_edit', ['data' => $result, 'specBrandData' => $specBrandData, 'skuData' => $skuData]);
	}


	/*
	 * 删除
	 */
	public function destroy(Request $request) {
		$result = Type::destroy($request->get('id'));
		$state = $result ? 200 : 0;
        return response()->json(['state' => $state]);
	}


	/*
	 * 存储
	 */
	public function store(Request $request) {
		$data = $request->all();
		$spId = $request->get('sp_id');
		$brandId = $request->get('brand_id');
		$attrArray = $request->get('attr_data');

		$dataType = array(
			'type_name' => $request->get('type_name'),
			'type_sort' => $request->get('type_sort'),
			'class_id' => $request->get('class_id'),
			);

		DB::beginTransaction();

		$type_id = DB::table('type')->insertGetId($dataType);
        if (!$type_id)
        {
            DB::rollBack();
            return Redirect::back();
        }

        if (!empty($spId))
        {
            foreach ($spId as $v) {
                $dataSpec[] = array(
                    'type_id'	=> $type_id,
                    'sp_id'		=> $v,
                );
            }
            $returnSpec = DB::table('type_spec')->insert($dataSpec);
            if (!$returnSpec)
            {
                DB::rollBack();
                return Redirect::back();
            }
        }
        if (!empty($brandId))
        {
            foreach ($brandId as $v) {
                $dataBrand[] = array(
                    'type_id'	=> $type_id,
                    'brand_id'	=> $v
                );
            }
            $returnBrand = DB::table('type_brand')->insert($dataBrand);
            if (!$returnBrand)
            {
                DB::rollBack();
                return Redirect::back();
            }
        }

        //var_dump($attrArray);die;
        if (!empty($attrArray))
        {
            foreach ($attrArray as $v) {
                $dataAttr = array(
                    'attr_name'	=>$v['attr_name'],
                    'type_id'	=>$type_id,
                    'attr_value'=>$v['attr_value'],
                    'attr_show'	=>$v['attr_show'] ? $v['attr_show'] : 0,
                    'attr_sort'	=>$v['attr_sort'],
                );
                $attrId = DB::table('attribute')->insertGetId($dataAttr);
                $attrValue = explode(',', $v['attr_value']);
                foreach ($attrValue as $vvv) {
                    $attrValueData[] = array('attr_value_name'=>$vvv,'attr_id'=>$attrId,'type_id'=>$type_id,'attr_value_sort'=>0);
                }
                $returnAttrValue = DB::table('attribute_value')->insert($attrValueData);
                $attrValueData = '';
                if (!$returnAttrValue)
                {
                    DB::rollBack();
                    return Redirect::back();
                }
            }
        }
        DB::commit();
        return Redirect::to('admin/type/index/'.Session::get('menu_id'));

	}


	/*
	 * 更新
	 */
	public function update(Request $request, $id) {
		$data = $request->all();
		$spId = $request->get('sp_id');
		$brandId = $request->get('brand_id');
		$attrArray = $request->get('attr_data');

		$dataType = array(
			'type_name' => $request->get('type_name'),
			'type_sort' => $request->get('type_sort'),
			'class_id' => $request->get('class_id'),
			);

		DB::beginTransaction();
		$resultType = DB::table('type')->where(['type_id' => $id])->update($dataType);
        if (!empty($spId)) {
            foreach ($spId as $v) {
                $dataSpec[] = array(
                    'type_id' => $id,
                    'sp_id' => $v,
                );
            }
            $deleteTypeSpec = DB::table('type_spec')->where('type_id', $id)->delete();
            $returnSpec = DB::table('type_spec')->insert($dataSpec);
            if (!$deleteTypeSpec && !$returnSpec)
            {
                DB::rollBack();
                return Redirect::back();
            }
        }
        if (!empty($brandId)) {
            foreach ($brandId as $v) {
                $dataBrand[] = array(
                    'type_id' => $id,
                    'brand_id' => $v
                );
            }
            $deleteTypeBrand = DB::table('type_brand')->where('type_id', $id)->delete();
            $returnBrand = DB::table('type_brand')->insert($dataBrand);
            if (!$deleteTypeBrand && !$returnBrand)
            {
                DB::rollBack();
                return Redirect::back();
            }
        }
        $deleteAttribute = DB::table('attribute')->where('type_id', $id)->delete();
        $deleteAttributeValue = DB::table('attribute_value')->where('type_id', $id)->delete();
        if (!empty($attrArray)) {
            foreach ($attrArray as $v) {
                $dataAttr = array(
                    'attr_name' => $v['attr_name'],
                    'type_id' => $id,
                    'attr_value' => $v['attr_value'],
                    'attr_show' => $v['attr_show'] ? $v['attr_show'] : 0,
                    'attr_sort' => $v['attr_sort'],
                );
                $returnAttrId = DB::table('attribute')->insertGetId($dataAttr);
                $attrValue = explode(',', $v['attr_value']);
                foreach ($attrValue as $vv) {
                    $attrValueData[] = array('attr_value_name'=>$vv,'attr_id'=>$returnAttrId,'type_id'=>$id,'attr_value_sort'=>0);
                }
                $returnAttrValue = DB::table('attribute_value')->insert($attrValueData);
                $attrValueData = '';
                if (!$returnAttrValue)
                {
                    DB::rollBack();
                    return Redirect::back();
                }
            }
        }
        DB::commit();
        return Redirect::to('admin/type/index/'.Session::get('menu_id'));
	}

}