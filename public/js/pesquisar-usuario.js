const buscarDados = () => {
    $.ajax({
        type: 'post',
        url: 'http://127.0.0.1/web-store/usuario/ver',
        data: {
            pesquisa: $('#user-search').val(),
        },
        success: function(r) {
            dados = JSON.parse(r);
            $('#user-list').html('');
            dados.forEach(user =>{
                
                $('#user-list').append(`<tr><td><img src="http://127.0.0.1/web-store/files/usuarios/perfil/${user['profile_picture']}" alt=""
                width="32px"><a href="http://127.0.0.1/web-store/usuario/ver/${user['id_usuario']}">${user['nome']}</a></td>
                <td>${user['email']}</td>
                <td class="text-center">${user['total_vendas']}</td></tr>`);
                
            });

        }        
    });
}

$('#user-search').on('keyup', () =>{
    buscarDados();
})

buscarDados();