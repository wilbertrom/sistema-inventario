<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Ruta por defecto
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// ============================================
// RUTAS DE AUTENTICACIÓN
// ============================================
$route['login'] = 'login/index';
$route['logout'] = 'login/logout';

// ============================================
// RUTAS DEL PANEL PRINCIPAL
// ============================================
$route['panel'] = 'panel/index';
$route['panel/ver_inventario'] = 'panel/ver_inventario';
$route['panel/ver_inventario/(:num)'] = 'panel/ver_inventario/$1';
$route['panel/filtrar_inventario'] = 'panel/filtrar_inventario';
$route['panel/buscar_inventario'] = 'panel/buscar_inventario';
$route['panel/detalles/(:any)'] = 'panel/detalles/$1';
$route['panel/editar/(:any)'] = 'panel/editar/$1';
$route['panel/registrar'] = 'panel/view/registrar';
$route['panel/orden_mantenimiento/(:any)'] = 'panel/orden_mantenimiento/$1';

// ============================================
// RUTAS DE INVENTARIO
// ============================================
$route['inventario/registrar'] = 'inventario/registrar';
$route['inventario/editar'] = 'inventario/editar';
$route['inventario/eliminar/(:any)'] = 'inventario/eliminar/$1';
$route['inventario/actualizar_estado/(:any)/(:any)'] = 'inventario/actualizar_estado/$1/$2';
$route['inventario/nuevaMarca'] = 'inventario/nuevaMarca';
$route['inventario/nuevoTipo'] = 'inventario/nuevoTipo';

// ============================================
// RUTAS DE GRUPOS
// ============================================
$route['grupos/vista'] = 'grupos/vista';
$route['grupos/vista_asignar/(:any)/(:num)/(:num)'] = 'grupos/vista_asignar/$1/$2/$3';
$route['grupos/asignar'] = 'grupos/asignar';
$route['grupos/detalles/(:any)/(:num)'] = 'grupos/detalles/$1/$2';
$route['grupos/mantenimiento/(:any)/(:num)'] = 'grupos/mantenimiento/$1/$2';
$route['grupos/todos_mantenimiento/(:any)/(:num)'] = 'grupos/todos_mantenimiento/$1/$2';

// ============================================
// RUTAS DE ÓRDENES
// ============================================
$route['orden'] = 'orden/index';
$route['orden/registrar'] = 'orden/registrar';
$route['orden/ver_ordenesEquipo/(:any)'] = 'orden/ver_ordenesEquipo/$1';

// ============================================
// RUTAS DE REPORTES
// ============================================
$route['reporteservicios'] = 'reporteservicios/index';
$route['reporteservicios/reporte/(:num)'] = 'reporteservicios/reporte/$1';
$route['reporteservicios/actualizar_mes/(:num)/(:num)'] = 'reporteservicios/actualizar_mes/$1/$2';
$route['reporteservicios/actualizar_servicios'] = 'reporteservicios/actualizar_servicios';
$route['reporteservicios/generarReporte/(:num)'] = 'reporteservicios/generarReporte/$1';

// ============================================
// RUTAS DE REQUISICIONES
// ============================================
$route['requisiciones'] = 'requisiciones/index';
$route['requisiciones/nueva'] = 'requisiciones/nueva';
$route['requisiciones/crear'] = 'requisiciones/crear';

// ============================================
// RUTAS DE EXCEL Y PDF
// ============================================
$route['excel'] = 'excel/index';
$route['pdf/generarPdfEquipos'] = 'pdf/generarPdfEquipos';

// ============================================
// RUTAS DE PORTAL
// ============================================
$route['portal/acerca_de'] = 'portal/view/Informacion';
$route['portal/equipo'] = 'portal/view/equipo';

// ============================================
// RUTAS DE PERFIL
// ============================================
$route['perfil'] = 'perfil/editar';
$route['perfil/actualizar'] = 'perfil/actualizar';
// Rutas para Programa Anual
$route['programa-anual'] = 'programaanual/index';
$route['programa-anual/index'] = 'programaanual/index';
$route['programa-anual/crear'] = 'programaanual/crear';
$route['programa-anual/editar/(:num)'] = 'programaanual/editar/$1';
$route['programa-anual/actualizar/(:num)'] = 'programaanual/actualizar/$1';
$route['programa-anual/eliminar/(:num)'] = 'programaanual/eliminar/$1';
$route['programa-anual/marcar_mes'] = 'programaanual/marcar_mes';
$route['programa-anual/marcar_todos'] = 'programaanual/marcar_todos';
$route['programa-anual/pdf/(:num)'] = 'programaanual/pdf/$1';
$route['programa-anual/pdf_anual/(:num)'] = 'programaanual/pdf_anual/$1';
// Rutas para Orden de Mantenimiento
$route['orden-mantenimiento'] = 'ordenmantenimiento/index';
$route['orden-mantenimiento/index'] = 'ordenmantenimiento/index';
$route['orden-mantenimiento/crear'] = 'ordenmantenimiento/crear';
$route['orden-mantenimiento/editar/(:num)'] = 'ordenmantenimiento/editar/$1';
$route['orden-mantenimiento/pdf/(:num)'] = 'ordenmantenimiento/pdf/$1';
$route['orden-mantenimiento/eliminar/(:num)'] = 'ordenmantenimiento/eliminar/$1';
$route['orden-trabajo/crear'] = 'ordentrabajo/crear';
$route['orden-trabajo/eliminar/(:num)'] = 'ordentrabajo/eliminar/$1';