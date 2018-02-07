function showPopup(parent){
  var hoverSrc = $(parent);
  var popup = hoverSrc.next();
  popup.css("display","block");
  popup.css("left",window.event.pageX + 10);  //note that the +10 is to prevent flickering popup if the user "chases" it with the mouse
  popup.css("top",window.event.pageY + 10);
}

function hidePopup(parent){
  $(parent).next().css("display","none");
}

function scrollToSection(id){
  console.log("scrollTo: " + id);
  window.scroll(0,$("#" + id).offset().top - $(header).height());
}

function prepareTableauFigures(){
  var divElement = $('#viz1516382359584');
  var vizElement = $(divElement.find('object')[0]);
  vizElement.width('100%');
  vizElement.height(vizElement.width()*0.50);
  //console.log("divElement.offsetWidth: " + divElement.offsetWidth + ", vizElement.style.height: " + vizElement.style.height)
  var scriptElement = $('<script></script>');
  scriptElement.attr('src','https://public.tableau.com/javascripts/api/viz_v1.js');
  scriptElement.insertBefore(vizElement);
}
