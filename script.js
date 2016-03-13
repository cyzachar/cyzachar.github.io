function showDescrip(id, index){
	var pghs = document.getElementsByClassName("descrip");
	var skillName = document.getElementById(id).innerHTML;
	var length = skillName.length;
	skillName = skillName.substr(0,length - 2);
	
	if(pghs[index].style.display == "none"){			//BUG: takes 2 clicks to enter body of this if
		document.getElementById(id).innerHTML = skillName + " &#9652;";
		pghs[index].style.display = "block";
	}
	else{
		document.getElementById(id).innerHTML = skillName + " &#9662;";
		pghs[index].style.display = "none";
	}
}

function navClickable(navBlock){
	window.location = navBlock.getElementsByTagName("a")[0].href;
}