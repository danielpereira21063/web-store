$(document).ready(function(){
    const profile_picture = $('#profile_picture');
    const nome = $('#nome');
    const email = $('#email');
    $('#btn-editar-perfil').on('click', () => {
        console.log(profile_picture);
        console.log(nome);
        console.log(email);
    });
});