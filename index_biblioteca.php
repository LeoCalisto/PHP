<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Biblioteca</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php 
        
        include_once('conexao.php');
 
        if (isset($_GET["coddel"])){
            
            $codigo = $_GET["coddel"];
            $dados = mysqli_query($GLOBALS['conexao'], "DELETE FROM livro WHERE codigo='$codigo'");
        }

        if (isset($_POST["saveLivro"])){
            cadastrarLivro();
        }

        if (isset($_GET["alugdel"])){
            
            $cod_aluguel = $_GET["alugdel"];
            $dados = mysqli_query($GLOBALS['conexao'], "DELETE FROM aluguel WHERE cod_luguel='$cod_aluguel'");
        }

        if (isset($_POST["saveAluguel"])){
            cadastrarAluguel();
        }

        if(isset($_GET["codigo"])){

            $codigo = $_GET["codigo"];

            $ver = mysqli_query($GLOBALS['conexao'], "SELECT * FROM livro WHERE codigo = '$codigo'");
            $dados = mysqli_fetch_assoc($ver);

            $titulo = $dados["titulo"];
            $autor = $dados["autor"];
            $ano = $dados["ano"];
            $genero = $dados["genero"];
        }   

    ?>
   
    <header>Sistema de Biblioteca</header>
    <!--Formulario de cadastramento do livro-->
    <fieldset id="fild_livro">
        <legend>Cadastro de livros</legend>
        <form action="" method="post" autocomplete="off">
            
            <div  class="input_livro">
                <label for="inome">Titulo:</label><br>
                <input type="text" name="titulo" id="ititulo" value="<?php echo empty($_GET["codigo"]) ? '' : $titulo?>">
            </div>

            <div  class="input_livro">
                <label for="iautor">Autor:</label><br>
                <input type="text" name="autor" id="iautor" value="<?php echo empty($_GET["codigo"]) ? '' : $autor?>">
            </div>

            <div class="input_livro">
                <label for="iano">Ano:</label><br>
                <input type="number" name="ano" id="iano" value="<?php echo empty($_GET["codigo"]) ? '' : $ano?>">
            </div>

            <div class="input_livro" >
                <label for="igenero">Gênero:</label><br>
                <input type="text" name="genero" id="igenero" value="<?php echo empty($_GET["codigo"]) ? '' : $genero?>">
            </div>

            <div id="cent" class="input_livro">
                <input type="submit" value="Salvar" name="saveLivro" class="btn_livro">
                <input type="reset" value="Limpar" name="clear" class="btn_livro">
                <?php 
                    include_once('conexao.php');
                    if(isset($_GET["codigo"])){
                        echo "<input type='submit' value='Alterar' onmouseout='mudarUrl()' name='alter' class='btn_livro'>";
                    }
                    if (isset($_POST["alter"])){
                        alterar();
                    }
                ?>
            </div>
        </form>
    </fieldset>
    
    <!--Tabela de visualização dos livros cadastrados-->
    <div id="conteiner">
        <table id="table_livro">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Titulo</th>
                    <th>Autor</th>
                    <th>Ano</th>
                    <th>Gênero</th>
                    <th>Status</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    include_once('conexao.php');
                    
                    if (isset($_GET["pesquisar"])){
                        pesquisaLivro();
                    }else{
                        verDadosLivro();
                    }

                ?>
            </tbody>
        </table>
    </div>
    <form id="div_busca_livro" action="" method="get" autocomplete="off">
        <input type="search" name="pesquisar" id="ipesquisar" placeholder="Inserir nome do livro ou codigo">
        <input type="submit" value="buscar">
    </form>
    <hr>
    <!--Div com uma tabela layout de apenas 1 linha e 2 colunas para estruturar horizontalmente o FORM do emprestimo e a tabela de emprestimos-->
    <div id="conteiner1">
        <table id="layout_alugue">
            <tr>
                <td id="td_form_aluguel">
                    <!--Form de emprestimo estruturado no TD(coluna1) da tabela de layout-->
                    <fieldset>
                        <legend>Solicitação de livro</legend>
                        <form action="" id="form_aluguel" method="post">
                            <div>
                                <label for="icod">Cod.Livro:</label><br>
                                <input type="number" name="cod_livro" id="icod">
                            </div>
        
                            <div>
                                <label for="idata">Data:</label><br>
                                <input type="date" name="data" id="idata">
                            </div>

                            <div>
                                <label for="itel">Contato:</label><br>
                                <input type="tel" name="tel" id="itel">
                            </div>
        
                            <div>
                                <label for="inome">Cliente:</label><br>
                                <input type="text" name="nome" id="inome" >
                            </div>

                            <div id="div_btn_aluguel">
                                <input type="submit" value="Salvar" name="saveAluguel" id="submit_aluguel" class="btn_aluguel">
                                <input type="reset" value="Limpar" id="reset_aluguel"  class="btn_aluguel">
                            </div>
                        </form>
                    </fieldset>
                </td>
                <td id="td_table_aluguel">
                    <!--DIV com a tabela de emprestimo estruturado no TD(coluna2) da tabela de layout-->
                    <div id="conteiner2">
                        <table id="table_aluguel">
                            <thead>
                                <tr>
                                    <th>Cod_Aluguel</th>
                                    <th>Cod_Livro</th>
                                    <th>Data</th>
                                    <th>Cliente</th>
                                    <th>Contato</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php 
                                    include_once('conexao.php');
                                    if (isset($_GET["pesquisar_aluguel"])){
                                        pesquisaAluguel();
                                    }else{
                                        verDadosAluguel();
                                    }
                                ?>
                                    
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
        <form id="div_busca_emprestimo" method="get">
            <input type="text" name="pesquisar_aluguel" id="ipesquisar" placeholder="Insira o código do livro">
            <input type="submit" value="buscar" id="busca_emprestimo">
        </form>
    </div>
    <script>
        function mudarUrl(){
            window.location = 'index_biblioteca.php';
        }
    </script>
</body>
</html>