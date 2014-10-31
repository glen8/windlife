<?php

/**
 * 图片水印扩展
 *
 * 用法：
 * @code php
 *
 * WLWaterMark::watermarkFromFile('images/009.jpg')->addImage('images/num2.jpg')->setPos('right', 'bottom')->save('images/test.jpg');
 * @endcode
 * + 选择要加水印的图片[009.jpg]
 * + 加入水印图片[num2.jpg]
 * + 设置水印 x y 位置值( 可为空,默认为左上角;支持百分比定位[ setPos('95%', ''95%'') ];支持直接设定位置[ setPos('100', ''100'') ]  )
 * + 设定生成图像保存位置
 *
 */
class WLWaterMark extends CComponent{
	// 图片位置
	public $fileDIR = '';
	public $ext2functions = array (
			2 => 'imagecreatefromjpeg',
			3 => 'imagecreatefrompng',
			1 => 'imagecreatefromgif' 
	);
	public $save2functions = array (
			1 => 'imagegif',
			2 => 'imagejpeg',
			3 => 'imagepng' 
	);
	
	// 图片gd对象
	public $imageGD;
	
	// 图片信息
	public $imageInfo = array ();
	
	// 存放一张水印图片
	public $ground = null;
	
	// 水印位置
	private $_pos = array (
			'x' => 0,
			'y' => 0 
	);
	
	/**
	 * 为图片加水印
	 * 
	 * @param <type> $fileDIR
	 *        	需要加水印的图片
	 * @return Helper_Image_Watermark
	 */
	static function watermarkFromFile($fileDIR) {
		$fileDIR = trim ( $fileDIR );
		
		if (file_exists ( $fileDIR )) {
			$ret = getimagesize ( $fileDIR );
			
			$wl_waterMark = new WLWaterMark ();
			
			$wl_waterMark->imageInfo ['width'] = $ret [0];
			$wl_waterMark->imageInfo ['height'] = $ret [1];
			$wl_waterMark->imageInfo ['type'] = $ret [2];
			$wl_waterMark->fileDIR = $fileDIR;
			
			try {
				$wl_waterMark->imageGD = call_user_func ( $Helper_Watermark->ext2functions [$ret [2]], $Helper_Watermark->fileDIR );
			} catch ( Exception $e ) {
				throw new Exception ( '暂不支持该文件格式', 01 );
			}
			
			return $wl_waterMark;
		}
		throw new Exception ( '需要加水印的图片不存在', 00 );
	}
	
	/**
	 * 加入图片作水印
	 * 
	 * @param string $fileDIR
	 *        	水印的图片
	 * @return Helper_Image_Watermark
	 */
	public function addImage($fileDIR) {
		$fileDIR = trim ( $fileDIR );
		
		if (file_exists ( $fileDIR )) {
			$ret = getimagesize ( $fileDIR );
			
			$this->ground ['info'] = array (
					'width' => $ret [0],
					'height' => $ret [1] 
			);
			
			try {
				$this->ground ['GD'] = call_user_func ( $this->ext2functions [$ret [2]], $fileDIR );
			} catch ( Exception $e ) {
				throw new Exception ( '暂不支持该文件格式', 03 );
			}
			
			return $this;
		}
		throw new Exception ( '图片不存在', 02 );
	}
	
	/**
	 * 调水印位置
	 * 
	 * @param <type> $x        	
	 * @param <type> $y
	 *        	$x , $y 支持 :
	 *        	+ left , center ,right 等定位
	 *        	+ 支持百分比定位
	 *        	+ 支持直接设定位置
	 *        	
	 * @return Helper_Image_Watermark
	 */
	public function setPos($x = 'right', $y = 'bottom') {
		$this->_pos = array (
				'x' => $this->_getPosValue ( 'width', $x ),
				'y' => $this->_getPosValue ( 'height', $y ) 
		);
		
		return $this;
	}
	
	/**
	 * 计算位置
	 * 
	 * @param <type> $param        	
	 * @return <type>
	 */
	private function _getPosValue($type = 'width', $param = 'right') {
		// 数字直接返回
		if (is_numeric ( $param ))
			return ( int ) $param;
			
			// 计算百分比
		if (strstr ( $param, '%' )) {
			$param = str_replace ( '%', '', $param );
			$param = ( int ) $param / 100;
			
			return ($this->imageInfo [$type] - $this->ground ['info'] [$type]) * $param;
		}
		
		// 计算方位定位
		switch ($param) {
			case 'right' :
			case 'bottom' :
				return $this->imageInfo [$type] - $this->ground ['info'] [$type];
			case 'left' :
				return 0;
			case 'center' :
				return ($this->imageInfo [$type] - $this->ground ['info'] [$type]) / 2;
			case 'top' :
				return 0;
			
			default :
				return 0;
		}
	}
	
	// 构造图片
	private function _build() {
		if (false == is_null ( $this->ground )) {
			imagealphablending ( $this->ground ['GD'], true );
			
			imagecopy ( $this->imageGD, $this->ground ['GD'], $this->_pos ['x'], $this->_pos ['y'], 0, 0, $this->ground ['info'] ['width'], $this->ground ['info'] ['height'] );
			
			imagedestroy ( $this->ground ['GD'] );
		}
	}
	
	/**
	 * 保存图片
	 * 
	 * @param <type> $filename        	
	 */
	public function save($filename = '') {
		$this->_build ();
		
		if (empty ( $filename )) {
			$filename = $this->fileDIR;
		}
		
		call_user_func ( $this->save2functions [$this->imageInfo ['type']], $this->imageGD, $filename, 100 );
		
		imagedestroy ( $this->imageGD );
	}
}
