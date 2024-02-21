<?php
session_start();
require("config.php");

if(!isset($_SESSION["id_usuario_logado"])){
  header("Location: login.php");
  exit;
}
function gerarRelatorioPDF($dados) {
  require('PHPMailler/fpdf186/fpdf.php'); // Certifique-se de ajustar o caminho se necessário

  // Configuração inicial do PDF
  $pdf = new FPDF();
  $pdf->AddPage();
  $pdf->SetFont('Arial', '', 12);

  // Adiciona título ao relatório
  $pdf->Cell(0, 10, 'Relatório de Produtos', 0, 1, 'C');

  // Adiciona cabeçalho da tabela
  $pdf->SetFillColor(200, 220, 255);
  $pdf->SetFont('Arial', 'B', 10);
  $pdf->Cell(15, 10, 'ID', 1, 0, 'C', 1);
  $pdf->Cell(30, 10, 'Referência', 1, 0, 'C', 1);
  $pdf->Cell(60, 10, 'Nome', 1, 0, 'C', 1);
  $pdf->Cell(40, 10, 'Categoria', 1, 0, 'C', 1);
  $pdf->Cell(20, 10, 'Unidade', 1, 0, 'C', 1);
  $pdf->Cell(25, 10, 'Preço Compra', 1, 0, 'C', 1);
  $pdf->Cell(25, 10, 'Preço Venda', 1, 0, 'C', 1);
  $pdf->Cell(25, 10, 'Lucro', 1, 0, 'C', 1);
  $pdf->Cell(20, 10, 'Estoque', 1, 0, 'C', 1);
  $pdf->Cell(20, 10, 'Est. Mín.', 1, 1, 'C', 1);

  // Adiciona dados ao relatório
  $pdf->SetFont('Arial', '', 10);
  foreach ($dados as $row) {
      $pdf->Cell(15, 10, $row['id'], 1);
      $pdf->Cell(30, 10, $row['referencia'], 1);
      $pdf->Cell(60, 10, $row['nome'], 1);
      $pdf->Cell(40, 10, $row['categoria'], 1);
      $pdf->Cell(20, 10, $row['unidade'], 1);
      $pdf->Cell(25, 10, number_format($row['preco_compra'], 2, ',', '.'), 1);
      $pdf->Cell(25, 10, number_format($row['preco_venda'], 2, ',', '.'), 1);
      $pdf->Cell(25, 10, number_format($row['lucro'], 1, ',', '.') . '%', 1);
      $pdf->Cell(20, 10, $row['estoque'], 1);
      $pdf->Cell(20, 10, $row['estoque_min'], 1, 1);
  }

  // Salva ou exibe o PDF
  $pdf->Output('relatorio_produtos.pdf', 'I');
}
// tem permissão para excluir?
if(!Permissao::podeExcluir($_SESSION["nivel_acesso"])){
  header("Location: erro_permissao.php");
  exit;  
}
// fim permissão para excluir

// id do produto a ser excluído
$produto = tratar_entrada(utf8_decode(trim($_GET["produto"])));
$nome_produto_exclusao = tratar_entrada(utf8_decode(trim($_GET["nome_produto"])));
// url para voltar depois da exclusao
$url_volta = tratar_entrada($_GET["volta"]);

// precisamos excluir a foto deste produto
$result_ex = mysqli_query($conexao, "SELECT foto FROM produtos WHERE id = '$produto'");
$detalhes_ex = mysqli_fetch_array($result_ex);
$nome_foto = $detalhes_ex["foto"];
// fim excluir a foto do produto

$result = mysqli_query($conexao, "DELETE FROM produtos WHERE id = '$produto'");
if($result){
  unlink($diretorio_fotos_produtos . '/' . $nome_foto . '.png');
  
  // vamos registrar esse log
  $ip = getUserIpAddr();
  $id_usuario_logado = $_SESSION["id_usuario_logado"];
  $usuario_logado = $_SESSION["usuario_logado"];
  $texto_log = 'O usuario ' . $usuario_logado . ' excluiu o produto ' . $nome_produto_exclusao . '.';
  $result_2 = mysqli_query($conexao, "INSERT into logs values (null, '$id_usuario_logado', '$texto_log', 
    NOW(), '$usuario_logado', '$ip')");
  // fim registrar o log
  
  header("Location: $url_volta");
  exit; 
}
else{
  $_SESSION["erro_banco_dados"] = "Houve um erro no cadastro de produtos. Verifique se existe entradas no estoque para este produto antes de efetuar a exclusao.<br><br>Erro: " . mysqli_error($conexao);
  header("Location: erro_banco_dados.php");
  exit;  
} 
?>
