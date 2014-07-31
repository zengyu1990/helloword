function adaptText(){
	var text = $("#resultPageScore").html();
	var error="r u fucking lost your mind?";
	if(isNaN(text)){
		if(text.indexOf('亿')!=-1&&text.indexOf('万')==-1){
			var pos=text.indexOf('亿');
			var num=text.substring(0,pos);
			if(!isNaN(num)){
				var size=subAdaptText(num);
				var newtext="<span id='numWithWord'>"+num+"</span><span id='wordWithNum'>亿</span>";
				$("#resultPageScore").html(newtext);
				$("#numWithWord").css({
					"font-family":"tahoma","font-size":size
				});
				$("#wordWithNum").css({
					"font-family":"黑体","font-size":size
				});
			}
			else{
				alert(error);
			}
			
		}else if(text.indexOf('万')!=-1&&text.indexOf('亿')==-1){
			var pos=text.indexOf('万');
			var num=text.substring(0,pos);
			if(!isNaN(num)){
				var size=subAdaptText(num);
				var newtext="<span id='numWithWord'>"+num+"</span><span id='wordWithNum'>万</span>";
				$("#resultPageScore").html(newtext);
				$("#numWithWord").css({
					"font-family":"tahoma","font-size":size
				});
				$("#wordWithNum").css({
					"font-family":"黑体","font-size":size
				});
			}
			else{
				alert(error);
			}
			}
		else{
			alert(error);
		}
		
	}else{
		var len = text.length;
		switch(len){
			case 1:$("#resultPageScore").css({
				"font-size":"194px"
			});
			break;
			case 2:$("#resultPageScore").css({
				"font-size":"162px"
			});
			break;
			case 3:$("#resultPageScore").css({
				"font-size":"111px"
			});
			break;
			case 4:$("#resultPageScore").css({
				"font-size":"81px"
			});
			$("#resultPageScore").css("line-height","250px");
			break;
			case 5:$("#resultPageScore").css({
				"font-size":"66px"
			});
			$("#resultPageScore").css("line-height","250px");
			break;
			case 6:$("#resultPageScore").css({
				"font-size":"60px"
			});
			$("#resultPageScore").css("line-height","250px");
			break;
			case 7:$("#resultPageScore").css({
				"font-size":"46px"
			});
			$("#resultPageScore").css("line-height","250px");
			break;
			default:alert("fuck~爆了");
			break;
		}
	}
}