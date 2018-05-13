/**
 * jQuery.browser.mobile (http://detectmobilebrowser.com/)
 * jQuery.browser.mobile will be true if the browser is a mobile device
 */
(function(a){(jQuery.browser=jQuery.browser||{}).mobile=/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))})(navigator.userAgent||navigator.vendor||window.opera);

/*
 * Shows the description associated with the skill header that was clicked
 * @param which		the h3 that was clicked
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
 * @param navBlock		the list item to act as a link
 */
function navClickable(navBlock){
	window.location = navBlock.getElementsByTagName("a")[0].href;
}

function animatePortrait(){
	let FADE_SPEED = 1500;
	let TIME_BETWEEN_IMGS = 6000;

	setTimeout(function(){
		$("#topPortrait").fadeIn(FADE_SPEED, function(){
				setTimeout(function(){
					$("#topPortrait").fadeOut(FADE_SPEED);
				}, TIME_BETWEEN_IMGS);
		});
		animatePortrait();
	}, TIME_BETWEEN_IMGS)
}

/*
 * Adds links and project lightboxes to page content for each project in the data file
 */
function loadProjects(){
	$.getJSON( 'data.json', function( data ) {
	  $.each( data.projects, function(index, project) {

			/*Project icons, linking to lightbox*/
			var newIcon = $('<img>').addClass('projPic').attr('src', 'assets/' + project.icon).attr('alt', project.name).attr('title', project.name);
			handleResize();
			var newLink = $('<a></a>').append(newIcon);
			$('#darkBack').before(newLink);

			/*Project lightbox*/
			var newProj = $('<div></div>').attr('id', project.id).addClass('myLightbox').addClass('hide');
			var closeBtn = $('<h4></h4>').attr('id', 'closeIcon').text("x").click(function(){closeLightboxByIcon(this)});
			newProj.append(closeBtn);

			/*Project image*/
			var projImgDiv = $('<div></div>').addClass('projImgDiv');
			var imgLoc = 'assets/';
			if(project.folder !== null){
				imgLoc += project.folder + '/';
			}
			var newImg = $('<img>').addClass('projDetailsImg').attr('src', imgLoc + project.images[0]).attr('alt', project.name).attr('title', project.name);
			if(project.images.length > 1){
				var imgNum = $('<p></p>').text("(1 of " + project.images.length + ")").addClass('numOfImg');
				var lArrow = $('<img>').addClass('lArrow').attr('src', 'assets/lArrow.png').attr('alt', 'left arrow').attr('title', 'left arrow').css('visibility','hidden');
				lArrow.click(function(){switchImg(newImg, -1, project.images, lArrow, rArrow, imgNum)});
				projImgDiv.append(lArrow);
				projImgDiv.append(newImg);
				var rArrow = $('<img>').addClass('rArrow').attr('src', 'assets/rArrow.png').attr('alt', 'right arrow').attr('title', 'right arrow');
				rArrow.click(function(){switchImg(newImg, 1, project.images, lArrow, rArrow, imgNum)});
				projImgDiv.append(rArrow);
				projImgDiv.append(imgNum);
			}
			else{
				projImgDiv.append(newImg);
			}
			newProj.append(projImgDiv);

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
			if(project.buttonText != null){
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
			}

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
			$('footer').before(newProj);

			newLink.click(function(){
				showLightbox(project.id);
			});
	  });	//end each loop
	});	//end getJSON
}	//end loadProjects function

/**
 * Switches source of project image based on a user-selected direction
 * @param image				the image to change
 * @param direction		1 to indicate right or -1 to indicate left
 * @param imgArr			array of img srcs for the projects
 * @param lArrow			the left arrow that accompanies the image
 * @param rArrow			the right arrow that accompanies the image
 * @param imgNum			the p tag that gives image number out of number of images
 */
function switchImg(image, direction, imgArr, lArrow, rArrow, imgNum){
	var splitSrc = image.attr('src').split('/');
	var imgName = splitSrc[splitSrc.length - 1];
	var curIndex = imgArr.indexOf(imgName);
	var newIndex = curIndex + direction;
	lArrow.css('visibility','visible');
	rArrow.css('visibility','visible');
	imgNum.text("(" + (newIndex + 1) + " of " + imgArr.length + ")");

	if(newIndex == 0){
		lArrow.css('visibility','hidden');
	}
	else if(newIndex == imgArr.length - 1){
		rArrow.css('visibility','hidden');
	}
	var newSrc = "";
	for(i = 0; i < splitSrc.length - 1; i++){
		newSrc += splitSrc[i] + "/";
	}
	newSrc += imgArr[newIndex];
	image.attr('src',newSrc);
}


/*
 * Positions arrows on either side of a project img
 */
function positionImgSwitchArrows(){
	$('.myLightbox').each(function(index, item){
		if($(item).css('display') == "block"){
			lightboxId = $(item).attr('id');
			var lArrow = $('div#' + lightboxId + ' img.lArrow');
			var rArrow = $('div#' + lightboxId + ' img.rArrow');
			if(lArrow.length > 0 || rArrow.length > 0){		//if has arrows
				var imgHeight = $('div#' + lightboxId + ' img.projDetailsImg').height();
				var arrowTop = (imgHeight - lArrow.height())/2;
				lArrow.css('margin-top',arrowTop + 'px');
				rArrow.css('margin-top',arrowTop + 'px');
			}
		}
	});
}

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

	$('.myLightbox').each(function(index, item){
		if($(item).css('display') == "block"){
			positionLightbox($(item));
			positionImgSwitchArrows();
		}
	});
}

/*
 * Assigns/removes lastInRow class designation as needed to display the desired
 * number of projects per row
 * @param {Number} perRow			projects to display per row
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

/*
 * Displays the lightbox with the given id
 * @param id		id of the lightbox to display
 */
function showLightbox(id){
	$('body').addClass('noScroll'); //disable scroll for content behind lightbox
	var lightbox = $('#' + id);
	$('#darkBack').css('display', 'block').click(function(){closeLightboxById(id)});
  lightbox.css('display', 'block');
	positionLightbox(lightbox);
	positionImgSwitchArrows();
}

/**
 * Centers lightbox on screen and positions close icon in upper right of box
 * @param lightbox		the lightbox to position
 */
function positionLightbox(lightbox){

	//position lightbox content
	lightbox.css('max-height','100%');
	lightbox.css('overflow-y','auto');
	lightbox.css('height', lightbox.naturalHeight);
	var boxHeight = lightbox.outerHeight();
	var windowHeight = window.innerHeight;
	if(boxHeight > windowHeight){
		boxHeight = windowHeight - 30;	//-30 is to avoid some lightbox content being cut off at the bottom
		lightbox.css('max-height', boxHeight);
		lightbox.css('overflow-y', 'scroll');
	}

  var boxWidth = lightbox.outerWidth();
  var top = (windowHeight - boxHeight) / 2;
  var left = (window.innerWidth - boxWidth) / 2;
	if (top < 0){
		top = 0;
	}
  lightbox.css('top', top);
  lightbox.css('left', left);

  //position close icon
  var closeIcon = lightbox.find('#closeIcon');
  closeIcon.css('top', top - (closeIcon.outerHeight() - closeIcon.height())/2);
  closeIcon.css('left', left + boxWidth - closeIcon.outerWidth());
}

/*
 * Closes the lightbox with the given close icon
 * @param xIcon		the X icon that was clicked
 */
function closeLightboxByIcon(xIcon){
  var lightbox = $(xIcon).parent();
  lightbox.css('display', 'none');
  $('#darkBack').css('display', 'none');
	resetImg(lightbox.attr('id'));
	$('body').removeClass('noScroll'); //re-enable scroll for content behind lightbox
}

/*
 * Closes the lightbox with the matching id
 * @param id		the id of the lightbox to close
 */
function closeLightboxById(id){
  $("#" + id).css('display', 'none');
  $('#darkBack').css('display', 'none');
	resetImg(id);
	$('body').removeClass('noScroll'); //re-enable scroll for content behind lightbox
}

/**
 * Returns the source of a project image to the first project image if it had several
 * @param id		the id of the lightbox to reset the image of
 */
function resetImg(id){
	$.getJSON( 'data.json', function( data ) {
		$.each( data.projects, function(index, project) {
			if(project.id == id){
				var image = $("div#" + id + " img.projDetailsImg");
				var imgLoc = 'assets/';
				if(project.folder !== null){
					imgLoc += project.folder + '/';
				}
				image.attr('src', imgLoc + project.images[0]);

				$("div#" + id + " p.numOfImg").text("(1 of " + project.images.length + ")");

				var lArrow = $('div#' + lightboxId + ' img.lArrow');
				if(lArrow.length > 0){		//if has arrows
					lArrow.css('visibility','hidden');
				}
				$('div#' + lightboxId + ' img.rArrow').css('visibility','visible');	//make sure right arrow visible
			}
		});
	});
}
