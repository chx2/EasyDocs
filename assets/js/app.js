$(document).ready(function() {

  //Accordions
  var accordions = bulmaAccordion.attach();

  //Page notification
  $('.notification').fadeIn('fast');

  //Prevent special characters from being used in file/folder names
  $('input').on('input', function() {
    $(this).val($(this).val().replace(/[^a-zA-Z0-9 -]/g, ''));
  });

  //Sorting
  $(".sortables").click(function() {
    $(this).css('cursor', 'grab');
    $(this).sortable({
      axis: 'y',
      start: function(event, ui){
        $(ui.placeholder).hide(300);
      },
      change: function (event,ui){
        $(ui.placeholder).hide().show(300);
      },
      update: function (event, ui) {
        var data = $(this).sortable('serialize');
        $.post('order', data);
        $(this).css('cursor', 'pointer');
      }
    });
  });

  //Mobile Menu
  $(".navbar-burger").click(function() {

      $(".navbar-burger").toggleClass("is-active");
      $(".navbar-menu").toggleClass("is-active");

  });

  //Delete document
  $(".delete").click(function(e) {
    e.preventDefault();
    if(confirm("Are you sure? All content associated with this element will be lost.")) {
      var data = {
        docname: $(this).data('name'),
        section: $(this).data('section')
      };
      $.post('process', data);
      if ($(this).data('name') == 'no-name') {
        $(this).parent().parent().fadeOut('normal', function() {
          $(this).remove();
        });
      }
      else {
        $(this).parent().fadeOut('normal', function() {
          $(this).remove();
        });
      }
    }
  });

  //Markdown editor
  if ($(document).find('textarea').length > 0) {
    //Reference document for autosaving
    var docstring = $("#docname").val() + $("#section").val();
    console.log(docstring);
    var simplemde = new InscrybMDE({
      autofocus: true,
      forceSync: false
    });
  }

});
