/*
Include jquery & add the following to the html head:
<script type = "text/javascript" src = "js/skylightbox.js"></script>
<script>
$(document).ready(function(){
  $(window).resize(function() {
    handleResize();
  });
});
</script>
*/

/*
 * Displays the lightbox with the given id
 * @param id		id of the lightbox to display
 */
function showLightbox(id){
  $('body').addClass('noScroll'); //disable scroll for content behind lightbox

	var lightbox = $('#' + id);
	$('#darkBack').css('display', 'block').click(function(){closeLightboxById(id)});
  lightbox.css('display', 'block');

  if(id == 'sampleStatsMore'){
    let tableauPromise = new Promise((resolve, reject) => {
      var divElement = $('#viz1513614270547');
      var vizElement = $(divElement.find('object')[0]);
      vizElement.width('100%');
      vizElement.height(vizElement.width()*0.75);
      var scriptElement = $('<script></script>');
      scriptElement.attr('src','https://public.tableau.com/javascripts/api/viz_v1.js');
      scriptElement.insertBefore(vizElement);

      divElement = $('#viz1513614387971');
      var vizElement = $(divElement.find('object')[0]);
      vizElement.width('100%');
      vizElement.height(vizElement.width()*0.75);
      var scriptElement = $('<script></script>');
      scriptElement.attr('src','https://public.tableau.com/javascripts/api/viz_v1.js');
      scriptElement.insertBefore(vizElement);

      resolve();
    });

    tableauPromise.then(  function(){ positionLightbox(lightbox); } )                       //if loaded tableau figures, position lightbox
                  .catch( function(){ console.log('Failed to load tableau figures'); } );   //else print error
  }
  else{
    positionLightbox(lightbox);
  }

}

/**
 * Centers lightbox on screen and positions close icon in upper right of box
 * @param lightbox		the lightbox to position
 */
function positionLightbox(lightbox){
	//position lightbox content
	lightbox.css('max-height','100%');
	lightbox.css('overflow-y','auto');
  if(lightbox.attr('id') == 'sampleStatsMore'){
    lightbox.css('height', '100%');
  }
  else{
	   lightbox.css('height', lightbox.naturalHeight);
  }
	var boxHeight = lightbox.outerHeight();
	var windowHeight = window.innerHeight;
	if(boxHeight > windowHeight){
		boxHeight = windowHeight - 70;	//-70 is to avoid some lightbox content being cut off at the bottom
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
  var closeIcon = lightbox.find('.closeIcon');
  closeIcon.css('top', top - (closeIcon.outerHeight() - closeIcon.height())/2);
  var newLeft = left + boxWidth - closeIcon.outerWidth();
  if((lightbox.height() + 'px') == lightbox.css('max-height')){
    newLeft -= 15;   //if scrollbar is showing, shift the close icon over
  }
  closeIcon.css('left', newLeft);
}

/*
 * Closes the lightbox with the given close icon
 * @param xIcon		the X icon that was clicked
 */
function closeLightboxByIcon(xIcon){
  var lightbox = $(xIcon).parent();
  lightbox.css('display', 'none');
  $('#darkBack').css('display', 'none');
  $('body').removeClass('noScroll'); //re-enable scroll for content behind lightbox
}

/*
 * Closes the lightbox with the matching id
 * @param id		the id of the lightbox to close
 */
function closeLightboxById(id){
  $("#" + id).css('display', 'none');
  $('#darkBack').css('display', 'none');
  $('body').removeClass('noScroll'); //re-enable scroll for content behind lightbox
}

/*
 * Adjusts the number of projects displayed per row based on the window viewport width
 */
function handleResize(){
	$('.lightbox').each(function(index, item){
		if($(item).css('display') == "block"){
			positionLightbox($(item));
		}
	});
}
