# sistemaclienteteste
Sistema de crud basico para cadastro de Cliente

Neste repositorio segue pasta BD com o sql do Banco de Dados;

Estrutura Breve
-include_archives.php --> responsavel por carregar os includes
-assets --> pasta responsavel por receber arquivos js e css
-framework
    |----->config---->conn.php // configuração do BD
    |----->connection---->connection.php // Classe de conexao PDO utilizando Singleton
    |----->object---->object.php // arquivo responsavel resgatar os valores das globais, o unico arquivo que vai interagir com globais neste arquivo pode ser feito tbm os tratamentos para inserção no BD
-modules-->pasta responsavel em receber os modulos

Configurações necessarias
Banco de Dados
acessar o arquivo conn.php, localizado na pasta framework/config/conn.php

Url do Site
acessar o arquivo include_archives.php e altera o valor da session $_SESSION['UrlSite'];

Template Utilizado
Gentelella - Bootstrap Admin Template by Colorlib
 https://github.com/puikinsh/gentelella


