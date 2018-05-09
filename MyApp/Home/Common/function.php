<?php
/**批量修改数据
* @param $saveWhere ：想要更新主键ID数组
* @param $saveData ：想要更新的ID数组所对应的数据
* @param $tableName : 想要更新的表名
* @param $saveWhere : 返回更新成功后的主键ID数组
* */
function save_all($saveWhere,&$saveData,$tableName){
    if($saveWhere==null||$tableName==null)
        return false;
/*获取更新的主键id名称*/
    $key = array_keys($saveWhere)[0];
/*获取更新列表的长度*/
    $len = count($saveWhere[$key]);
    $flag=true;
    $model = isset($model)?$model:M($tableName);
/*开启事务处理机制*/
    $model->startTrans();
/*记录更新失败ID*/
    $error=[];
    for($i=0;$i<$len;$i++){
/*预处理sql语句*/
        $isRight=$model->where($key.'='.$saveWhere[$key][$i])->save($saveData[$i]);
        if($isRight==0){
/*将更新失败的记录下来*/
            $error[]=$i;
            $flag=false;
        }
/*//$flag=$flag&&$isRight;*/
    }
    if($flag ){
/*//如果都成立就提交*/
        $model->commit();
        return $saveWhere;
    }elseif(count($error)>0&count($error)<$len){
/*//先将原先的预处理进行回滚*/
        $model->rollback();
        for($i=0;$i<count($error);$i++){
/*//删除更新失败的ID和Data*/
            unset($saveWhere[$key][$error[$i]]);
            unset($saveData[$error[$i]]);
        }
/*//重新将数组下标进行排序*/
        $saveWhere[$key]=array_merge($saveWhere[$key]);
        $saveData=array_merge($saveData);
/*//进行第二次递归更新*/
        $this->save_all($saveWhere,$saveData,$tableName);
        return $saveWhere;
    }
    else{
/*//如果都更新就回滚*/
        $model->rollback();
        return false;
    }
}

/**清除缓存文件夹
 * @param mixed|string $path      文件夹
 * */
function deleteAll($path)
{
    if (file_exists($path)) {
        $op = dir($path);
        while (false != ($item = $op->read())) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            if (is_dir($op->path . '/' . $item)) {
                deleteAll($op->path . '/' . $item);
                rmdir($op->path . '/' . $item);
            } else {
                unlink($op->path . '/' . $item);
            }
        }
    }
}

/*图片数组*/
function imgArray(){
    $imgids = array(
        '9000'=>'APP引导图',
        '10000'=>'首页广告',
        '20000'=>'装修背景图',
        '21000'=>'找人装修',
        '22000'=>'装修报价',
        '22100'=>'装修报价顶部',
        '23000'=>'效果图',
        '24000'=> '图标采购',
        '30000'=> '背景图',
        '31000'=> '简单维修',
        '31100'=>'顶部轮播图',
        '31200'=>'家装背景图',
        '31300'=>'工装背景图',
        '31400'=>'家装图',
        '31500'=>'工装图',
        '32000'=>'维修需求'
    );
    return $imgids;
}
/*图片数组*/
function imgArrays(){
    $imgids = array(
        '1'=>'首页轮播图',
        '2'=>'工程队',
        '3'=>'商城',
        '4'=>'案例',
        '5'=>'设计师',
        '6'=>'关于崇迈',
        '7'=>'招商加盟',
        '8'=>'联系我们',
        '9'=>'服务保障'
    );
    return $imgids;
}
/*单页类型*/
function singlepageType(){
    $typeids = array(
        '1'=>'关于我们',
        '2'=>'联系我们',
        '3'=>'招商加盟',
        '4'=>'施工队',
        '5'=>'下载APP',
        '6'=>'服务保障'
    );
    return $typeids;
}

/**
 * 数组转xls格式的excel文件
 * @param  array  $data      需要生成excel文件的数组
 * @param  string $filename  生成的excel文件名
 *      示例数据：
$data = array(
array(NULL, 2010, 2011, 2012),
array('Q1',   12,   15,   21),
array('Q2',   56,   73,   86),
array('Q3',   52,   61,   69),
array('Q4',   30,   32,    0),
);
 */
function create_xls($data,$filename='simple.xls'){

    ini_set('max_execution_time', '0');
    vendor("PHPExcels.PHPExcel");
    $filename=str_replace('.xls', '', $filename).'.xls';
    $filename = iconv("utf-8", "gb2312", $filename);
    $phpexcel = new \PHPExcel();
    $phpexcel->getProperties()
        ->setCreator("Maarten Balliauw")
        ->setLastModifiedBy("Maarten Balliauw")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");
    // 设置个表格宽度
    $phpexcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
    $phpexcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
    $phpexcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
    $phpexcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
    $phpexcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
    $phpexcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
    $phpexcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
    $phpexcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
    $phpexcel->getActiveSheet()->getColumnDimension('I')->setWidth(21);
    $phpexcel->getActiveSheet()->getColumnDimension('J')->setWidth(21);

    // 水平居中（位置很重要，建议在最初始位置）
    $phpexcel->setActiveSheetIndex(0)->getStyle('A')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('B')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('C')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('D')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('E')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('F')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('G')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('H')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('I')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('J')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//    设置单元格的值
    $phpexcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
    $phpexcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

    $phpexcel->getActiveSheet()->fromArray($data);
    $phpexcel->getActiveSheet()->setTitle('Sheet1');
    $phpexcel->setActiveSheetIndex(0);
    ob_end_clean();
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;filename=$filename");
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0
    $objwriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel5');
    $objwriter->save('php://output');
    exit;
}
function createtixian_xls($data,$filename='simple.xls'){

    ini_set('max_execution_time', '0');
    vendor("PHPExcels.PHPExcel");
    $filename=str_replace('.xls', '', $filename).'.xls';
    $filename = iconv("utf-8", "gb2312", $filename);
    $phpexcel = new \PHPExcel();
    $phpexcel->getProperties()
        ->setCreator("Maarten Balliauw")
        ->setLastModifiedBy("Maarten Balliauw")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");
    // 设置个表格宽度
    $phpexcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
    $phpexcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
    $phpexcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
    $phpexcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
    $phpexcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
    $phpexcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
    $phpexcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
    $phpexcel->getActiveSheet()->getColumnDimension('H')->setWidth(21);
    $phpexcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
    $phpexcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
    $phpexcel->getActiveSheet()->getColumnDimension('K')->setWidth(18);

    // 水平居中（位置很重要，建议在最初始位置）
    $phpexcel->setActiveSheetIndex(0)->getStyle('A')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('B')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('C')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('D')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('E')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('F')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('G')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('H')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('I')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('J')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('K')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//    设置单元格的值
    $phpexcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

    $phpexcel->getActiveSheet()->fromArray($data);
    $phpexcel->getActiveSheet()->setTitle('Sheet1');
    $phpexcel->setActiveSheetIndex(0);
    ob_end_clean();
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;filename=$filename");
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0
    $objwriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel5');
    $objwriter->save('php://output');
    exit;
}
function createpay_xls($data,$filename='simple.xls'){

    ini_set('max_execution_time', '0');
    vendor("PHPExcels.PHPExcel");
    $filename=str_replace('.xls', '', $filename).'.xls';
    $filename = iconv("utf-8", "gb2312", $filename);
    $phpexcel = new \PHPExcel();
    $phpexcel->getProperties()
        ->setCreator("Maarten Balliauw")
        ->setLastModifiedBy("Maarten Balliauw")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");
    // 设置个表格宽度
    $phpexcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
    $phpexcel->getActiveSheet()->getColumnDimension('B')->setWidth(21);
    $phpexcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    $phpexcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
    $phpexcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    $phpexcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
    $phpexcel->getActiveSheet()->getColumnDimension('G')->setWidth(21);
    $phpexcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
    $phpexcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
    $phpexcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
    $phpexcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);


    // 水平居中（位置很重要，建议在最初始位置）
    $phpexcel->setActiveSheetIndex(0)->getStyle('A')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('B')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('C')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('D')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('E')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('F')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('G')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('H')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('I')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('J')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('H')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 //    设置单元格的值格式
    $phpexcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

    $phpexcel->getActiveSheet()->fromArray($data);
    $phpexcel->getActiveSheet()->setTitle('Sheet1');
    $phpexcel->setActiveSheetIndex(0);
    ob_end_clean();
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;filename=$filename");
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0
    $objwriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel5');
    $objwriter->save('php://output');
    exit;
}
function createservicedemand_xls($data,$filename='simple.xls'){

    ini_set('max_execution_time', '0');
    vendor("PHPExcels.PHPExcel");
    $filename=str_replace('.xls', '', $filename).'.xls';
    $filename = iconv("utf-8", "gb2312", $filename);
    $phpexcel = new \PHPExcel();
    $phpexcel->getProperties()
        ->setCreator("Maarten Balliauw")
        ->setLastModifiedBy("Maarten Balliauw")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");
    // 设置个表格宽度
    $phpexcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
    $phpexcel->getActiveSheet()->getColumnDimension('B')->setWidth(21);
    $phpexcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    $phpexcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
    $phpexcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    $phpexcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
    $phpexcel->getActiveSheet()->getColumnDimension('G')->setWidth(21);
    $phpexcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
    $phpexcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
    $phpexcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);

    // 水平居中（位置很重要，建议在最初始位置）
    $phpexcel->setActiveSheetIndex(0)->getStyle('A')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('B')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('C')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('D')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('E')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('F')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('G')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('H')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('I')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $phpexcel->setActiveSheetIndex(0)->getStyle('J')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
   //    设置单元格的值格式
    $phpexcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
    $phpexcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

    $phpexcel->getActiveSheet()->fromArray($data);
    $phpexcel->getActiveSheet()->setTitle('Sheet1');
    $phpexcel->setActiveSheetIndex(0);
    ob_end_clean();
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;filename=$filename");
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0
    $objwriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel5');
    $objwriter->save('php://output');
    exit;
}


