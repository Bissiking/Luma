$('.video').click(function(e) {
    let BtnIDdiv = $(this).attr('data-idVideo');
    console.log(BtnIDdiv);
    window.location.href = "/nino/player?video="+BtnIDdiv;
})