<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VFH API - SII Consulta Tributaria</title>
  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>
<body>
  <div class="container">

    <header class="header">
      <h1>VFH API - Consulta Tributaria a SII Chile</h1>
    </header>
    {{-- Content --}}
    <div class="content">

      <div class="code-section">
        <pre><code id="dataSII"></code></pre>
      </div>

      <div class="info-section">

        <p class="description">
          Esta API permite realizar una consulta directa a SII sin utilizar captchas.
          Los datos se despliegan en formato JSON y muestra la información principal entregada en la web de SII de Chile (Zeus).
        </p>
        <p class="description">
          Para utilizar esta API, puedes hacerlo directo desde este formulario, o utilizando una llamada POST a la ruta
          <code>/api/consulta</code> proporcionando en el body los párametros <code>rut y dv</code> (debe ser rut válido).
        </p>
            
        <div class="search-form">
          <h4 class="form-title">BUSCAR</h3>
          <form id="searchSII" method="POST">
            @csrf
            <div class="form-group">
              <input type="text" id="rut" name="rut" placeholder="RUT" min="7" max="8" autocomplete="off" required>
              <input type="text" id="rut" name="dv" placeholder="DV" min="1" max="1" autocomplete="off" required>
            </div>
            <div id="formMsg">Solo numeros, sin puntos ni guión</div>
            <button id="btnSubmit" type="submit">ENVIAR</button>
          </form>
          
        </div>

        <div class="button-container">
          <a href="https://github.com/vfaundez-dev/sii_consulta_tributaria" class="link-button">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
            </svg>
            Github
          </a>
        </div>

        <footer class="footer">
          Este sistema es de solo uso y desarrollo educativo, como proyecto para mi portafolio profesional.
          No me hago responsable por el mal uso de este.
        </footer>

      </div>

    </div>
    {{-- Content --}}
  </div>

  <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
