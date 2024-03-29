<?php
session_start();
  require("config.php");
  // o usuĂĄrio estĂĄ logado?
  if(!isset($_SESSION["id_usuario_logado"])){
    header("Location: login.php");
    exit;
  }

  // tem permissão para cadastrar?
  if(!Permissao::podeCadastrar($_SESSION["nivel_acesso"])){
	header("Location: erro_permissao.php");
    exit;  
  }
  // fim permissão para cadastrar 

$id_usuario_logado = $_SESSION["id_usuario_logado"];
$referencia = tratar_entrada(utf8_decode(trim($_POST["referencia"])));
$nome = tratar_entrada(utf8_decode(trim($_POST["nome"])));
$descricao = tratar_entrada(utf8_decode(trim($_POST["descricao"])));
$categoria = tratar_entrada(utf8_decode(trim($_POST["categoria"])));

// trata o preço
$preco_venda = tratar_entrada(utf8_decode(trim($_POST["preco_venda"])));
$preco_venda = str_replace(".", "", $preco_venda);
$preco_venda = str_replace(",", ".", $preco_venda);
// fim tratar o preço

$estoque_minimo = tratar_entrada(utf8_decode(trim($_POST["estoque_minimo"])));
$unidade = tratar_entrada(utf8_decode(trim($_POST["unidade"])));
$foto = tratar_entrada(utf8_decode(trim($_POST["foto"])));
  
  $hoje = date('d-m-Y');
  if(file_exists($diretorio_fotos_produtos . '/temp/' . $hoje . '/' . $foto . '.png')){
	 rename($diretorio_fotos_produtos . '/temp/' . $hoje . '/' . $foto . '.png', 
	    $diretorio_fotos_produtos . '/' . $foto . '.png');
  }
  
  $result = mysqli_query($conexao, "INSERT into produtos values (null, '$referencia', '$nome', '$descricao', '$categoria',
	 '0', '$preco_venda', '0', '$estoque_minimo', '$unidade', '$foto', NOW(), '$id_usuario_logado')");
	 
  if($result){
	 
	    // vamos registrar esse log
  $ip = getUserIpAddr();
  $id_usuario_logado = $_SESSION["id_usuario_logado"];
  $usuario_logado = $_SESSION["usuario_logado"];
  $texto_log = 'O usuario ' . $usuario_logado . ' cadastrou o produto ' . $nome . '.';
  $result_2 = mysqli_query($conexao, "INSERT into logs values (null, '$id_usuario_logado', '$texto_log', 
    NOW(), '$usuario_logado', '$ip')");
  // fim registrar o log 
	 
	 header("Location: novo_produto.php?sucesso=ok");
     exit; 
  }
  else{
	$_SESSION["erro_banco_dados"] = "Houve um erro no cadastro de produtos. Verifique se ja existe um produto com esta referencia.<br><br>Erro: " . mysqli_error($conexao);
  header("Location: erro_banco_dados.php");
  exit;  
  }
?>
