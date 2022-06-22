<?php
    function chamarapi(){
    $request = '{
        "reid": "28223",
        "cep": "38755000"
        }';
    
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
    curl_setopt($ch,CURLOPT_XOAUTH2_BEARER, 'fdf1ba26392963c5310f57f29fc7cfcc92e6d56c');
    $rota = json_decode(curl_exec($ch));
    echo $rota->descricao; 
   
  }
  function gerarToken(){
  $request = '{"grant_type": "password","username": "hidrogenio-api","password": "UaN8q@uun"}';
    $curlOptions = [
        CURLOPT_URL => 'https://apis.totalexpress.com.br/ics-seguranca/v1/oauth2/tokenGerar',
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Basic SUNTOnRvdGFs',
            'Content-Type: application/json',
            'x-li-format: json'
        ],
        CURLOPT_POSTFIELDS => $request,
    ];
    
    $ch = curl_init();
    curl_setopt_array($ch, $curlOptions);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $token = json_decode(curl_exec($ch));
    $ch = curl_close($ch);
    echo $token->access_token;
  }
?>

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
      require_once("modals.php");?>
<div class = "container text-center"><br>
<h1>Teste API</h1>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

 <form method="post" action="apirota.php">
    <input type=submit required  name='insert' value=save>
</form>


 <?php
  if (isset($_POST['insert'])){
    gerarToken();
  }
 ?>


  </body>
</html>

