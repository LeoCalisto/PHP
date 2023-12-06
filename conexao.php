<?php 
    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'biblioteca';

    $conexao = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);

    $db = mysqli_query($GLOBALS['conexao'], "CREATE TABLE  IF NOT EXISTS livro(
        `codigo` INT NOT NULL AUTO_INCREMENT,
        `titulo` VARCHAR(100) NOT NULL,
        `autor` VARCHAR(45) NOT NULL,
        `ano` VARCHAR(4) NOT NULL,
        `genero` VARCHAR(45) NOT NULL,
        `status` VARCHAR(45) NOT NULL,
        PRIMARY KEY (`codigo`)
    )");
    $db2 = mysqli_query($GLOBALS['conexao'], "CREATE TABLE IF NOT EXISTS aluguel (
        `cod_luguel` INT NOT NULL AUTO_INCREMENT,
        `cod_livro` INT NOT NULL,
        `data` DATE NOT NULL,
        `nome_cliente` VARCHAR(100) NOT NULL,
        `contato` VARCHAR(15) NOT NULL,
        PRIMARY KEY (`cod_luguel`)
    )");


    function cadastrarLivro(){
        $titulo = $_POST["titulo"];
        $autor =  $_POST["autor"];
        $ano =  $_POST["ano"];
        $genero =  $_POST["genero"];
        $status = "disponível";

        $inserir = mysqli_query($GLOBALS['conexao'], "INSERT INTO livro(titulo,autor,ano,genero,status) 
        VALUES('$titulo','$autor','$ano','$genero','$status')");
    }


    function verDadosLivro(){
        $ver = mysqli_query($GLOBALS['conexao'], "SELECT * FROM livro");
        while ($dados = mysqli_fetch_assoc($ver)){

            echo "<tr>";
            echo "<td class='colum_menor'>".$dados["codigo"]."</td>";
            echo "<td>".$dados["titulo"]."</td>";
            echo "<td>".$dados["autor"]."</td>";
            echo "<td class='colum_menor'>".$dados["ano"]."</td>";
            echo "<td class='colum_menor'>".$dados["genero"]."</td>";
            echo "<td class='colum_menor'>".$dados["status"]."</td>";
            echo "<td class='colum_menor'>
            <a id='btn_editar' href='index.php?codigo=$dados[codigo]'>Editar</a>
            <a id='btn_apagar' name='del' href='index.php?coddel=$dados[codigo]'>Apagar</a></td>";
            echo "</tr>";
        }
    }


    function pesquisaLivro(){
        $chave = $_GET["pesquisar"];
        $ver = mysqli_query($GLOBALS['conexao'], "SELECT * FROM livro WHERE codigo LIKE '%$chave%' OR autor LIKE '%$chave%' OR titulo LIKE '%$chave%' ORDER BY codigo DESC");
        while ($dados = mysqli_fetch_assoc($ver)){

            echo "<tr>";
            echo "<td class='colum_menor'>".$dados["codigo"]."</td>";
            echo "<td>".$dados["titulo"]."</td>";
            echo "<td>".$dados["autor"]."</td>";
            echo "<td class='colum_menor'>".$dados["ano"]."</td>";
            echo "<td class='colum_menor'>".$dados["genero"]."</td>";
            echo "<td class='colum_menor'>".$dados["status"]."</td>";
            echo "<td class='colum_menor'>
            <a id='btn_editar' href='index.php?codigo=$dados[codigo]'>Editar</a>
            <a id='btn_apagar' name='del' href='index.php?coddel=$dados[codigo]'>Apagar</a></td>";
            echo "</tr>";
        }
    }
   

    function cadastrarAluguel(){

        $cod_livro = $_POST["cod_livro"];
        $data = $_POST["data"];
        $tel = $_POST["tel"];
        $nome_cliente = $_POST["nome"];
        $ver = mysqli_query($GLOBALS['conexao'], "SELECT * FROM livro WHERE codigo = '$cod_livro' AND status = 'disponível'");

        if(mysqli_num_rows($ver) > 0){

            $inserirAluguel = mysqli_query($GLOBALS['conexao'], "INSERT INTO aluguel(cod_livro,data,nome_cliente,contato) 
            VALUES('$cod_livro','$data','$nome_cliente','$tel')");
    
            $atualizarDisponibilidade = mysqli_query($GLOBALS['conexao'], "UPDATE livro SET status = 'indisponível' WHERE codigo = '$cod_livro'");

        } else {
            print("<script> alert('Livro já alugado')</script>");
        }
    }

    function verDadosAluguel(){
        $ver = mysqli_query($GLOBALS['conexao'], "SELECT * FROM aluguel");
        while ($dados = mysqli_fetch_assoc($ver)){

            echo "<tr>";
            echo "<td class='colum_menor'>".$dados["cod_luguel"]."</td>";
            echo "<td class='colum_menor'>".$dados["cod_livro"]."</td>";
            echo "<td class='colum_menor'>".$dados["data"]."</td>";
            echo "<td>".$dados["nome_cliente"]."</td>";
            echo "<td class='colum_menor'>".$dados["contato"]."</td>";
            echo "<td class='colum_menor'>
            <a id='btn_editar' href='index.php?cod_aluguel=$dados[cod_luguel]'>Editar</a>
            <a id='btn_apagar' name='del' href='index.php?alugdel=$dados[cod_luguel]'>Apagar</a></td>";
            echo "</tr>";
        }
    }
    

    function pesquisaAluguel(){
        $chave = $_GET["pesquisar_aluguel"];
        $ver = mysqli_query($GLOBALS['conexao'], "SELECT * FROM aluguel WHERE cod_luguel LIKE '%$chave%' OR nome_cliente LIKE '%$chave%' ORDER BY cod_luguel DESC");
        while ($dados = mysqli_fetch_assoc($ver)){

            echo "<tr>";
            echo "<td class='colum_menor'>".$dados["cod_luguel"]."</td>";
            echo "<td class='colum_menor'>".$dados["cod_livro"]."</td>";
            echo "<td class='colum_menor'>".$dados["data"]."</td>";
            echo "<td>".$dados["nome_cliente"]."</td>";
            echo "<td class='colum_menor'>".$dados["contato"]."</td>";
            echo "<td class='colum_menor'>
            <a id='btn_editar' href='index.php?cod_aluguel=$dados[cod_luguel]'>Editar</a>
            <a id='btn_apagar' name='del' href='index.php?alugdel=$dados[cod_luguel]'>Apagar</a></td>";
            echo "</tr>";
        }
    }
   

    function alterar(){

        $titulo = $_POST["titulo"];
        $autor =  $_POST["autor"];
        $ano =  $_POST["ano"];
        $genero =  $_POST["genero"];

        $inserir = mysqli_query($GLOBALS['conexao'], "UPDATE livro SET titulo = '$titulo',autor = '$autor',ano = '$ano',genero = '$genero' 
        WHERE codigo = '$_GET[codigo]'");
    }


    function alterarAluguel(){

        $cod_livro = $_POST["cod_livro"];
        $data = $_POST["data"];
        $nome_cliente = $_POST["nome"];
        $contato = $_POST["tel"];

        $inserir = mysqli_query($GLOBALS['conexao'], "UPDATE aluguel SET cod_livro = '$cod_livro', data = '$data', contato = '$contato',nome_cliente = '$nome_cliente' 
        WHERE cod_luguel = '$_GET[cod_aluguel]'"); 
    }
?>
