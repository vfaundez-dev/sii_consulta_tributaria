const form = document.getElementById('searchSII');
form.addEventListener('submit', (e) => {
  e.preventDefault();
  const dataForm = new FormData(form);
  getDataSII(dataForm);
})

async function getDataSII(dataForm) {
  const dataSII = document.getElementById('dataSII');
  const resp = await fetch('/api/consultar', {
    method: 'POST',
    body: dataForm
  });
  const data = await resp.json();
  console.log(data);
  dataSII.innerText = JSON.stringify(data, null, 2).trim();
}