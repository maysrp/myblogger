<?php
	function uidname($uid){
		$re=D('User')->find($uid);
		if($re){
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
		for ($i=0; $i <=$ix ; $i++) { 
			$re=$re."<a class=\"text-warning\" href=/index.php/User/tag/tid/".$tags[$i]['tid'].">".$tags[$i]['tag']."</a> .";
		}
		return $re;
	}
	function radio($va,$x){
		if($va==$x){
			return "checked";

		}
	}
	function active($va,$x){
		if($va==$x){
			return "active";
			
		}
	}
	function tags($tag){//跳转
		$tags=json_decode($tag,true);
		$count=count($tags);
		$ix=($count>3)?2:$count-1;
		$re="";
		for ($i=0; $i <=$ix ; $i++) { 
			$re=$re."<a class=\"text-warning\" href=/index.php/Index/tag/tid/".$tags[$i]['tid'].">".$tags[$i]['tag']."</a> .";
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
		$post=D('Post')->limit(10)->order("time desc")->select();
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