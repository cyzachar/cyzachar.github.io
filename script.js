/*
 * Shows the description associated with the skill header that was clicked
 * param which is the h3 that was clicked
 */
function showDescrip(which){
	var skillName = which.innerHTML;
	var length = skillName.length;
	skillName = skillName.substr(0,length - 2);
  var matchedDesc = which.parentNode.getElementsByTagName("p")[0];

	//if block not displayed, display
	if(matchedDesc.style.display == "none" || matchedDesc.style.display == ""){			//initial val of display for description p's is ""
		which.innerHTML = skillName + " &#9652;";		//switch down arrow to up
		matchedDesc.style.display = "block";
	}
	//if block displayed, hide
	else{
		which.innerHTML = skillName + " &#9662;";		//switch up arrow to down
		matchedDesc.style.display = "none";
	}
}

/*
 * Ensures that entire navigation block acts as a link
 */
function navClickable(navBlock){
	window.location = navBlock.getElementsByTagName("a")[0].href;
}
