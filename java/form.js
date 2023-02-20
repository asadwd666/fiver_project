$(document).ready(function () {
    $('body').addClass('js');

    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        autoSize: true,
        showOn: "button",
      buttonImage: 'https://condosites.net/commons/calendar.png',
      buttonImageOnly: true,
      buttonText: 'Select date',
       showButtonPanel: true,
       onClose: function(dateText, inst) 
    { 
        $(this).attr("disabled", false);
    },
    beforeShow: function(input, inst) 
    {
        $(this).attr("disabled", true);
        
    }
    });

});