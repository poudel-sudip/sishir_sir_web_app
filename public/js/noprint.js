	
// var cssNode2 = document.createElement('style'); 
// cssNode2.type = 'text/css'; 
// cssNode2.media = 'screen'; 
// cssNode2.innerHTML ='div{-webkit-touch-callout: none;-webkit-user-select: none;-khtml-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;}';
// document.head.appendChild(cssNode2);
// document.body.style.cssText="-webkit-touch-callout: none;-webkit-user-select: none;-khtml-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;";
 	

var allow_print = false;
var allow_copy = false;
var allow_screenshot = false;

if(!allow_print)
{
	var c=document.createElement("span");
   	c.style.display="none";
   	c.style.postion="absolute";
   	c.style.background="#000";

	var first=document.body.firstChild;
	var wraphtml=document.body.insertBefore(c,first);
  	c.setAttribute('width', document.body.scrollWidth);
  	c.setAttribute('height', document.body.scrollHeight);
 	c.style.display="block";

 	var cssNode3 = document.createElement('style'); 
	cssNode3.type = 'text/css'; 
	cssNode3.media = 'print'; 
	cssNode3.innerHTML ='body{display:none}';
	document.head.appendChild(cssNode3); 
}

if (!allow_copy) 
{ 
	document.body.oncopy = function(){return false}; 
	document.body.oncontextmenu = function(){return false};
	//remove content selection 
	// document.body.onselectstart = document.body.ondrag = function(){
	//     return false;
	// }
 	document.onkeydown = function() {
		if((event.ctrlKey == true || event.metaKey == true) && event.keyCode == 83) {
			event.preventDefault();
		}
		if((event.ctrlKey == true || event.metaKey == true) && event.code == 83) {
			event.preventDefault();
		}
	}
}

if (!allow_screenshot) 
{ 
	document.addEventListener('keyup', (e) => {
		if (e.key == 'PrintScreen') {
			navigator.clipboard.writeText('');		
		}
	});

}

function toBlur()
{
	if (!allow_screenshot)
	{
		document.body.style.cssText="-webkit-filter: blur(0.25px);-moz-filter: blur(0.25px);-ms-filter: blur(0.25px);-o-filter: blur(0.25px);filter: blur(0.25px);"
	}
}

function toClear()
{
	document.body.style.cssText="-webkit-filter: blur(0px);-moz-filter: blur(0px);-ms-filter: blur(0px);-o-filter: blur(0px);filter: blur(0px);"
}


document.onclick = function(event){
 	toClear();
}
 
document.onmouseleave = function(event){
	toBlur();
}

document.onblur = function(event){
 	toBlur();
}
