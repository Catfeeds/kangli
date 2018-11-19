//下拉弹出提示
function mpoptips(mtxt,mtype,mtime){
	var el3=$.tips({
		content:mtxt,
		stayTime:mtime,
		type:mtype
	})
	el3.on("tips:hide",function(){
	  
	})
}

//删除左右两端的空格
function trim(str){ 
	return str.replace(/(^\s*)|(\s*$)/g, "");
} 

