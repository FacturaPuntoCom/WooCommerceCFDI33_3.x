# WooCommerceCFDI33_3.x

Woocommerce es una herramienta muy sencilla e intuitiva que
permite montar una tienda en línea con una amplia variedad de
funcionalidades que junto con otros plugins complementan las
operaciones básicas de ecommerce.

El plugin de Factura.com proporciona integración con la platafor-
ma de Factura.com incluyendo las siguientes funciones:

- Reporte de Facturas enviadas y canceladas en el panel de administración.
- Enviar facturas por email a los clientes automáticamente y cancelar facturas
desde el panel de administración.
- Funcionalidad para que los clientes creen facturas directamente desde el área
de clientes.
Reportes de historial de facturas y pedidos pendientes de facturar.

## Feature 24/08/2023

- Se corrige el problema que ocasionaba que se duplicaran registros en el catalogo de clientes al timbrar un CFDI a través del plugin

## Feature 05/11/2022

- Ahora se toman en cuenta los decimales configurados en woocommerce para el cálculo de los conceptos.

## Feature 06/04/2022

- Se sustituye la versión de timbrado de cfdi 3.3 por 4.0, por lo que los campos necesarios se modifican.

## Feature 24/01/2022

- Se agrego F_IVA para permitir el IVA individual por producto

## Feature 14/01/2022

- Se agregó el nuevo modo de cancelación para la reforma físcal 2022

## Fix 14/01/2022

- Se corrigió el bug que no permitía descargar, cancelar o enviar correo en la lista de facturas a apartir de la segunda pagina de la tabla.

## Feature 08/06/2021

- Se agregó el método de pago "Intermediario de pagos"

## Fix 27/05/21

- Validación cuando el pedido no existe

## Fix 20/04/21

- Calculo correcto del IVA

## Fix 14/06/20

- Nueva Opción de elegir USO CFDI en tienda antes de realizar factura
- Solución de error al tratar con cantidades decimales de producto (a granel)

## Fix 18/05/20

- Descarga de documentos
- Modo Api: Sandbox & Production
- Mejoras de mensajes de error
- Cambios endpoints
