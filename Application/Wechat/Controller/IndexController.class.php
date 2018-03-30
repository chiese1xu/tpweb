<?php
namespace Wechat\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
		$access_token = $this->getToken();
		echo('$access_token ='.$access_token);	
	}
	
	public function math(){
		//wr 加权分
		//v 人数
		//R 平均分
		//m 最小人数
		//c 所有数据平均分
		//new \Home\Model\UserModel()
		$gh = new \Wechat\Model\GameModel();
		$the7 = new \Wechat\Model\GameModel();
		//public function getWR($v,$r,$m=100,$c=5)
		$gh_score = $gh->getWR(1000,8);
		$the7_score = $gh->getWR(20,10);
		echo("gh_score=".$gh_score."<br>");
		echo("the7_score=".$the7_score."<br>");
	}
	
	public function showorder(){
		$order = M('t_order');
		$orderList = $order->select();
		//var_dump($orderList);
		$this->assign('orderList',$orderList);
		$this->display();
	}
	
	public function ntest(){
		$data = S('data');
		if($data==null||$data==""){
			$data = rand(1,100);
			S('data',$data,5);
		}
		echo("data=".$data);
	}
	
	public function getData(){
		
	}
	
	public function getPicUrl(){
		//https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token=ACCESS_TOKEN
		$access_token="8_jD4uyQc-O7FqY0ZCIInpbY1zmjOut0GUNQTWs7Wrccu0UJYBH0Ihk1CxfyREy_ZQqSm7uxMAqn_rzc5tXLjuqbvt2XkFvZoMaALGWw6L8pW7d4ka3Pazqu8iY7hojTD9eiV9j6EAe9gbZiV3FCRdAFAIFU";
		$filedata = array("media"=>"@'/Public/0.jpg'");
		
		$img_data='{
			 "touser":"'.$openid.'",
			 "msgtype":"image",
			 "image":
			 {
			   "media_id":"'.$media_id.'"
			 }
			}';
		$result = post($a_url,$img_date);

		$ch = curl_init();  
		curl_setopt($ch, CURLOPT_URL,"http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=".$access_token);  
		curl_setopt($ch, CURLOPT_POST, 1 );
		curl_setopt($ch, CURLOPT_POSTFIELDS, $filedata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$s = curl_exec ($ch);
		var_dump($s);
	}
	
	public function responseMsgAll(){
		//o0RLFwjSqnmDfxRJ2XHNlv060cXs
		//$access_token="8_jD4uyQc-O7FqY0ZCIInpbY1zmjOut0GUNQTWs7Wrccu0UJYBH0Ihk1CxfyREy_ZQqSm7uxMAqn_rzc5tXLjuqbvt2XkFvZoMaALGWw6L8pW7d4ka3Pazqu8iY7hojTD9eiV9j6EAe9gbZiV3FCRdAFAIFU";
		//8_FKxBrjjCV1AKKt-vJONOuQh09wVzUC7y2ggPbF4wSZwSJ887-d87I3uKlDqG7vgaM1M0olZ2w1A7Y6zNixmiYwyzbfzWyHZH4TlaAxzatrkHH6BZ4VSXzZ38uz1fiURDi07wd_TUBcOE7oe2LLLfAEAXXX
		$url ="https://api.weixin.qq.com/cgi-bin/message/mass/preview?access_token=8_FKxBrjjCV1AKKt-vJONOuQh09wVzUC7y2ggPbF4wSZwSJ887-d87I3uKlDqG7vgaM1M0olZ2w1A7Y6zNixmiYwyzbfzWyHZH4TlaAxzatrkHH6BZ4VSXzZ38uz1fiURDi07wd_TUBcOE7oe2LLLfAEAXXX";
		
/* 		{     
			"touser":"OPENID",
			"text":{           
				   "content":"CONTENT"            
				   },     
			"msgtype":"text"
		} */
		$arr = array(
			"touser"=>"o0RLFwjSqnmDfxRJ2XHNlv060cXs",
			"text"=> array(           
				   "content"=>"群发消息，请查收！",            
				   ),
			"msgtype"=>"text",	   		
		);
		$postJson = json_encode($arr);
		$res = $this->http_curl($url,'post','json',$postJson);
		var_dump($postJson);		
		
	}
	
	public function http_curl($url,$postMethod,$dataType,$postJson){
		$ch = curl_init();  
		curl_setopt($ch, CURLOPT_URL,$url);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		if($postMethod=="post"){
			curl_setopt($ch, CURLOPT_POST, 1 );
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postJson );
		}
		$s = curl_exec ($ch);
		echo("url=".$url);
		curl_close($ch);
		if($dataType=="json"){
			if(curl_errno($ch)){
				return curl_error($ch);
			}else{
				return json_decode($s,true);
			}
		}
	}
	
	public function getToken(){
		//O7FqY0ZCIInpbY1zmjOut0GUNQTWs7Wrccu0UJYBH0Ihk1CxfyREy_ZQqSm7uxMAqn_rzc5tXLjuqbvt2XkFvZoMaALGWw6L8pW7d4ka3Pazqu8iY7hojTD9eiV9j6EAe9gbZiV3FCRdAFAIFU
		//从缓存中获取access_token
		$access_token = S('access_token');
		//如果缓存中没有access_token，则通过appid和appsecret获取
		if($access_token==null||$access_token==""){
			$appId=	C('appId');
			$appSecret= C('appSecret');
			$url ="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appId."&secret=".$appSecret;					
			//通过curl获取$access_token 
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$res = curl_exec($ch);
			if(curl_errno($ch)){
				var_dump(curl_error($ch));
			}
			curl_close($ch);
			$arr = json_decode($res,true);	
			$access_token = $arr['access_token'];	
			//将获取的$access_token 保存到缓存中，保存7000秒
			S('access_token',$access_token,7000 );
		}
		return $access_token;
	}
	
	public function verify(){
		$timestamp  = $_GET['timestamp'];
		$nonce      = $_GET['nonce'];
		$token      = 'xuk1';
		$signature  = $_GET['signature'];
		$echostr    = $_GET['echostr'];
		//拼接字符串
		$arrstr     = array($timestamp,$nonce,$token);
		//按照字典顺序排序
		sort($arrstr);
		//合并字符串，并且用sha1加密
		$tempstr    = sha1( implode( $arrstr));
		//判断签名
		if($tempstr==$signature &&$echostr){
			echo($echostr);
			exit;
		}else{
			$this->responseMsg();
		} 
	}
	
	public function responseMsg(){
/* 		<xml>
			<ToUserName>< ![CDATA[toUser] ]></ToUserName>
			<FromUserName>< ![CDATA[FromUser] ]></FromUserName>
			<CreateTime>123456789</CreateTime>
			<MsgType>< ![CDATA[event] ]></MsgType>
			<Event>< ![CDATA[subscribe] ]></Event>
		</xml> */
		$postArr   = $GLOBALS['HTTP_RAW_POST_DATA'];
		$postObj   =simplexml_load_string( $postArr);
		if($postObj->MsgType=="event"&&$postObj->Event=="subscribe"){			
/* 			<xml> 
				<ToUserName>< ![CDATA[toUser] ]></ToUserName> 
				<FromUserName>< ![CDATA[fromUser] ]></FromUserName> 
				<CreateTime>12345678</CreateTime> 
				<MsgType>< ![CDATA[text] ]></MsgType> 
				<Content>< ![CDATA[你好] ]></Content> 
			</xml> */
			$content     ="欢迎订阅xxx的微信公众号，这里有你想要的计算机、桌游资料";
			$toUser      = $postObj->FromUserName;
			$fromUser    = $postObj->ToUserName;
			$createTime  = time();
			$msgType     = "text";
			$template    = "<xml> 
								<ToUserName>< ![CDATA[%s] ]></ToUserName> 
								<FromUserName>< ![CDATA[%s] ]></FromUserName> 
								<CreateTime>%s</CreateTime> 
								<MsgType>< ![CDATA[%s] ]></MsgType> 
								<Content>< ![CDATA[%s] ]></Content> 
							</xml>";
			$info        = sprintf($template,$toUser,$fromUser,$createTime,$msgType ,$content);				
			echo $info;
		}
		
		
	}
}