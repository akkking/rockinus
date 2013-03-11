<!-- -->
<bgsound id="soundfiles"> 
<script language="JavaScript">
<!-- // Sound on Mouseover javascript  supplied by http://www.hypergurl.com 
var aySound = new Array(); 
// PLACE YOUR SOUND FILES BELOW 
aySound[0] = "CHORD.wav"; 
aySound[1] = "DING.wav"; 
aySound[2] = "CHORD.wav"; 
// Don't alter anything below this line 
IE = (navigator.appVersion.indexOf("MSIE")!=-1 && document.all)? 1:0; 
NS = (navigator.appName=="Netscape" && navigator.plugins["LiveAudio"])? 1:0; 
ver4 = IE||NS? 1:0; onload=auPreload; function auPreload() { if (!ver4) return; 
if (NS) auEmb = new Layer(0,window); 
else { 
	Str = "<DIV ID='auEmb' STYLE='position:absolute;'></DIV>"; 
	document.body.insertAdjacentHTML("BeforeEnd",Str); 
} 

var Str = ''; 
for (i=0;i<aySound.length;i++) Str += "<EMBED SRC='"+aySound[i]+"' AUTOSTART='FALSE' HIDDEN='TRUE'>" 
if (IE) auEmb.innerHTML = Str; 
else { 
	auEmb.document.open(); auEmb.document.write(Str); auEmb.document.close(); 
} 
auCon = IE? document.all.soundfiles:auEmb; auCon.control = auCtrl; } 
function auCtrl(whSound,play) { 
	if (IE) this.src = play? aySound[whSound]:''; 
	else eval("this.document.embeds[whSound]." + (play? "play()":"stop()")) 
} 
function playSound(whSound) { 
	if (window.auCon) auCon.control(whSound,true); 
} 
function stopSound(whSound) { 
	if (window.auCon) auCon.control(whSound,false); 
} 
//--></script> 
<!-- 
-->

<a href="http://www.yourlink.com" onMouseOver="playSound(0)" onMouseOut="stopSound(0)">YOUR LINK</a>