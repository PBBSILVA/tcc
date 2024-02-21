<?php
  session_start();
    require("config.php");    
  if(!isset($_SESSION["id_usuario_logado"])){
    header("Location: login.php");
    exit;
  }
?>
<!DOCTYPE html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Controle de Estoque - P&aacute;gina Inicial</title>
  <link rel="stylesheet" href="bootstrap-icons-1.5.0/font/bootstrap-icons.css" />
  <link href="css/styles.css?<?= date('Y-m-d_H:i:s'); ?>" rel="stylesheet" />
  <script src="font-awesome/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">

<?php require("cima.php"); ?>

<div id="layoutSidenav">
            
            <?php require("menu_lado.php"); ?>
            
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4"><i class="bi-bar-chart-line"></i> P&aacute;gina Inicial</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Vis&atilde;o Geral do Controle de Estoque</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">
                                    
                                    <table height="100%">
                                                               <tr>
                                        <td>
                                          
                                          <?php
										    // obt�m a quantidade de produtos cadastrados no sistema
											$result = mysqli_query($conexao, "SELECT id FROM produtos");
                                            $quant = mysqli_num_rows($result);
											echo $quant . ' Produtos Cadastrados';
                      
										  ?>
                                          
                                        </td>
                                      </tr>
                                    </table>
                                    
                                    </div>
                                    
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="produtos.php">Ver Rela&ccedil;&atilde;o de Produtos</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">
                                    
                                    <table height="100%">
                                      <tr>
                                        <td>
                                          
                                          <?php
										    // obt�m os produtos com estqoue zerado
											$result = mysqli_query($conexao, "SELECT id FROM produtos WHERE estoque = 0");
                                            $quant = mysqli_num_rows($result);
											echo $quant . ' Produtos Com Estoque Zerado';
										  ?>
                                          
                                        </td> 
                                      </tr>
                                    </table>
                                    
                                    </div>
                                    
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="produtos.php?tipo=estoque_zerado">Ver Produtos Estoque Zerado</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">
                                    
                                    <table height="100%">
                                      <tr>
                                        <td>
                                          
                                          <?php
										    // obt�m os produtos com estqoue m�nimo
											$result = mysqli_query($conexao, "SELECT id FROM produtos WHERE estoque <= estoque_min");
                                            $quant = mysqli_num_rows($result);
											echo $quant . ' Produtos Com Estoque M&iacute;nimo';
										  ?>
                                          
                                        </td> 
                                      </tr>
                                    </table>
                                    
                                    </div>
                                    
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="produtos.php?tipo=estoque_minimo">Ver Produtos Estoque M&iacute;nimo</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>       
                </main>
                <?php require("rodape.php"); ?>
                
            </div>
        </div>
        <script src="bootstrap-5.0.2/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="js/chart.js"></script>

      
	</script>
    
    </body>
</html>

