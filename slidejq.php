<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>图片无缝滚动</title>
<script type="text/javascript" src="http://www.codefans.net/ajaxjs/jquery-1.6.2.min.js"></script>
<style type="text/css">
*{ margin:0; padding:0;}
#box{ border:0px #ccc solid; width:600px; height:200px; overflow:hidden;margin:100px auto 0; position:relative;}
#div{ width:2400px; position:relative;}
#img,#img1{ list-style:none; width:1200px; float:left;}
#img img,#img1 img{width:220px; float:left;}
ul li{ float:left;}
#but{ width:600px; height:30px; margin:0 auto;}
#a{ float:left;}
#b{ float:right;}
#but input{ width:80px; height:30px; font-size:22px; font-weight:bold;}
</style>
</head>
<body>
<div id="box">
	<div id="div">
	<ul id="img">
<li><div>aaaa</div><img src="/jscss/demoimg/wall_s1.jpg" /></li>
<li><div>aaaa</div><img src="/jscss/demoimg/wall_s2.jpg" /></li>
<li><div>aaaa</div><img src="/jscss/demoimg/wall_s3.jpg" /></li>
<li><div>aaaa</div><img src="/jscss/demoimg/wall_s4.jpg" /></li>
<li><div>aaaa</div><img src="/jscss/demoimg/wall_s5.jpg" /></li>
<li><div>aaaa</div><img src="/jscss/demoimg/wall_s6.jpg" /></li>
   	</ul>
    	<ul id="img1">
<li><div>aaaa</div><img src="/jscss/demoimg/wall_s1.jpg" /></li>
<li><div>aaaa</div><img src="/jscss/demoimg/wall_s2.jpg" /></li>
<li><div>aaaa</div><img src="/jscss/demoimg/wall_s3.jpg" /></li>
<li><div>aaaa</div><img src="/jscss/demoimg/wall_s4.jpg" /></li>
<li><div>aaaa</div><img src="/jscss/demoimg/wall_s5.jpg" /></li>
<li><img src="/jscss/demoimg/wall_s6.jpg" /></li>
    	</ul>
    </div>
</div>
<div id="but">
	<div id="a"><input type="button" id="but1" value="左移" /></div>
    <div id="b"><input type="button" id="but2" value="右移" /></div>
</div>
<script type="text/javascript">
/*获取id节点的函数*/
$(function(){
	function getId(id){
		return $('#'+id);
	}
/*创建图片滚动对象(前四个参数是标签的id)*/
	function marquee(divElem,imgElem,lBut,rBut,imgWidth,speed,autoSpeed){//参数含义(包含两组图片的div，包含一组图片的ul，左侧按钮，右侧按钮,图片宽度，单张图片滚动时间，图片滚动间隔时间)
		this.box=getId(divElem);
		this.img=getId(imgElem);
		this.lBut=getId(lBut);
		this.rBut=getId(rBut);//获取各个节点
		this.imgWidth=imgWidth;
		this.speed=speed;
		this.autoSpeed=autoSpeed;
		this.num=0;//全局变量,用来进行条件控制
		var that=this;
		/*图片自动滚动函数*/
		this.autoGo=function(){
			that.num+=that.imgWidth;
			that.box.animate({right:"+="+that.imgWidth+"px"},that.speed);
			if(that.num>=that.img.width()){
				that.num=0;
				that.box.animate({right:"0px"},0);
			}
		}
	}
	/*对象方法*/
	marquee.prototype={
		/*图片的自动滚动*/
		autoScroll:function(){
			var that=this;
			auto=setInterval(this.autoGo,this.autoSpeed);
			this.box.mouseover(function(){
				clearInterval(auto);						 
			});
			this.box.mouseout(function(){
				auto=setInterval(that.autoGo,that.autoSpeed);							
			})
			this.lBut.mouseover(function(){
				clearInterval(auto);
				if(that.num==that.img.width()){
					that.num=0;
					that.box.animate({right:"0px"},0);
				}
			});
			this.lBut.mouseout(function(){
				auto=setInterval(that.autoGo,that.autoSpeed);							
			});
			this.rBut.mouseover(function(){
				clearInterval(auto);
				if(that.num==0){
					that.num=that.img.width();
					that.box.animate({right:that.img.width()+"px"},0);
				}
			});
			this.rBut.mouseout(function(){
				auto=setInterval(that.autoGo,that.autoSpeed);
				if(that.num==that.img.width()){
					that.num=0;
					that.box.animate({right:"0px"},0);
				}
			});
		},
		/*单击左侧按钮,图片向左滚动*/
		leftScroll:function(){
			var that=this;
			this.lBut.click(function(){
				that.num+=that.imgWidth;
				that.box.animate({right:"+="+that.imgWidth+"px"},that.speed);
				if(that.num>=that.img.width()){
					that.num=0;
					that.box.animate({right:"0px"},0);
				}
			});
		},
		/*单击右侧按钮,图片向右滚动*/
		rightScroll:function(){
			var that=this;
			this.rBut.click(function(){
				that.num-=that.imgWidth;
				that.box.animate({right:"-="+that.imgWidth+"px"},that.speed);
				if(that.num<=0){
					that.num=that.img.width();
					that.box.animate({right:that.img.width()+"px"},0);
				}
			});
		}
	}
	
	var a=new marquee("div","img","but1","but2",200,300,2000);//初始化对象
	a.autoScroll();
	a.leftScroll();
	a.rightScroll();
});
</script>
</body>
</html>