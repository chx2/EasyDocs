$(document).ready(function() {

  //Accordions
  var accordions = bulmaAccordion.attach();

  //Delete document
  $(".remove").click(function(e) {
    e.preventDefault();
    if(confirm("Are you sure? All content associated with this element will be lost.")) {
      var data = {
        docname: $(this).data('name'),
        section: $(this).data('section')
      };
      $.post('process', data);
      if ($(this).data('name') == 'no-name') {
        location.reload();
      }
      else {
        $(this).parent().fadeOut('normal', function() {
          $(this).remove();
        });
      }
    }
  });

  //Export
  $('.export-form').submit(function(e) {
    e.preventDefault();
    if($('input[type="checkbox"]:checked', this).length > 0){
      e.currentTarget.submit();
    }
    else{
      bulmaToast.toast({
        message: "Please select a section to export",
        type: "is-danger",
        position: "top-center",
        dismissible: true,
        animate: { in: 'fadeIn', out: 'fadeOut' }
      });
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

  //Mobile Menu
  $(".navbar-burger").click(function() {
    $(".navbar-burger").toggleClass("is-active");
    $(".navbar-menu").toggleClass("is-active");
  });

  //Modal
  $('.modal-toggle').click(function(e) {
    e.preventDefault();
    $(document).find('.modal').first().fadeIn()
  });
  $('.modal-background').click(function(e) {
    e.preventDefault();
    $(document).find('.modal').first().fadeOut()
    $(document).find('.modal').first().next().fadeOut()
  });
  $('.close').click(function(e) {
    e.preventDefault();
    $(document).find('.modal').first().fadeOut()
    $(document).find('.modal').first().next().fadeOut()
  });

  //Page notification
  $('.notification').fadeIn('fast');

  //Prevent special characters from being used in file/folder names
  $('input').on('input', function() {
    $(this).val($(this).val().replace(/[^a-zA-Z0-9 -]/g, ''));
  });

  //Section
  $('.section-order').click(function(e) {
    e.preventDefault();
    $(document).find('.modal').first().next().fadeIn()
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
        bulmaToast.toast({
          message: "Order has been updated",
          type: "is-success",
          position: "top-center",
          dismissible: true,
          animate: { in: 'fadeIn', out: 'fadeOut' }
        });
        $.post('order', data);
        $(this).css('cursor', 'pointer');
      }
    });
  });

});
