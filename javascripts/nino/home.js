$('.video').click(function(e) {
    let BtnIDdiv = $(this).attr('data-idVideo');
    let statusVid = $(this).attr('data-status');
    if (statusVid === "1") {
        window.location.href = "/nino/player?video="+BtnIDdiv;
    }
})