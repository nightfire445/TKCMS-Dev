$('.stall').on('mouseenter', function() {
    desc = $(this).attr('data-desc');
    $('#content').text(desc);
});