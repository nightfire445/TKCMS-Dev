//code for hover of vendors
$(document).ready( function() {
  $('.stall').on('mouseenter', function() {
      desc = $(this).attr('data-desc');
      $('#content').text(desc);
  });
});
