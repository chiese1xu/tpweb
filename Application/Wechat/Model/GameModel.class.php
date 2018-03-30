<?php
namespace Wechat\Model;
use Think\Model;
class GameModel {
	public function getWR($v,$r,$m=100,$c=8){
		$wr = ($v /($v+$m+0.0))*$r+($m/($v+$m+0.0))*$c;
		return $wr;
	}
	
}

