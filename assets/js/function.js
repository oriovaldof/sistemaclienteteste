/**
 * Created by oriovaldo fialho on 22/11/16.
 * Abstract: arquivo responsavel pelas funcoes JS
 */

$(function(){
    loadTypeClient('');

    $('#clientTipo').change(function(){
        var typeClient = this.value;
        loadTypeClient(typeClient);
    });

    grid();


});
//respnsavel por chamar a grid de dados
function grid(){
    $.ajax({
        url:URLSite+'modules/client/controller/client.php?Op=grid',
        type: "POST",
        datatype: "html",
        success:function(data){
            $('#bodyGrid').html('');
            $('#bodyGrid').html(data);
            $('#datatable').DataTable();
        }
    });
}
//verifica ql o tipo do fornecedor de seta a mascara correspondente
function loadTypeClient(type){
    if(type== ""){
        $('#contentDados').hide();
    }else{
        if(type == "PJ"){
            $('#nameType').text('Razão Social');
            $('#nameDoc').text('CNPJ');
            $('#nameFantasy').show();
            $('#contentDados').show();
            $('#clientCpfCnpj').val('');
            $('#clientCpfCnpj').mask('00.000.000/0000-00');
        }else{
            $('#nameFantasy').hide();
            $('#nameType').text('Nome Cliente');
            $('#nameDoc').text('CPF');
            $('#clientCpfCnpj').val('');
            $('#clientCpfCnpj').mask('000.000.000-00');
            $('#contentDados').show();
        }
    }
}
//responsavel pelo visualizar
function vis(cod){
    $.ajax({
        url:URLSite+'modules/client/controller/client.php?Op=vis',
        type: "POST",
        datatype: "json",
        data:{'clientCod':cod},
        success:function(data){
            var obj = $.parseJSON(data);

            $('#contentForm').html(obj.returnHtml);
            $('#contentForm').show();
            $('#contentButton').hide();
            $('#contentGrid').hide();
        }
    });
}
//responsavel por resgatar os dados e setar nos campos do form
function edit(cod){

        $.ajax({
            url:URLSite+'modules/client/controller/client.php?Op=edit',
            type: "POST",
            datatype: "json",
            data:{'clientCod':cod},
            success:function(data){
                var obj = $.parseJSON(data);
                if(obj.action == "S"){
                    loadTypeClient(obj.clientTipo);
                    $('#Id').val(obj.clientCod);
                    $('#clientCod').val(obj.clientCod);
                    $('#clientTipo').val(obj.clientTipo);
                    $('#clientNomeRazaoSocial').val(obj.clientNomeRazaoSocial);
                    $('#clientCpfCnpj').val(obj.clientCpfCnpj);
                    $('#contentContact').html(obj.htmlContact);
                    $('#contentAddress').html(obj.htmlAdress);
                    $('.classaddressZipCode').mask('00.0000-000');
                    $('.classContactPhone').mask(SPMaskBehavior, spOptions);



                    register();
                }else{
                    alert(obj.Message);
                }
            }
        });

}
function deleter(cod){
    if(confirm('Tem certeza que deseja remover este registro?')){
        $.ajax({
            url:URLSite+'modules/client/controller/client.php?Op=delete',
            type: "POST",
            datatype: "json",
            data:{'clientCod':cod},
            success:function(data){
                var obj = $.parseJSON(data);
                if(obj.action == "S"){
                    alert(obj.Message);
                    returnGrid();
                }else{
                    alert(obj.Message);
                }
            }
        });
    }
}
//funcao comum no formulario de acordo com ação chama o insert ou update
function registerUpdate(){
    var id              = $('#Id').val();
    var clientCod       = $('#clientCod').val();
    var clientTipo      = $('#clientTipo').val();
    var clientNome      = $('#clientNomeRazaoSocial').val();
    var clientDoc       = $('#clientCpfCnpj').val();
    var insertupdate    = 0;

    if(clientTipo == ""){
        alert('O Tipo do Cliente deve ser informado');
        $('#clientTipo').focus();
        insertupdate = insertupdate + 1;
        return false;
    }

    if(clientNome == ""){
        if(clientTipo == "PJ"){
            alert('A Razão Social do Cliente deve ser informado');
        }else{
            alert('O Nome do Cliente deve ser informado');
        }
        $('#clientNomeRazaoSocial').focus();
        insertupdate = insertupdate + 1;
        return false;
    }
    if(clientDoc == ""){
        if(clientTipo == "PJ"){
            alert('O CNPJ do Cliente deve ser informado');
        }else{
            alert('O CPF do Cliente deve ser informado');
        }
        $('#clientCpfCnpj').focus();
        insertupdate = insertupdate + 1;
        return false;
    }


    if(insertupdate == 0){
        if((id != "")&& (clientCod != "")){
            if(id === clientCod){
                $.ajax({
                    url:URLSite+'modules/client/controller/client.php?Op=updatClient',
                    type: "POST",
                    datatype: "json",
                    data:$('#formCrud').serialize(),
                    success:function(data){
                        var obj = $.parseJSON(data);
                        if(obj.action == "S"){
                            alert(obj.Message);
                            returnGrid();
                            grid();
                        }else{
                            alert(obj.Message);
                        }
                    }
                });

            }else{
                alert('Ocorreu um erro inesperado por favor atualize a sua tela');
            }
        }else{
            $.ajax({
                url:URLSite+'modules/client/controller/client.php?Op=registerClient',
                type: "POST",
                datatype: "json",
                data:$('#formCrud').serialize(),
                success:function(data){
                    var obj = $.parseJSON(data);
                    if(obj.action == "S"){
                        alert(obj.Message);
                        returnGrid();
                        grid();
                    }else{
                        alert(obj.Message);
                    }
                }
            });
        }
    }



}
//abre o formulario para o cadastro
function register(){
    $('#contentForm').show();
    $('#contentButton').hide();
}
//retorna a grid restaurando os formulario em seu estado nativo
function returnGrid(){
    $('.cleanField').val('');
    $('#contentContact').html('');
    $('#contentAddress').html('');
    $('#contentDados').hide();
    $('#contentForm').hide();
    $('#contentButton').show();
    window.location.href = URLSite;
}
//adiciona div Contato
function addContact(){
    $.ajax({
        url:URLSite+'modules/client/controller/client.php?Op=addContact',
        type: "POST",
        datatype: "json",
        success:function(data){
            var obj = $.parseJSON(data);
            $('#contentContact').show();
            $('#contentContact').append(obj.returnHtml);
            confContactValue(obj.returnCod);
        }
        });
}
//adicionar Div Endereço
function addAddress(){
    $.ajax({
        url:URLSite+'modules/client/controller/client.php?Op=addAddress',
        type: "POST",
        datatype: "json",
        success:function(data){
            var obj = $.parseJSON(data);
            $('#contentAddress').show();
            $('#contentAddress').append(obj.returnHtml);
            confAddress(obj.returnCod);
        }
        });
}
//seta mascara
function confAddress(cod){
    $('#addressZipCode'+cod).mask('00.000-000');

}
//remove div contato
function removeContact(cod){
    if(confirm('Tem Certeza que Deseja Remover o Contato')){
        $('#divContact'+cod).remove();
    }
}
//remove div endereço
function removeAddress(cod){
    if(confirm('Tem Certeza que Deseja Remover o Endereço')){
        $('#divAddress'+cod).remove();
    }
}
//seta variaveis para mascara de novo padrao de telefone
var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    spOptions = {
        onKeyPress: function(val, e, field, options) {
            field.mask(SPMaskBehavior.apply({}, arguments), options);
        }
    };
//seta mascara contato
function confContactValue(cod){
    var type = $('#contactType'+cod).val();
    if(type=="TL"){
        $('#spanContactValue'+cod).text('Telefone:');
        $('#contactValue'+cod).val('');
        $('#contactValue'+cod).mask(SPMaskBehavior, spOptions);
    }else{
        $('#spanContactValue'+cod).text('E-mail:');
        $('#contactValue'+cod).val('');
        $('#contactValue'+cod).unmask();

    }

}
//efetua validacao de email
function validaFormContact (cod){
    var type = $('#contactType'+cod).val();
    if(type=="EM"){

        var email = $('#contactValue'+cod).val();
        if(email != ""){
            var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
            if(!filter.test(email)){
                alert('Por favor, digite o email corretamente');
                $('#contactValue'+cod).val('');
                $('#contactValue'+cod).focus();
                return false
            }
        }

    }


}
//efetua validação CPF / CNPJ
function validDoc(){
    var clientTipo          = $('#clientTipo').val();
    var clientCpfCnpj       = $('#clientCpfCnpj').val();

    if(clientCpfCnpj != ""){
        if(clientTipo == "PJ"){
            if(!validCNPJ(clientCpfCnpj)){
                alert('O CNPJ é invalido!');
                $('#clientCpfCnpj').val('');
                $('#clientCpfCnpj').focus('');
            }

        }else{
            if(!validCPF(clientCpfCnpj)){
                alert('O CPF é invalido!');
                $('#clientCpfCnpj').val('');
                $('#clientCpfCnpj').focus('');
            }
        }
    }


}
function validCPF(cpft){
    var numeros, digitos, soma, i, resultado, digitos_iguais;
    digitos_iguais = 1;
    var cpf = limpaStringCPFCNPJ(cpft);

    if (cpf.length < 11)
        return false;
    for (i = 0; i < cpf.length - 1; i++)
        if (cpf.charAt(i) != cpf.charAt(i + 1))
        {
            digitos_iguais = 0;
            break;
        }
    if (!digitos_iguais)
    {
        numeros = cpf.substring(0,9);
        digitos = cpf.substring(9);
        soma = 0;
        for (i = 10; i > 1; i--)
            soma += numeros.charAt(10 - i) * i;
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
            return false;
        numeros = cpf.substring(0,10);
        soma = 0;
        for (i = 11; i > 1; i--)
            soma += numeros.charAt(11 - i) * i;
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1))
            return false;
        return true;
    }
    else
        return false;
}
function validCNPJ(cnpjT){
    var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
    digitos_iguais = 1;
    var cnpj = limpaStringCPFCNPJ(cnpjT);

    if (cnpj.length < 14 && cnpj.length < 15)
        return false;
    for (i = 0; i < cnpj.length - 1; i++)
        if (cnpj.charAt(i) != cnpj.charAt(i + 1))
        {
            digitos_iguais = 0;
            break;
        }
    if (!digitos_iguais)
    {
        tamanho = cnpj.length - 2
        numeros = cnpj.substring(0,tamanho);
        digitos = cnpj.substring(tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--)
        {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
            return false;
        tamanho = tamanho + 1;
        numeros = cnpj.substring(0,tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--)
        {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1))
            return false;
        return true;
    }
    else
        return false;


}

function limpaStringCPFCNPJ(string){
    string = string.replace(".","");
    string = string.replace(".","");
    string = string.replace(".","");
    string = string.replace("/","");
    string = string.replace("-","");
    return string;

}
