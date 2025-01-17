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
  const resp = await fetch('/api/consultar', {
    method: 'POST',
    body: dataForm
  });
  const data = await resp.json();
  bntSubmit.disabled = false;
  bntSubmit.innerText = 'ENVIAR';
  dataSII.innerText = JSON.stringify(data, null, 2).trim();
}