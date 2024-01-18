$('.edit-user').click(function() {
    let user = $(this).data('identifiant');
    window.location.href = '/admin/users?edit&user='+user;
});