<?php
  session_start();
  require("config.php");
  // o usuário está logado?
  if(!isset($_SESSION["id_usuario_logado"])){
    header("Location: login.php");
    exit;
  }
  
  $foto_produto = time();
?>
<!DOCTYPE html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title><?= $titulo_aplicacao ?> - Novo Produto</title>
  <link rel="stylesheet" href="bootstrap-icons-1.5.0/font/bootstrap-icons.css" />
  <link href="css/styles.css?<?= date('Y-m-d_H:i:s'); ?>" rel="stylesheet" />
  
  <script src="js/jquery.min.js"></script>
  <script src="js/jquery.mask.min.js"></script>
  <link href="css/cropper.css" rel="stylesheet"/>
  <script src="js/cropper.js"></script>
  
  <script src="font-awesome/js/all.min.js" crossorigin="anonymous"></script>
  
  <style type="text/css">
    a{text-decoration:none} 
    .has-search .form-control {
    padding-left: 2.375rem;
    }

   .has-search .form-control-feedback {
    position: absolute;
    z-index: 2;
    display: block;
    width: 2.375rem;
    height: 2.375rem;
    line-height: 2.375rem;
    text-align: center;
    pointer-events: none;
    color: #aaa;
}

.blue-text {
    color: #00BCD4
}

.form-control-label {
    margin-bottom: 0
}

input,
textarea,
button {
    padding: 8px 15px;
    border-radius: 5px !important;
    margin: 5px 0px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    font-size: 18px !important;
    font-weight: 300
}

input:focus,
textarea:focus {
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    border: 1px solid #00BCD4;
    outline-width: 0;
    font-weight: 400
}

.btn-block {
    text-transform: uppercase;
    font-size: 15px !important;
    font-weight: 400;
    height: 43px;
    cursor: pointer
}

.btn-block:hover {
    color: #fff !important
}

button:focus {
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    outline-width: 0
}

.image_area {
		  position: relative;
		}

		img {
		  	display: block;
		  	max-width: 100%;
		}

		.preview {
  			overflow: hidden;
  			width: 160px; 
  			height: 160px;
  			margin: 10px;
  			border: 1px solid red;
		}

		.modal-lg{
  			max-width: 1000px !important;
		}

		.overlay {
		  position: absolute;
		  bottom: 10px;
		  left: 0;
		  right: 0;
		  background-color: rgba(255, 255, 255, 0.5);
		  overflow: hidden;
		  height: 0;
		  transition: .5s ease;
		  width: 100%;
		}

		.image_area:hover .overlay {
		  height: 50%;
		  cursor: pointer;
		}

		.text {
		  color: #333;
		  font-size: 20px;
		  position: absolute;
		  top: 50%;
		  left: 50%;
		  -webkit-transform: translate(-50%, -50%);
		  -ms-transform: translate(-50%, -50%);
		  transform: translate(-50%, -50%);
		  text-align: center;
		}

  </style>
</head>

<body class="sb-nav-fixed">

<?php require("cima.php"); ?>

<div id="layoutSidenav">
            
            <?php require("menu_lado.php"); ?>
            
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        
                        <h1 class="mt-4"><i class="bi-bag-plus"></i> Novo Produto</h1>
                        
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">P&aacute;gina Inicial</a></li>
                            <li class="breadcrumb-item active">Novo Produto</li>
                        </ol>
                        
                        <?php if(isset($_GET["sucesso"])){ ?>
						
                        <div class="alert alert-success" role="alert">
                          O produto foi cadastrado com sucesso. Voce pode agora verificar os <a href="produtos.php" class="alert-link">
                            Produtos Cadastrados</a> ou continuar cadastrando mais produtos.
                         </div>
                         
                        <?php } ?>
						
                        <div class="row">
                            <div class="col-xl-8">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="bi-clipboard-data"></i>
                                        Dados do Novo Produto
                                    </div>
                                    <div class="card-body">
                                    
                                    <form id="cadastro_produto" nome="cadastro_produto" action="cadastrar_produto_action.php" method="post" class="form-card">
                                    
                                    <div class="row justify-content-between text-left">
                                       <div class="form-group col-sm-6 flex-column d-flex">
                                         <label style="padding-left: 5px" class="form-control-label">Refer&ecirc;ncia<span class="text-danger"> *</span></label>
                                         <input onkeyup="atualizar_info_lado()" required type="text" id="referencia" name="referencia" placeholder="">
                                       </div>
                                    
                                       <div class="form-group col-sm-6 flex-column d-flex">
                                         <label style="padding-left: 5px" class="form-control-label">Nome<span class="text-danger"> *</span></label>
                                         <input onkeyup="atualizar_info_lado()" required type="text" id="nome" name="nome" placeholder="">
                                       </div>
                                    </div>
                    
                                    <div class="row justify-content-between text-left">
                                       <div class="form-group col-12 flex-column d-flex">
                                          <label style="padding-left: 5px" class="form-control-label">Descri&ccedil;&atilde;o<span class="text-danger"> *</span></label>
                                          <textarea onkeyup="atualizar_info_lado()" required class="form-control" name="descricao" id="descricao" rows="3"></textarea>
                                       </div>
                                    </div>
                                    
                                    <div class="row justify-content-between text-left">
                                       <div class="form-group col-sm-6 flex-column d-flex">
                                       <label style="padding-left: 5px" class="form-control-label">Categoria<span class="text-danger"> *</span></label>
                                          <select name="categoria" id="categoria" style="margin-bottom: 10px; margin-top: 10px" class="form-select">
                                             <?php
											   $result = mysqli_query($conexao, "select * from categorias order by nome");
                                               if($result){
	                                              while($detalhes = mysqli_fetch_array($result)){
	                                                 echo '<option value="' . $detalhes["id"] . '">' . utf8_encode($detalhes["nome"]) . '</option>';
	                                              }
                                               }
											 ?>
                                          </select>
                                       </div>
                                       
                                       <div class="form-group col-sm-6 flex-column d-flex">
                                       <label style="padding-left: 5px" class="form-control-label">Unidade<span class="text-danger"> *</span></label>
                                          <select name="unidade" id="unidade" style="margin-bottom: 10px; margin-top: 10px" class="form-select">
                                             <?php
											   for($i = 0; $i < count($nomes_unidades); $i++){
												  echo '<option value="' . $nomes_unidades[$i] . '">' . $nomes_unidades[$i] . '</option>';   
											   }
											 ?>
                                          </select>
                                       </div>
                                    </div>
                                    
                                    <div class="row justify-content-between text-left">
                                       <div class="form-group col-sm-6 flex-column d-flex">
                                         <label style="padding-left: 5px" class="form-control-label">Estoque M&iacute;nimo<span class="text-danger"> *</span></label>
                                         <input onkeyup="atualizar_info_lado()" value="0" required type="number" min="0" id="estoque_minimo" name="estoque_minimo" placeholder="">
                                       </div>
                                    
                                       <div class="form-group col-sm-6 flex-column d-flex">
                                         <label style="padding-left: 5px" class="form-control-label">Pre&ccedil;o Venda<span class="text-danger"> *</span></label>
                                         <input type="text" name="preco_venda" required id="preco_venda" style="text-align: right;">
                                         
                                         
                                       </div>
                                    </div>
                                    
                                    <div class="row justify-content-end">
                                       <div class="form-group col-12 flex-column d-flex">
                                          <button type="submit" name="gravar" style="width: 200px" class="btn-block btn-secondary">Gravar Dados</button>
                                          <input name="foto" type="hidden" id="foto" value="<?= $foto_produto ?>">
                                       </div>
                                    </div>
                                    
                                    </form>
                                    
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="bi-file-earmark-person"></i>
                                        Foto (Opcional)
                                    </div>
                                    <div class="card-body">
                                    
                                    <div style="text-align:center" class="image_area">
								      <form method="post">
									    <label for="upload_image">
										   <img width="150px" src="imagens/produto_sem_foto.jpg" id="uploaded_image" class="rounded" style="width:200;" />
									     <div class="overlay">
											<div class="text">Click para trocar a imagem</div>
										  </div>
										<input type="file" name="image" class="image" id="upload_image" style="display:none" />
									    </label>
								      </form>
							        </div>
                                    
                                    <table width="100%">
                                      <tr>
                                        <td align="center"><span id="foto_produto"></span></td>
                                      </tr>
                                      <tr>  
                                        <td align="center"><span id="foto_referencia_produto"></span></td>
                                      </tr>
                                      <tr>
                                        <td align="center"><span id="foto_nome_produto"></span></td>
                                      </tr>
                                      <tr>
                                        <td style="padding-top: 15px" align="center"><span id="foto_info_produto"></span></td>
                                      </tr>
                                    </table>
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                </main>
                
                <?php require("rodape.php"); ?>
                
            </div>
        
        
        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Recorte a imagem antes de salvar</h5>
									<button type="button" onclick="fecharCrop()" class="close" data-dismiss="modal" aria-label="Fechar">
										<span aria-hidden="true">×</span>
									</button>
								</div>
								<div class="modal-body">
									<div class="img-container">
										<div class="row">
											<div class="col-md-8">
												<img src="" id="sample_image" />
											</div>
											<div class="col-md-4">
												<div class="preview"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" id="crop" class="btn btn-primary">Recortar e Salvar</button>
									<button type="button" onclick="fecharCrop()" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
								</div>
							</div>
						</div>
					</div>
  				</div>
        
        
        </div>
        <script src="bootstrap-5.0.2/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    
    
    <script type="text/javascript">

    var $modal = undefined; 

$(document).ready(function(){

	$modal = $('#modal');

	var image = document.getElementById('sample_image');

	var cropper;

	$('#upload_image').change(function(event){
		var files = event.target.files;

		var done = function(url){
			image.src = url;
			$('#crop').attr('disabled',false);
			$('#crop').html('Recortar e Salvar');
			$modal.modal('show');
		};

		if(files && files.length > 0)
		{
			reader = new FileReader();
			reader.onload = function(event)
			{
				done(reader.result);
			};
			reader.readAsDataURL(files[0]);
		}
	});

	$modal.on('shown.bs.modal', function() {
		cropper = new Cropper(image, {
			aspectRatio: 1,
			viewMode: 3,
			preview:'.preview'
		});
	}).on('hidden.bs.modal', function(){
		cropper.destroy();
   		cropper = null;
	});

	$('#crop').click(function(){
		$('#crop').attr('disabled','disabled');
		$('#crop').html('<i class="fa fa-circle-o-notch fa-spin"></i> Processando...');
		canvas = cropper.getCroppedCanvas({
			width:400,
			height:400
		});

		canvas.toBlob(function(blob){
			url = URL.createObjectURL(blob);
			var reader = new FileReader();
			reader.readAsDataURL(blob);
			reader.onloadend = function(){
				var base64data = reader.result;
				$.ajax({
					url:'upload_produtos.php',
					method:'POST',
					data:{image:base64data, nome_imagem: '<?= $foto_produto ?>'},
					success:function(data)
					{
						$modal.modal('hide');
						$('#uploaded_image').attr('src', data);
					}
				});
			};
		});
	});
	
	// trata a formata�ao dos campos
	$('#preco_venda').mask('000.000.000.000.000,00', {reverse: true});
	// fim formata�ao dos campos
	
});

  function fecharCrop(){
	 $modal.modal('hide');
  }
  
  function atualizar_info_lado(){
	$('#foto_usuario').html('<b>' + $('#usuario').val() + '</b>');
	$('#foto_nome_usuario').html($('#nome').val());
	$('#foto_email_usuario').html($('#email').val());
	$('#foto_info_usuario').html($('#info').val());   
  }
</script>
    
    
    </body>
</html>

