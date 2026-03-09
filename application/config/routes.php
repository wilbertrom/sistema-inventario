<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// ============================================
// RUTAS DE AUTENTICACIÓN
// ============================================
$route['login']  = 'Login/index';
$route['logout'] = 'Login/logout';

// ============================================
// RUTAS DEL PANEL PRINCIPAL
// ============================================
$route['panel']                             = 'Panel/index';
$route['panel/ver_inventario']              = 'Panel/ver_inventario';
$route['panel/ver_inventario/(:num)']       = 'Panel/ver_inventario/$1';
$route['panel/filtrar_inventario']          = 'Panel/filtrar_inventario';
$route['panel/buscar_inventario']           = 'Panel/buscar_inventario';
$route['panel/registrar']                   = 'Panel/view/registrar';
$route['panel/detalles/(.+)']               = 'Panel/detalles/$1';
$route['panel/editar/(.+)']                 = 'Panel/editar/$1';
$route['panel/orden_mantenimiento/(.+)']    = 'Panel/orden_mantenimiento/$1';

// ============================================
// RUTAS DE INVENTARIO
// ============================================
$route['inventario/registrar']                          = 'Inventario/registrar';
$route['inventario/editar']                             = 'Inventario/editar';
$route['inventario/eliminar/(.+)']                      = 'Inventario/eliminar/$1';
$route['inventario/actualizar_estado/(:any)/(.+)']      = 'Inventario/actualizar_estado/$1/$2';
$route['inventario/nuevaMarca']                         = 'Inventario/nuevaMarca';
$route['inventario/nuevoTipo']                          = 'Inventario/nuevoTipo';
$route['inventario/nuevoEstado']                        = 'Inventario/nuevoEstado';

// ============================================
// RUTAS DE GRUPOS
// ============================================
$route['grupos/vista']                                      = 'Grupos/vista';
$route['grupos/vista_asignar/(:any)/(:num)/(:num)']         = 'Grupos/vista_asignar/$1/$2/$3';
$route['grupos/asignar']                                    = 'Grupos/asignar';
$route['grupos/detalles/(:any)/(:num)']                     = 'Grupos/detalles/$1/$2';
$route['grupos/mantenimiento/(:any)/(:num)']                = 'Grupos/mantenimiento/$1/$2';
$route['grupos/todos_mantenimiento/(:any)/(:num)']          = 'Grupos/todos_mantenimiento/$1/$2';

// ============================================
// RUTAS DE ÓRDENES
// ============================================
$route['orden']                             = 'Orden/index';
$route['orden/registrar']                   = 'Orden/registrar';
$route['orden/ver_ordenesEquipo/(:any)']    = 'Orden/ver_ordenesEquipo/$1';

// ============================================
// RUTAS DE REPORTES DE SERVICIOS
// ============================================
$route['reporteservicios']                              = 'ReporteServicios/index';
$route['reporteservicios/crear']                        = 'ReporteServicios/crear';
$route['reporteservicios/eliminar/(:num)']              = 'ReporteServicios/eliminar/$1';
$route['reporteservicios/reporte/(:num)']               = 'ReporteServicios/reporte/$1';
$route['reporteservicios/actualizar_mes/(:num)/(:num)'] = 'ReporteServicios/actualizar_mes/$1/$2';
$route['reporteservicios/actualizar_servicios']         = 'ReporteServicios/actualizar_servicios';
$route['reporteservicios/generarReporte/(:num)']        = 'ReporteServicios/generarReporte/$1';
$route['reporteservicios/guardar_info'] = 'ReporteServicios/guardar_info';
// ============================================
// RUTAS DE REQUISICIONES
// ============================================
$route['requisiciones']         = 'Requisiciones/index';
$route['requisiciones/nueva']   = 'Requisiciones/nueva';
$route['requisiciones/crear']   = 'Requisiciones/crear';

// ============================================
// RUTAS DE PDF / EXCEL
// ============================================
$route['excel']                 = 'Excel/index';
$route['pdf/generarPdfEquipos'] = 'Pdf/generarPdfEquipos';

// ============================================
// RUTAS DE PORTAL
// ============================================
$route['portal/acerca_de']  = 'Portal/view/Informacion';
$route['portal/equipo']     = 'Portal/view/equipo';

// ============================================
// RUTAS DE PERFIL
// ============================================
$route['perfil']                     = 'Perfil/editar';
$route['perfil/actualizar_imagen']   = 'Perfil/actualizar_imagen';
$route['perfil/cambiar_password']    = 'Perfil/cambiar_password';
$route['perfil/actualizar_datos']    = 'Perfil/actualizar_datos';

// ============================================
// RUTAS DE PROGRAMA ANUAL DE MANTENIMIENTO
// ============================================
$route['programa-anual']                                    = 'ProgramaAnual/index';
$route['programa-anual/index']                              = 'ProgramaAnual/index';
$route['programa-anual/crear']                              = 'ProgramaAnual/crear';
$route['programa-anual/actividades/(:num)']                 = 'ProgramaAnual/actividades/$1';
$route['programa-anual/guardar_actividad']                  = 'ProgramaAnual/guardar_actividad';
$route['programa-anual/eliminar/(:num)']                    = 'ProgramaAnual/eliminar/$1';
$route['programa-anual/eliminar_actividad/(:num)/(:num)']   = 'ProgramaAnual/eliminar_actividad/$1/$2';
$route['programa-anual/pdf/(:num)']                         = 'ProgramaAnual/pdf/$1';
$route['programa-anual/guardar_firmas']                     = 'ProgramaAnual/guardar_firmas';

// ============================================
// RUTAS DE FIRMANTES (NUEVO - lista desplegable)
// ============================================
$route['firmantes']                 = 'Firmantes/index';
$route['firmantes/crear']           = 'Firmantes/crear';
$route['firmantes/editar/(:num)']   = 'Firmantes/editar/$1';
$route['firmantes/actualizar/(:num)'] = 'Firmantes/actualizar/$1';
$route['firmantes/eliminar/(:num)'] = 'Firmantes/eliminar/$1';
$route['firmantes/crear_ajax']          = 'Firmantes/crear_ajax';
$route['firmantes/lista']           = 'Firmantes/lista';  // endpoint JSON para dropdowns

// ============================================
// RUTAS DE ORDEN DE MANTENIMIENTO
// ============================================
$route['orden-mantenimiento']                       = 'OrdenMantenimiento/index';
$route['orden-mantenimiento/index']                 = 'OrdenMantenimiento/index';
$route['orden-mantenimiento/crear']                 = 'OrdenMantenimiento/crear';
$route['orden-mantenimiento/editar/(:num)']         = 'OrdenMantenimiento/editar/$1';
$route['orden-mantenimiento/actualizar/(:num)']     = 'OrdenMantenimiento/actualizar/$1';
$route['orden-mantenimiento/pdf/(:num)']            = 'OrdenMantenimiento/pdf/$1';
$route['orden-mantenimiento/eliminar/(:num)']       = 'OrdenMantenimiento/eliminar/$1';

// ============================================
// RUTAS DE ORDEN DE TRABAJO
// ============================================
$route['orden-trabajo/crear']           = 'OrdenTrabajo/crear';
$route['orden-trabajo/eliminar/(:num)'] = 'OrdenTrabajo/eliminar/$1';