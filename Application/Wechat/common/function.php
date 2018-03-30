<?php
	function checkStatus($status){
		if($status=="ordering"){
			return("待处理");
		}else if($status=="ordered"){
			return("已完成");
		}
		return("异常状态，请检查");
	}