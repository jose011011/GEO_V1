<?php
// Landing page (usa $loginUrl si ya viene definido en public/index.php)
if (!isset($loginUrl)) {
  $loginUrl = BASE_URL . 'Auth/login';
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= APP_NAME ?> - Servicios</title>
  <style>
    :root{--bg:#0b1220;--card:#111a2e;--text:#e6edf6;--muted:#9aa7bd;--brand:#4f8cff;--brand2:#2dd4bf;}
    *{box-sizing:border-box}
    body{margin:0;font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Cantarell,Noto Sans,sans-serif;background:linear-gradient(120deg,#070b16 0%, #0b1220 55%, #07101f 100%);color:var(--text)}
    a{color:inherit;text-decoration:none}
    .wrap{max-width:1120px;margin:0 auto;padding:28px 18px}
    header{display:flex;align-items:center;justify-content:space-between;gap:14px;padding:10px 0}
    .logo{display:flex;align-items:center;gap:10px;font-weight:800;letter-spacing:.2px}
    .logo .dot{width:12px;height:12px;border-radius:50%;background:linear-gradient(135deg,var(--brand),var(--brand2));box-shadow:0 0 0 6px rgba(79,140,255,.12)}
    nav{display:flex;gap:18px;color:var(--muted);font-weight:600;font-size:14px}
    .hero{display:grid;grid-template-columns:1.15fr .85fr;gap:22px;align-items:center;margin-top:22px}
    .kicker{color:var(--brand2);font-weight:800;letter-spacing:.6px;text-transform:uppercase;font-size:12px}
    h1{margin:10px 0 12px;font-size:44px;line-height:1.06}
    p{margin:0;color:var(--muted);font-size:16px;line-height:1.6}
    .ctaRow{display:flex;flex-wrap:wrap;gap:12px;margin-top:18px}
    .btn{display:inline-flex;align-items:center;justify-content:center;padding:12px 16px;border-radius:12px;font-weight:800;border:1px solid rgba(255,255,255,.12);background:rgba(17,26,46,.55);backdrop-filter: blur(10px);cursor:pointer}
    .btnPrimary{border-color:rgba(79,140,255,.45);background:linear-gradient(135deg, rgba(79,140,255,.95), rgba(45,212,191,.85));color:#08111f}
    .btn:hover{transform:translateY(-1px);transition:.15s}
    .card{background:rgba(17,26,46,.65);border:1px solid rgba(255,255,255,.10);border-radius:18px;padding:18px;box-shadow:0 20px 50px rgba(0,0,0,.35)}
    .steps{display:grid;gap:12px;margin-top:16px}
    .step{display:flex;gap:12px;align-items:flex-start}
    .badge{width:34px;height:34px;border-radius:12px;background:rgba(79,140,255,.18);border:1px solid rgba(79,140,255,.35);display:flex;align-items:center;justify-content:center;font-weight:900}
    .step h3{margin:0;font-size:14px}
    .step span{color:var(--muted);font-size:14px;line-height:1.5}
    .grid3{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-top:18px}
    .mini{padding:14px;border-radius:16px;background:rgba(17,26,46,.55);border:1px solid rgba(255,255,255,.10)}
    .mini b{display:block;margin-bottom:6px}
    footer{margin-top:30px;color:var(--muted);font-size:13px;text-align:center;padding:18px 0}

    @media (max-width: 900px){
      .hero{grid-template-columns:1fr;}
      h1{font-size:34px}
      nav{display:none}
      .grid3{grid-template-columns:1fr}
    }
  </style>
</head>
<body>
  <div class="wrap">
    <header>
      <div class="logo"><span class="dot"></span> <?= APP_NAME ?></div>
      <nav>
        <a href="#como">Cómo funciona</a>
        <a href="#para-ti">Para quién</a>
      </nav>
      <a class="btn" href="<?= $loginUrl ?>">Iniciar sesión</a>
    </header>

    <section class="hero">
      <div>
        <div class="kicker">Conecta cliente y profesional</div>
        <h1>Encuentra el servicio ideal y chatea con tu profesional.</h1>
        <p>
          Publica tu necesidad, recibe opciones y coordina el trabajo con profesionales verificados.
          Todo en una experiencia simple: eliges, conversas y avanzas.
        </p>

        <div class="ctaRow">
          <a class="btn btnPrimary" href="<?= $loginUrl ?>">Entrar / Iniciar sesión</a>
          <a class="btn" href="#como">Ver cómo funciona</a>
        </div>

        <div id="como" class="grid3" style="margin-top:22px">
          <div class="mini">
            <b>1. Publica</b>
            <span style="color:var(--muted);font-size:14px;line-height:1.5">
              Describe el tipo de trabajo que necesitas.
            </span>
          </div>
          <div class="mini">
            <b>2. Conecta</b>
            <span style="color:var(--muted);font-size:14px;line-height:1.5">
              Profesionales cercanos y disponibles responden.
            </span>
          </div>
          <div class="mini">
            <b>3. Coordina</b>
            <span style="color:var(--muted);font-size:14px;line-height:1.5">
              Chatea para definir el servicio y el acuerdo.
            </span>
          </div>
        </div>
      </div>

      <aside class="card">
        <b style="display:block;margin-bottom:8px">Beneficios</b>
        <div class="steps">
          <div class="step">
            <div class="badge">✓</div>
            <div>
              <h3>Chat para coordinar</h3>
              <span>Sin correos eternos: conversa en el momento.</span>
            </div>
          </div>
          <div class="step">
            <div class="badge">★</div>
            <div>
              <h3>Profesionales verificados</h3>
              <span>Mejores opciones para tu tipo de trabajo.</span>
            </div>
          </div>
          <div class="step">
            <div class="badge">⚡</div>
            <div>
              <h3>Proceso simple</h3>
              <span>Del requerimiento al acuerdo, rápido.</span>
            </div>
          </div>
        </div>

        <div style="margin-top:16px; border-top:1px solid rgba(255,255,255,.10); padding-top:16px">
          <div id="para-ti" style="font-weight:900; margin-bottom:8px;">¿Para quién?</div>
          <p style="margin:0;">Clientes buscan profesionales. Profesionales ofrecen sus servicios y conversan con sus clientes.</p>
        </div>

        <div style="margin-top:16px; display:flex; gap:10px; flex-wrap:wrap">
          <a class="btn btnPrimary" href="<?= $loginUrl ?>">Iniciar sesión</a>
          <a class="btn" href="<?= BASE_URL ?>Auth/registro_cliente">Crear cuenta (cliente)</a>
          <a class="btn" href="<?= BASE_URL ?>Auth/registro_profesional">Crear cuenta (profesional)</a>
        </div>
      </aside>
    </section>

    <footer>
      © <?= date('Y') ?> <?= APP_NAME ?>. Página demo de landing.
    </footer>
  </div>
</body>
</html>

