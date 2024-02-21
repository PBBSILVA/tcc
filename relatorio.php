<?php
require_once('PHPMailer/fpdf186/fpdf.php');

function gerarRelatorioPDF() {
    // Conexão com o banco de dados
    include 'config.php'; // Verifique se este arquivo contém a conexão MySQLi

    // Query para obter dados do MySQL
    $sql = "SELECT * FROM produtos";
    $result = mysqli_query($conexao, $sql);

    // Verifica se há resultados
    if (mysqli_num_rows($result) > 0) {
        // Cria uma instância do FPDF
        $pdf = new FPDF();
        $pdf->AddPage();

        // Adiciona o cabeçalho
        $pdf->SetFillColor(200, 220, 255); // Cor 
        $pdf->SetFont('Arial', 'B', 8); //  tamanho da fonte

        // Adiciona cabeçalho da tabela
        $pdf->Cell(10, 10, 'ID', 1, 0, 'C', 1); 
        $pdf->Cell(30, 10, 'Referencia', 1, 0, 'C', 1);
        $pdf->Cell(60, 10, 'Nome', 1, 0, 'C', 1);
        $pdf->Cell(30, 10, 'Categoria', 1, 0, 'C', 1);
        $pdf->Cell(20, 10, 'Unidade', 1, 0, 'C', 1);
        $pdf->Cell(25, 10, 'Preço Compra', 1, 0, 'C', 1);
        $pdf->Cell(25, 10, 'Preço Venda', 1, 0, 'C', 1);
        #$pdf->Cell(35, 10, 'Lucro', 1, 0, 'C', 1); a
        $pdf->Cell(25, 10, 'Estoque', 1, 0, 'C', 1);
        $pdf->Cell(25, 10, 'Est. Mín.', 1, 1, 'C', 1); 

        // Loop através dos resultados do MySQL
        while ($row = mysqli_fetch_assoc($result)) {
            $pdf->Cell(10, 10, $row['id'], 1, 0, 'C');
            $pdf->Cell(30, 10, $row['referencia'], 1);
            $pdf->Cell(60, 10, $row['nome'], 1);
            $pdf->Cell(30, 10, $row['categoria'], 1);
            $pdf->Cell(20, 10, $row['unidade'], 1);
            $pdf->Cell(25, 10, number_format($row['preco_compra'], 2, ',', '.'), 1);
            $pdf->Cell(25, 10, number_format($row['preco_venda'], 2, ',', '.'), 1);
            #$pdf->Cell(35, 10, number_format($row['lucro'], 1, ',', '.') . '%', 1);
            $pdf->Cell(25, 10, $row['estoque'], 1, 0, 'C');
            $pdf->Cell(25, 10, $row['estoque_min'], 1, 1, 'C');
        }

        // Saída do PDF para o navegador
        $pdf->Output('relatorio_produtos.pdf', 'D');
    } else {
        echo 'Nenhum resultado encontrado';
    }
}

// Verifica se o formulário foi enviado
if (isset($_POST['gerarPDF'])) {
    // Chama a função para gerar o PDF
    gerarRelatorioPDF();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar PDF</title>
</head>
<body>

<form method="post">
    <button type="submit" name="gerarPDF">Gerar PDF</button>
</form>

</body>
</html>
