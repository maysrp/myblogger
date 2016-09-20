<?php
	class PostModel extends Model{
		function own($pid){
			$uid=$_SESSION['uid'];
			$post=$this->find($pid);
			if($post['uid']==$uid){
				$pos=json_decode($post['tag'],true);
				$post['tag']=implode(" ", $pos);
				return $post;
			}
		}
		function view_add($pid){
			$x=$this->find($pid);
			if($x){
				$this->where("pid='".$pid."'")->setInc("view");
			}
		}
		function re_add($pid){
			$x=$this->find($pid);
			if($x){
				$this->where("pid='".$pid."'")->setInc("re");
			}
		}
		function re_dec($pid){
			$x=$this->find($pid);
			if($x){
				$this->where("pid='".$pid."'")->setDec("re");
			}
		}
		function show($pid){
			$end=$this->find($pid);
			if($end){
				$end['tag']=json_decode($end['tag'],true);
				$re['re']="success";
				$re['end']=$end;
				$this->view_add($pid);
			}else{
				$re['re']="error";
				$re['end']="没有找到该文章！";
			}
			return $re;
		}
		function post($post){
			if(!$_SESSION['uid']){
				$re['re']="error";
				$re["end"]="权限不服！";
				return $re;
			}
			$post['tag']=strip_tags($post['tag']);
			$data['title']=$post['title'];
			$data['text']=$post['text'];
			$data['time']=time();
			$data['uid']=$_SESSION['uid'];
			preg_match_all('/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?\/>/i', $post['text'], $image);
			if(count($image)){
				$data['image']=json_encode($image[0]);
			}
			$tag=preg_replace('/\s+/', ' ', $post['tag']);
			$tag_array=explode(" ", $tag);
			$data['tag']=json_encode($tag_array);
			$pid=$this->add($data);
			foreach ($tag_array as $key => $value) {
				if(!$value){
					continue;
				}
				$tid_tag[]=D('Tag')->tag_add($value,$pid);//return $tid_$tag
			}
			$add_tid['tid']=json_encode($tid_tag);
			$add_tid['pid']=$pid;
			$this->save($add_tid);
			return $pid;
		}
		function edit_show($pid){
			$jugg=$this->own($pid);
			if($jugg){
				$re['re']="success";
				$re["end"]=$jugg; 

			}else{
				$re['re']="error";
				$re["end"]="权限不服！";
			}
			return $re;
		}
		function del($pid){
			$dre=$this->own($pid);
			if($dre){
				$x=$this->delete($pid);
				if($x){
					$re['re']="success";
					$re['end']="成功删除！";
				}else{
					$re['re']="error";
					$re['end']="删除失败！";
				}
			}else{
				$re['re']="error";
				$re['end']="权限不服！";
			}
			return $re;
		}
		function edit($post){
			$dre=$this->own($post['pid']);
			if($dre){
				D('Tag')->post_del_tag($post['pid']);
				$data['title']=$post['title'];
				$data['text']=$post['text'];
				$post['tag']=strip_tags($post['tag']);
				preg_match_all('/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?\/>/i', $post['text'], $image);
				if(count($image)){
					$data['image']=json_encode($image[0]);
				}
				$data['retime']=time();
				$tag=preg_replace('/\s+/', ' ', $post['tag']);
				$tag_array=explode(" ", $tag);
				$data['tag']=json_encode($tag_array);
				foreach ($tag_array as $key => $value) {
					if(!$value){
						continue;
					}
					$tid_tag[]=D('Tag')->tag_add($value,$post['pid']);//return $tid_$tag
				}
				$data['tid']=json_encode($tid_tag);
				$data['pid']=$post['pid'];
				$en=$this->save($data);
				if($en){
					$re['re']="success";
					$re['end']=$post['pid'];
				}else{
					$re['re']="error";
					$re['end']="修改失败！";
				}
			}else{
				$re['re']="error";
				$re["end"]="权限不服！";
			}
			return $re;
		}
		function list_post(){
			$uid['uid']=$_SESSION['uid'];
			$list=$this->where($uid)->order("time desc")->select();//找到
			if($list){
				$re['re']="success";
				$re['end']=$list;
			}else{
				$re['re']="error";
				$re['end']="";
			}
			return $re;
		}
		


	}