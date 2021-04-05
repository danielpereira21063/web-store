$(document).ready(function(){
    const nome = $('#nome');
    const email = $('#email');
    const senha = $('#senha');
    const novaSenha = $('#nova-senha');
    $('#btn-editar-perfil').on('click', ()=> {
        let erros = 0;
        if(nome.val() == '') {
            nome.addClass('is-invalid');
            $('#nome-erro').html('Preencha este campo')
            erros ++;
        } else {
            nome.removeClass('is-invalid');
            $('#nome-erro').html('');
        }
        if(email.val() == '') {
            email.addClass('is-invalid');
            $('#email-erro').html('Preencha este campo');
            erros ++;
        } else {
            email.removeClass('is-invalid');
            $('#email-erro').html('');
        }
        if(senha.val() == '') {
            senha.addClass('is-invalid');
            $('#senha-erro').html('Preencha este campo')
            erros ++;
        } else {
            senha.removeClass('is-invalid');
            $('#senha-erro').html('');
        }

        if(erros == 0) {
            if($('#form-editar-perfil').submit()) {
            
            }
        }
    });

    $('#label-alterar-foto').on('click', ()=>{
        $('#profile-picture').removeClass('d-none');
    });

    $('#btn-alterar-senha').on('click', ()=>{
        const form = $('#div-editar-perfil');
        const form_editar_senha = `
        <div class="form-group">
            <label for='nova-senha'>Nova senha: </label>
            <input class="form-control text-center" type='password'
            name='nova-senha' id='nova-senha' placeholder="Informe sua nova senha">
            <div class="invalid-feedback" id="nova-senha-erro"></div>
        </div>
        `;
        form.append(form_editar_senha);
        $('#btn-alterar-senha').hide();
    });
});