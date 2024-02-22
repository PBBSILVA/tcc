
<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
  require("config.php");
  // o usu�rio est� logado?
  if(!isset($_SESSION["id_usuario_logado"])){
    header("Location: login.php");
    exit;
  }

  header("Cache-Control: no-cache, must-revalidate");
  header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
  header("Content-Type: text/xml");

 // tem permiss�o para excluir?
  if(!Permissao::podeExcluir($_SESSION["nivel_acesso"])){
	header("Location: erro_permissao.php");
    exit;  
  }
  // fim permiss�o para cadastrar

$id_usuario_logado = $_SESSION["id_usuario_logado"];
$id_item_entrada = tratar_entrada(imap_utf8(trim($_POST["id_item_entrada"])));
$id_entrada = tratar_entrada(imap_utf8(trim($_POST["id_entrada"])));
$id_produto = tratar_entrada(imap_utf8(trim($_POST["id_produto"])));
$quantidade = tratar_entrada(imap_utf8(trim($_POST["quantidade"])));
$preco_unitario = tratar_entrada(imap_utf8(trim($_POST["preco_unitario"])));
$preco_total = tratar_entrada(imap_utf8(trim($_POST["preco_total"])));

  // id	id_produto	id_entrada	valor_unitario	quantidade
  $result = mysqli_query($conexao, "DELETE FROM itens_entrada WHERE id = '$id_item_entrada'");
	 
  if($result){
	 
	 // vamos atualizar o estoque deste produto
	 $result = mysqli_query($conexao, "UPDATE produtos SET estoque = (estoque - '$quantidade') WHERE id = '$id_produto'");
	 // fim atualizar o estoque deste produto
	 
	 // vamos atualizar a entrada
	 $result = mysqli_query($conexao, "UPDATE entradas SET quant_itens = (quant_itens - '$quantidade'),
	   quant_produtos = (quant_produtos - 1), valor_nota = (valor_nota - '$preco_total') WHERE id = '$id_entrada'");
	 // fim atualizar a entrada
	 
echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n";
echo "<mensagens>\n";
  
echo "  <mensagem>\n";
echo "    <texto>" . $id_item_entrada . "</texto>\n";
echo "  </mensagem>\n";
echo "</mensagens>\n";
   
  }
  else{
	echo "<h1>Houve um erro no cadastro de entradas: " . mysqli_error($conexao) . "</h1>";  
  }
?>
