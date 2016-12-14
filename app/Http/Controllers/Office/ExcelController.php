<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ExcelController extends Controller
{	
	function __construct(){
		require_once(app_path().'/Library/PHPExcel/PHPExcel.php');
	}
	
	/**
	 * 数据保存Excel 
	 * @parameter $dataArr   数据集    [二维数组]
	 * @parameter $titleArr  栏目名称  [一维数组]
	 * @parameter $titleArr  对应key值 [一维数组]
	 * @parameter $file_name 文件名    [字符串]
	 */
	public function saveToExcel($dataArr,$titleArr,$fieldArr,$file_name){
		$objPHPExcel = new \PHPExcel();
		
		$column_offset = 0; // 列偏移量
		$row_offset = 1;    // 行偏移量
		
		foreach($titleArr as $key => $title){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($key+$column_offset, $row_offset, $title);
		}
		for($i=0; $i<count($fieldArr); $i++){
			foreach($dataArr as $k => $data){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i+$column_offset, $row_offset+$k+1, $data->$fieldArr[$i]);
			}
		}
		
		//文件命名
		$date = date("Y_m_d",time());
		$fileName = $file_name."_{$date}.xlsx";
		$fileName = iconv("utf-8", "gb2312", $fileName);
		$objPHPExcel->setActiveSheetIndex(0);
		header('Content-Type: application/vnd.ms-excel');
		header("Content-Disposition: attachment;filename=\"$fileName\"");
		header('Cache-Control: max-age=0');
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		//文件下载
		//$objWriter->save(str_replace('.php', '.xlsx', $file_name.'.php'));
		$objWriter->save('php://output'); //文件通过浏览器下载
	}
	
	
	/**
	 * Excel数据转化为数组 
	 */
	function ExcelToArrary($fileurl,$filetype){
		$PHPExcel=new \PHPExcel();
		if(strtolower ( $filetype )=='xls'){
			$objReader = new \PHPExcel_Reader_Excel5;  
		}elseif(strtolower ( $filetype )=='xlsx'){  
			$objReader = new \PHPExcel_Reader_Excel2007;  
		}
		$objPHPExcel = $objReader->load($fileurl);  
		$objWorksheet = $objPHPExcel->getSheet(0);  //获取表中的第一个工作表
		$highestRow = $objWorksheet->getHighestRow();   //获取总行数
		$highestColumn = $objWorksheet->getHighestColumn(); //获取总列数
		$excelData = array();
		/**
		 * 此处根据具体情况设置，Excel 存放进入数组的起始位置
		 * 此示例 从 A1 开始读取存进数组
		 */
		for ($row = 1; $row <= $highestRow; $row++){
			for ($col = 'A'; $col <= $highestColumn; $col++){
				$excelData[$row][$col] =(string)$objWorksheet->getCell($col.$row)->getValue();
			}
		}
		return $excelData;  
	}  
	
}