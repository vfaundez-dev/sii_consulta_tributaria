# VFH API - Consulta Tributaria a SII Chile

⚠️ **IMPORTANTE**: Este sistema fue realizado únicamente con fines educativos y profesionales, como parte de mi portafolio personal. No me hago responsable del uso indebido de este sistema. ⚠️

---

## Descripción del Proyecto

Este es un sistema desarrollado con **Laravel 10** que permite realizar consultas directas al sistema web del Servicio de Impuestos Internos (SII) de Chile. Este sistema se encarga de:

1. **Generación dinámica de captcha**.
2. **Consulta al sistema "Zeus" del SII** utilizando la librería **Guzzle**, que devuelve la información en formato HTML.
3. **Extracción de información** del HTML utilizando **phpquery** y transformandola a formato JSON.
4. **Despliegue de la información obtenida**, ya sea en la interfaz del sistema o mediante una API.

## Requisitos

- **PHP**: Versión 8.1 o superior.
- **Composer**: Para gestionar las dependencias del proyecto.
- **Laravel 10**: Framework principal del proyecto.
- **Librerías adicionales**:
  - [Guzzle](https://github.com/guzzle/guzzle): Cliente HTTP para realizar las solicitudes al servidor.
  - [electrolinux/phpquery](https://github.com/Electrolinux/phpquery): Para analizar y extraer datos del HTML.

## Uso del Sistema

### 1. Interfaz Gráfica

- El sistema cuenta con un formulario disponible directamente en la **ruta raíz del proyecto**. Desde aquí, los usuarios pueden realizar consultas proporcionando el RUT y DV (Dígito Verificador).

### 2. API

- También se puede interactuar con el sistema mediante la **ruta API**: `/api/consulta`.
- Para realizar una consulta, envíe una solicitud POST con los siguientes parámetros en el cuerpo de la solicitud:
  ```json
  {
    "rut": "12345678",
    "dv": "9"
  }
  ```
- La respuesta será un objeto JSON con la información obtenida similar a esta:
  ```json
  {
    "status": "success",
    "message": "Proceso completado",
    "data": {
      "razonSocial": "Nombre",
      "RUT": "12345678-9",
      "inicio actividades": "",
      "fecha inicio actividades": "",
      "autorizado pagar con moneda extranjera": "",
      "es empresa de menor tamaño": "",
      "actividades": [
        {"LISTADO DE ACTIVIDADES"}
      ],
      "documentos timbrados": [
        {"LISTADO DE DOCUMENTOS TIMBRADOS"}
      ]
    }
  }
  ```

## Consideraciones

- El sistema **no realiza validaciones** sobre los datos ingresados (RUT y DV). Si se proporciona información incorrecta, simplemente se mostrará la respuesta devuelta por el servidor del SII o datos vacios.
- El sistema puede presentar algunos errores al solicitar captchas de forma interna, pero se puede realizar la petición nuevamente.
- **Uso bajo su propio riesgo**: Este sistema interactúa directamente con un servicio externo y podría estar sujeto a cambios o restricciones en el servicio del SII.

## Instalación

1. Clone este repositorio:
   ```bash
   git clone https://github.com/vfaundez-dev/sii_consulta_tributaria.git
   cd sii_consulta_tributaria
   ```
2. Instale las dependencias con Composer:
   ```bash
   composer install
   ```
3. Configure el archivo `.env` con los datos necesarios para su entorno.

4. Este sistema no utiliza base de datos local, por lo que no es necesario migraciones o configurar una base de datos.

5. Inicie el servidor local:
   ```bash
   php artisan serve
   ```

## Portafolio

Este proyecto forma parte de mi portafolio como desarrollador. Puedes encontrar más información y proyectos en: [https://vfh-portfolio.netlify.app/](https://vfh-portfolio.netlify.app/).

---

⚠️ **IMPORTANTE**: Este sistema fue realizado únicamente con fines educativos y profesionales, como parte de mi portafolio personal, y para reforzar mis conocimientos de programación. No me hago responsable del uso indebido de este sistema. ⚠️

---

## Licencia

![Creative Commons License](https://i.creativecommons.org/l/by-nc-nd/4.0/88x31.png)  
Este proyecto está licenciado bajo la [Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License](https://creativecommons.org/licenses/by-nc-nd/4.0/).

### Resumen
- **Atribución**: Debe proporcionar crédito adecuado al autor original.
- **No Comercial**: No puede utilizar el material para fines comerciales.
- **Sin Derivados**: Si remezcla, transforma o crea a partir del material, no puede distribuir el material modificado.

Para más detalles, consulte el archivo `LICENSE` incluido en este repositorio.