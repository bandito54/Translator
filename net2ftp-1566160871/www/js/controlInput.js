setInputFormAnim();
function setInputFormAnim()
{
	var allSpanForm = document.getElementsByClassName('spanInp');
	var i = 0;
	for(i = 0;i < allSpanForm.length;i++)
	{
		allSpanForm[i].addEventListener('keyup',function()
		{
			checkState(this);
		},false);
		allSpanForm[i].addEventListener('click',function(){
			this.getElementsByClassName('inputForm')[0].focus();
			checkState(this);
		},false);
		checkState(allSpanForm[i]);
	}
}

function checkState(div){
	if(div.getElementsByClassName('inputForm')[0].value != ""){
		div.classList.add("active");
	}
	else{
		if(div.classList.contains("active")){
			div.classList.remove("active");
		}
	}
}