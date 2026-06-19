<?php
// Landing home - UI tipo MVC pero sin usar views/controladores.
// Nota: public/index.php ya incluye config/config.php.
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= APP_NAME ?> - Servicios</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/validaciones.css">
  <style>
    :root{--bg:#0b1220;--card:#111a2e;--text:#e6edf6;--muted:#9aa7bd;--brand:#4f8cff;--brand2:#2dd4bf;}
    *{box-sizing:border-box}
    body{margin:0;font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Cantarell,Noto Sans,sans-serif;background:linear-gradient(120deg,#070b16 0%, #0b1220 55%, #07101f 100%);color:var(--text)}
    a{color:inherit;text-decoration:none}

    /* Header */
    .topbar{position:sticky;top:0;z-index:50;background:rgba(7,11,22,.72);backdrop-filter: blur(10px);border-bottom:1px solid rgba(255,255,255,.08)}
    .topbar-inner{max-width:1120px;margin:0 auto;padding:14px 18px;display:flex;align-items:center;justify-content:space-between;gap:12px}
    .brand{display:flex;align-items:center;gap:10px;font-weight:900;letter-spacing:.2px}
    .dot{width:12px;height:12px;border-radius:50%;background:linear-gradient(135deg,var(--brand),var(--brand2));box-shadow:0 0 0 6px rgba(79,140,255,.12)}

    .menu{display:flex;align-items:center;gap:18px}
    .menu a{color:var(--muted);font-weight:700;font-size:14px}
    .menu a:hover{color:var(--text)}

    .actions{display:flex;align-items:center;gap:10px}

    .btn{display:inline-flex;align-items:center;justify-content:center;padding:12px 16px;border-radius:12px;font-weight:900;border:1px solid rgba(255,255,255,.12);background:rgba(17,26,46,.55);backdrop-filter: blur(10px)}
    .btnPrimary{border-color:rgba(79,140,255,.45);background:linear-gradient(135deg, rgba(79,140,255,.95), rgba(45,212,191,.85));color:#08111f}
    .btn:hover{transform:translateY(-1px);transition:.15s}

    /* Mobile menu */
    .hamb{display:none;background:transparent;border:0;color:var(--text);font-size:20px;cursor:pointer;padding:8px}
    .mobile-panel{display:none}
    @media (max-width: 900px){
      .menu{display:none}
      .hamb{display:inline-block}
      .mobile-panel{display:block;max-width:1120px;margin:0 auto;padding:0 18px 14px}
      .mobile-panel .row{display:flex;flex-direction:column;gap:10px}
      .mobile-panel a{color:var(--muted);font-weight:800}
    }

    /* Layout */
    .wrap{max-width:1120px;margin:0 auto;padding:28px 18px}
    .hero{display:grid;grid-template-columns:1.15fr .85fr;gap:22px;align-items:center;margin-top:22px}
    .kicker{color:var(--brand2);font-weight:900;letter-spacing:.6px;text-transform:uppercase;font-size:12px}
    h1{margin:10px 0 12px;font-size:44px;line-height:1.06}
    p{margin:0;color:var(--muted);font-size:16px;line-height:1.6}

    .ctaRow{display:flex;flex-wrap:wrap;gap:12px;margin-top:18px}

    .card{background:rgba(17,26,46,.65);border:1px solid rgba(255,255,255,.10);border-radius:18px;padding:18px;box-shadow:0 20px 50px rgba(0,0,0,.35)}

    .grid3{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-top:18px}
    .mini{padding:14px;border-radius:16px;background:rgba(17,26,46,.55);border:1px solid rgba(255,255,255,.10)}
    .mini b{display:block;margin-bottom:6px}

    .steps{display:grid;gap:12px;margin-top:16px}
    .step{display:flex;gap:12px;align-items:flex-start}
    .badge{width:34px;height:34px;border-radius:12px;background:rgba(79,140,255,.18);border:1px solid rgba(79,140,255,.35);display:flex;align-items:center;justify-content:center;font-weight:900}
    .step h3{margin:0;font-size:14px}
    .step span{color:var(--muted);font-size:14px;line-height:1.5}

    .section-title{font-size:20px;margin-top:28px;margin-bottom:10px;font-weight:950}

    /* Responsive */
    @media (max-width: 900px){
      .hero{grid-template-columns:1fr}
      h1{font-size:34px}
      .grid3{grid-template-columns:1fr}
    }

    footer{margin-top:34px;color:var(--muted);font-size:13px;text-align:center;padding:18px 0}
  </style>
</head>
<body>
  <header class="topbar">
    <div class="topbar-inner">
      <div class="brand"><span class="dot"></span> <?= APP_NAME ?></div>

      <nav class="menu">
        <a href="#como">Cómo funciona</a>
        <a href="#para-ti">Para quién</a>
        <a href="#beneficios">Beneficios</a>
        <a href="#contacto">Contacto</a>
      </nav>

      <div class="actions">
        <a class="btn" href="<?= $loginUrl ?>">Iniciar sesión</a>
        <button class="hamb" id="hamb" aria-label="Menu">☰</button>
      </div>
    </div>

    <div class="mobile-panel" id="mobilePanel">
      <div class="row">
        <a href="#como">Cómo funciona</a>
        <a href="#para-ti">Para quién</a>
        <a href="#beneficios">Beneficios</a>
        <a href="#contacto">Contacto</a>
      </div>
    </div>
  </header>

  <main class="wrap">
    <section class="hero">
      <div>
        <div class="kicker">Conecta cliente y profesional</div>
        <h1>Publica tu necesidad y chatea para coordinar el servicio.</h1>
        <p>
          En esta plataforma, el <b>cliente</b> describe el trabajo y el <b>profesional</b> responde.
          Conversan, acuerdan y avanzan.
        </p>

        <div class="ctaRow">
          <a class="btn btnPrimary" href="<?= $loginUrl ?>">Iniciar sesión</a>
          <a class="btn" href="#como">Ver cómo funciona</a>
        </div>

        <div class="grid3" id="como">
          <div class="mini">
            <b>1. Publica</b>
            <span style="color:var(--muted)">Cuenta qué necesitas y en qué ciudad.</span>
          </div>
          <div class="mini">
            <b>2. Conecta</b>
            <span style="color:var(--muted)">Recibe opciones de profesionales disponibles.</span>
          </div>
          <div class="mini">
            <b>3. Coordina</b>
            <span style="color:var(--muted)">Chatea para definir el trabajo y el acuerdo.</span>
          </div>
        </div>
      </div>

      <aside class="card">
        <div class="section-title" style="margin-top:0" id="beneficios">Beneficios</div>
        <div class="steps">
          <div class="step">
            <div class="badge">✓</div>
            <div><h3>Chat rápido</h3><span>Coordina sin perder tiempo.</span></div>
          </div>
          <div class="step">
            <div class="badge">★</div>
            <div><h3>Profesionales verificados</h3><span>Mejores opciones para tu necesidad.</span></div>
          </div>
          <div class="step">
            <div class="badge">⚡</div>
            <div><h3>Proceso simple</h3><span>Del requerimiento al acuerdo.</span></div>
          </div>
        </div>

        <div style="margin-top:16px;border-top:1px solid rgba(255,255,255,.10);padding-top:16px">
          <div class="section-title" style="font-size:16px;margin:0 0 8px" id="para-ti">¿Para quién?</div>
          <p style="font-size:15px">Clientes buscan servicios. Profesionales ofrecen su trabajo y conversan contigo.</p>
          <div class="ctaRow" style="margin-top:14px">
            <a class="btn" href="<?= BASE_URL ?>Auth/registro_cliente">Registro cliente</a>
            <a class="btn" href="<?= BASE_URL ?>Auth/registro_profesional">Registro profesional</a>
          </div>
        </div>
      </aside>
    </section>

    <section id="contacto" style="margin-top:24px" class="card">
      <div class="section-title" style="margin-top:0">¿Listo para empezar?</div>
      <p style="margin-bottom:14px">
        Entra a tu cuenta para publicar o responder solicitudes.
      </p>
      <div class="ctaRow">
        <a class="btn btnPrimary" href="<?= $loginUrl ?>">Iniciar sesión</a>
        <a class="btn" href="#como">Volver a cómo funciona</a>
      </div>
    </section>

    <footer>
      © <?= date('Y') ?> <?= APP_NAME ?> - Landing demo responsive.
    </footer>
  </main>

  <script>
    // Mobile menu simple
    const hamb = document.getElementById('hamb');
    const panel = document.getElementById('mobilePanel');
    if (hamb && panel) {
      panel.style.display = 'none';
      hamb.addEventListener('click', () => {
        panel.style.display = (panel.style.display === 'none' ? 'block' : 'none');
      });
    }
  </script>
</body>
</html>

