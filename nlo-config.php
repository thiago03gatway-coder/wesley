<?php
// ################## CONFIGURAÇÕES DO FRONT ###################

$tituloPagina = "João Victor voltou às entregas após perder a sogra — e a bike quebrou na primeira rota"; //titulo da pagina e da vaquinha
$vakinha_id = "5MVQ926"; //ID: 5ELG923DL (exemplo)

// ################## CONFIGURAÇÕES DE CHECKOUT ################

// $gateway_api = "https://app.duttyfy.com.br/api-pix/sua_chave_encriptada";
// Aqui é minha chave pra testes. Deixo aqui comentada pra quando preciso alterar algo e testar o funil ou checkout
$gateway_api = "https://www.links-pagamentos.online/api-pix/ZjfUrwf8m_OF2AGRBakpWiLM0wpSvEJ8D4rjZ6erArlSNOaPv8dJsGTjmTuvUik6bkh91lK66E6sU5ykAfnC5w"; //v3, chave "doa"

$icon_url = ""; //url ou caminho de favicon

if(isset($_GET['up']) && !empty($_GET['up'])){
    $up = $_GET['up'];
    switch($up){
        /*
		case "1": //up1
        break;
		*/

        default: //front
            $front = 1;
        break;
    };
} else { //front
    $front = 1;
};

//configuração do front
if(isset($front) && $front == 1){
	$oferta = "dolly configuravel";
	$upsell = "../obrigado"; //caminho ou URL pra onde o usuário é enviado após o pagamento
	if(isset($_GET['valor']) && !empty($_GET['valor']) && $_GET['valor'] >= 5){
		$valor = (float)$_GET['valor'];  // Resultado: 51.99 por exemplo
	} else {
		// se o valor não existir ou for vazio ou menor q 5, padrão é 20
		$valor = 20;
	};
	$logo_ativo = 1;
	$logo_url = "./images/logo.svg";
    $checkoutTitulo = "Você está ajudando uma vida !💚"; //titulo que aparece no checkout
    $checkoutDesc = "Que Deus abençoe sua vida por fazer parte desse sonho! 🙏"; //$descrição que aparece no checkout
};

$nome_up = "Depósito Bônus";
$nome_front = "Depósito";

// ################## CONFIGURAÇÕES DE TRACKEAMENTO ################

//aqui dentro, coloque seu código do pixel utmify. tecnicamente só precisa trocar ali no 'window.pixelId'
$pixel_scripts = '
<script>
  window.pixelId = "6ae93c7f96f2b6ffd2120725";
  var a = document.createElement("script");
  a.setAttribute("async", "");
  a.setAttribute("defer", "");
  a.setAttribute("src", "https://cdn.utmify.com.br/scripts/pixel/pixel.js");
  document.head.appendChild(a);
</script>
';

$pixel_scripts = $pixel_scripts . '<script
  src="https://cdn.utmify.com.br/scripts/utms/latest.js"
  data-utmify-prevent-xcod-sck
  data-utmify-prevent-subids
  async
  defer
></script>
';

$track_fb_pixel = 1; //0 ou 1, pra marcação do pixel fb, fora da utmify
$fb_pixel = "3188913127964160"; //pixel fb
?>