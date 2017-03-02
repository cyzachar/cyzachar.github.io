/*
 * Shows the description associated with the skill header that was clicked
 * @param which - the h3 that was clicked
 */
function showDescrip(which){
	var skillName = which.innerHTML;
	var length = skillName.length;
	skillName = skillName.substr(0,length - 2);
  var matchedDesc = which.parentNode.getElementsByTagName("p")[0];

	//if block not displayed, display
	if(matchedDesc.style.display == "none" || matchedDesc.style.display == ""){			//note: initial val of display for description p's is ""
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
 * @param navBlock - the list item to act as a link
 */
function navClickable(navBlock){
	window.location = navBlock.getElementsByTagName("a")[0].href;
}

function showPptMe(){
	$("#topPortrait").css("opacity", 1);
	$("#bottomPortrait").css("opacity", 0);
}

function hidePptMe(){
	$("#topPortrait").css("opacity", 0);
	$("#bottomPortrait").css("opacity", 1);
}

/*
 * Adds links and project lightboxes to page content for each project in the data file
 */
function loadProjects(){
	$.getJSON( 'data.json', function( data ) {
	  $.each( data.projects, function(index, project) {

			/*Project icons, linking to lightbox*/
			var newIcon = $('<img>').addClass('projPic').attr('src', 'assets/' + project.icon);
			handleResize();
			var newLink = $('<a></a>').attr('href', '#').attr('data-featherlight-variant', project.id + 'Lightbox').append(newIcon);
			$('footer').before(newLink);

			/*Project lightbox*/
			var newProj = $('<div></div>').attr('id', project.id).addClass('lightbox');

			/*Project image*/
			var imgLoc = 'assets/';
			if(project.folder !== null){
				imgLoc += project.folder + '/';
			}
			var newImg = $('<img>').attr('src', imgLoc + project.images[0]);
			newProj.append(newImg);

			/*title and description*/
			var title = $('<h3></h3>').text(project.name);
			var descript = $('<div></div>').addClass('projDescript').append(title);
			$.each(project.description, function(index, pgh){
				descript.append($('<p></p>').html(pgh));	//html b/c some special characters in there
			});

			/*skills*/
			descript.append($('<h4></h4>').text('Skills:'));
			var skillText = '';
			$.each(project.skills, function(index, skill){
				skillText += skill;
				if(index !== project.skills.length - 1){
					skillText += ' &bull; ';
				}
			});
			var skills = $('<p></p>').html(skillText).addClass('projSkills');		//using .html in order to get bullets to show up...TO DO look for a better way?
			descript.append(skills);

			/*button*/
			var buttonLink = $('<a></a>');
			if(project.directionHead == null){		//project is website
				buttonLink.attr('href', project.link).attr('target','_blank');
			}
			else{																	//project requires directions/download
				buttonLink.attr('href','#').attr('data-featherlight',project.id + "Dir").attr('data-featherlight-variant','dirLightbox');
			}
			var button = $('<button></button>').text(project.buttonText).attr('type','button');
			buttonLink.append(button);
			descript.append(buttonLink);

			/*directions*/
			if(project.directionHead !== null){
				var dirDiv = $('<div></div>').attr('id',project.id + 'Dir').addClass('hide');
				dirDiv.append($('<p></p>').text(project.directionHead));
				var steps = $('<ol></ol>');
				$.each(project.directions, function(index, step){
					if(step.indexOf('here') === -1){
						steps.append($('<li></li>').text(step));
					}
					else{
						var start = step.indexOf('here');
						var end = start + 4;
						var stepText = step.substring(0, start) + '<a href = "assets/' + project.link + '" type="' + project.linkType + '" download>here</a>' + step.slice(end);
						steps.append($('<li></li>').html(stepText));
					}
				});
				dirDiv.append(steps);
				descript.append(dirDiv);
				buttonLink.featherlight(dirDiv);
			}

			newProj.append(descript);
			newLink.after(newProj).featherlight(newProj);

	  });	//end each loop
	});	//end getJSON
}	//end loadProjects function

//TO DO include alt and title for images
//TO DO figure out a better way to add assets/ before urls


/*
 * Adds skills with descriptions to page content for each skill in the data file
 */
function loadSkills(){
	$.getJSON( 'data.json', function( data ) {
	  $.each( data.skills, function(index, skill) {
			var skillDiv = $('<div></div>').addClass('skills');
			var skillHead = $('<h3></h3>').html(skill.name + '  &#9662;').click( function(){ showDescrip(this); } );
			skillDiv.append(skillHead).append( $('<p></p').html(skill.description) );		//html instead of text because there's a link in one description
			$('footer').before(skillDiv);
		});
	});
}

/*
 * Adjusts the number of projects displayed per row based on the window viewport width
 */
function handleResize(){
	var width = $(window).width();
	var projPerRow;
	if(width < 300){
		projPerRow = 1;
	}
	else if(width < 500){
		projPerRow = 2;
	}
	else{
		projPerRow = 3;
	}
	assignLastInRow(projPerRow);
}

/*
 * Assigns/removes lastInRow class designation as needed to display the desired
 * number of projects per row
 * @param {Number} perRow - projects to display per row
 */
function assignLastInRow(perRow){
	$.each($('.projPic'), function(index, project){

		if(perRow !== 1 && (index + 1) % perRow === 0){
			$(project).addClass('lastInRow');
		}
		else{
			$(project).removeClass('lastInRow');
		}

	});
}
