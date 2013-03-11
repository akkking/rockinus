var xmlHttp;

function stateChanged() 
{
	with(document.myForm)
	{
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{
			xmlDoc=xmlHttp.responseXML;
			var str=xmlHttp.responseText;
			str=str.substring(0,str.length-1); 
			var arr=str.split("|");
			var lines = new Array();
			lines["0"] = ["--please choose the line--"];
			var value = line.value;
			lines[value]=arr;
			stops.options.length = 0;
			var option;
			for(i = 0;i < lines[value].length;i++)
			{
				option = new Option(lines[value][i],lines[value][i]);
				stops.options.add(option);
			}
			if(line.value == "0")
			 stops.disabled = true;
			else
			 stops.disabled = false;
		}
	}
}

function GetXmlHttpObject()
 { 
 var objXMLHttp=null
 if (window.XMLHttpRequest)
  {
  objXMLHttp=new XMLHttpRequest()
  }
 else if (window.ActiveXObject)
  {
  objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP")
  }
 return objXMLHttp
 }

 function changestops(str)
{
	with(document.myForm)
	{
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 
		var url="response.php";
		url=url+"?q="+str;
		url=url+"&sid="+Math.random();
		xmlHttp.onreadystatechange=stateChanged ;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
   }
}