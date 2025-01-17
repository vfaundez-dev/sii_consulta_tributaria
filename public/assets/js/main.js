const form = document.getElementById('searchSII');
const bntSubmit = document.getElementById('btnSubmit');
form.addEventListener('submit', (e) => {
  e.preventDefault();
  const dataForm = new FormData(form);
  bntSubmit.disabled = true;
  bntSubmit.innerText = 'Procesando...';
  getDataSII(dataForm);
})

async function getDataSII(dataForm) {
  const dataSII = document.getElementById('dataSII');
  
  try {
    const resp = await fetch('/api/consultar', {
      method: 'POST',
      body: dataForm
    });

    if (!resp.ok) {
      dataSII.innerText = `Error realizando petición: ${resp.status} - ${resp.statusText}`;
      throw new Error(`Error: ${resp.status} - ${resp.statusText}`);
    }

    const data = await resp.json();
    dataSII.innerText = JSON.stringify(data, null, 2).trim();
  } catch (error) {
    console.error('Error fetching data:', error);
    dataSII.innerText = `Error realizando petición: ${error.message}`;
  } finally {
    bntSubmit.disabled = false;
    bntSubmit.innerText = 'ENVIAR';
  }

}


/* async function getDataSII(dataForm) {
  const dataSII = document.getElementById('dataSII');
  const resp = await fetch('/api/consultar', {
    method: 'POST',
    body: dataForm
  });
  const data = await resp.json();
  bntSubmit.disabled = false;
  bntSubmit.innerText = 'ENVIAR';
  dataSII.innerText = JSON.stringify(data, null, 2).trim();
} */