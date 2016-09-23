<?php
	function uidname($uid){
		$re=D('User')->find($uid);
		if($re){
			if($uid==1){
				return "管理员";
			}
			return $re['name'];
		}else{
			return "匿名者";
		}
	}
	function tagss($tag){
		$tags=json_decode($tag,true);
		$count=count($tags);
		$ix=($count>3)?2:$count-1;
		$re="";
		foreach ($tags as $key => $value) {
			$re=$re."<a class=\"text-warning\" href=/index.php/User/tag/tid/".$key.">".$value['tag']."</a> .";
		}
		return $re;
	}
	function radio($va,$x){//选择
		if($va==$x){
			return "checked";
		}
	}
	function active($va,$x){//激活 模版 内容
		if($va==$x){
			return "active";		
		}
	}
	function tpl_use($a,$b,$c="active"){//上面两个函数的集合
		if($a==$b){
			return $c;
		}
	}
	function tags($tag){//跳转
		$tags=json_decode($tag,true);
		$count=count($tags);
		$ix=($count>3)?2:$count-1;
		$re="";
		foreach ($tags as $key => $value) {
			$re=$re."<a class=\"text-warning\" href=/index.php/Index/tag/tid/".$key.">".$value['tag']."</a> .";
		}
		return $re;
	}
	function hottag(){
		$tag_array=D('Tag')->order("num desc")->limit(10)->select();
		$re="<p>";
		foreach ($tag_array as $va) {
			$re=$re."<a class=\"text-warning\" href=/index.php/Index/tag/tid/".$va['tid'].">".$va['tag']."</a> ";
		}
		$re=$re."</p>";
		return $re;
	}
	function lastpost(){
		$post=D('Post')->limit(5)->order("time desc")->select();
		$re="<ul>";
		foreach ($post as $va) {
			$re=$re."<li><a href=/index.php/Index/post/pid/".$va['pid'].">".$va['title']."</a></li>";
		}
		$re=$re."</ul>";
		return $re;
	}
	function site(){
		$site=D('Site')->find(1);
		return $site;
	}
	function pidtitle($pid){
		$re=D('Post')->find($pid);
		if ($re) {
			echo "<a href=\"/index.php/Index/post/pid/".$re['pid']."\">". $re['title']."</a>";
		}
	}
	function postimage($v){
		$image=json_decode($v,true);
		if(count($image)){
			echo "<p>".$image[0]."</p>";
		}
	}
	function shelves(){
		$info=D('Shelves')->shelves();
		echo "<ul>";
		foreach ( $info as $key => $value) {
			echo "<li>".$key."年</li>";
			echo "<ul>";
				foreach ($value as $key_1 => $value_1) {
					echo "<li class=\"slide_click_moon\" value=\"".$key.$key_1."\" style=\"margin-left:-30px;\">".$key_1."月</li>";
					echo "<div id=\"moon".$key.$key_1."\" style=\"display:none\"><ul>";				
					foreach ($value_1 as $key_2 => $value_2) {
						echo "<li class=\"slide_click\" style=\"margin-left:-60px;\" value=\"".$key_1.$key_2."\">".$key_1."月".$key_2."日</li>";
						echo "<div id=\"li".$key_1.$key_2."\" style=\"display:none\"><ul style=\"margin-left:-30px;\">";
							foreach ($value_2 as $key_3 => $value_3) {
								echo "<li style=\"margin-left:-60px;\"><a href=\"/index.php/Index/post/pid/".$key_3."\" >".$value_3['title']."</a></li>";
							}
						echo "</ul></div>";
					}
					echo "</ul></div>";		
				}
			echo "</ul>";
		}
		echo "</ul>";	
	}
	function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
    	$url = 'https://www.gravatar.com/avatar/';
    	$url .= md5( strtolower( trim( $email ) ) );
   		$url .= "?s=$s&d=$d&r=$r";
    	if ( $img ) {
        	$url = '<img src="' . $url . '"';
        	foreach ( $atts as $key => $val )
            	$url .= ' ' . $key . '="' . $val . '"';
        	$url .= ' />';
    	}
    	return $url;
	}
	function avatar($info){
		if($info['uid']){
			$user=D('User')->find($info['uid']);
			return $user['image'];
		}else{
			return get_gravatar($info['email'],50);
		}
	}
	function tag_text($tid){
		$info=json_decode($tid,true);
		foreach ($info as $key => $value) {
			echo $value['tag']." ";
		}
	}
