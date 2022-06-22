<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Guia do Xavá</title>
  </head>
  <body>
    
<?php require_once("assets/head.php"); 
      require_once("geradordesenha.php");
      require_once("modals.php");
      require_once("classes/classApi.php");?>

<div class = "container text-center"><br>
<h1>Teste API</h1>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<form action="./testeapi.php" method="post">
			<div class="form-group">
				<label>REID</label>
				<input type="text" name="reid" class="form-control" >
			</div>

			<div class="form-group">
				<label>CEP</label>
				<input type="text" required name="cep" class="form-control" >
			</div>
			<button type="submit" name="enviar" class="btn btn-primary" value="enviar">Enviar</button>
		</form>

<?php if (isset($_POST['reid'],$_POST['cep'] )){
        //API Gerar Token
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://viacep.com.br/ws/01001000/json/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $resposta = curl_exec($ch);
        
        var_dump($resposta);die;
        $request = '{"grant_type": "password","username": "hidrogenio-api","password": "UaN8q@uun"}';
        $curlOptions = [
            CURLOPT_URL => 'https://apis.totalexpress.com.br/ics-seguranca/v1/oauth2/tokenGerar',
            CURLOPT_POST => true,
            CURLOPT_VERBOSE => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Basic SUNTOnRvdGFs',
                'Content-Type: application/json',
            ],
            CURLOPT_POSTFIELDS => $request,
        ];
        
        $ch = curl_init();
        curl_setopt_array($ch, $curlOptions);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        var_dump(curl_exec($ch));
        die;
        $token = json_decode(curl_exec($ch));
        $ch = curl_close($ch);
            if (isset($token->access_token)){
                $bearerToken = $token->access_token;
                //API Buscar Rota
                $request = '{"reid": ' . $_POST['reid'] . ',"cep": ' . $_POST['cep'] . '}';
    
                $curlOptions = [
                    CURLOPT_URL => 'https://apis.totalexpress.com.br/ics-edi/v1/coleta/smartLabel/rota/buscar',
                    CURLOPT_POST => true,
                    CURLOPT_HTTPHEADER => [
                        'Content-Type: application/json',
                        'x-li-format: json'
                    ],
                    CURLOPT_POSTFIELDS => $request,
                ];
    
                $ch = curl_init();
                curl_setopt_array($ch, $curlOptions);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BEARER);
                curl_setopt($ch,CURLOPT_XOAUTH2_BEARER, $token->access_token);
                $retorno = curl_exec($ch);
                $json = json_decode($retorno);
            }else{ 
                echo "Falha ao Conectar na API";
                }

                if (in_array(NULL, $_POST)) { 
?>
    <div class="alert alert-primary text-center" role="alert">
        Algum campo está vazio, volte e preencha novamente.
    </div>

<?php  }else {
        var_dump($_POST);
        die;
        }
}?>
  </body>
</html>

