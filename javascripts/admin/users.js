$('.edit-user').click(function() {
    let user = $(this).data('identifiant');
    if(user !== 'system'){
        window.location.href = '/admin/users?edit&user='+user;
    }
});