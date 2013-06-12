$('a.tabLink').click(function(e) {
    e.preventDefault();
    var href = $(this).attr('href');
    console.log(href);
    //$("#tabz").tabs("url",this,href);
    return false;
});