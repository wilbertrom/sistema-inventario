<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Ruta por defecto
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// ============================================
// AUTENTICACIÓN
// ============================================
$route['login']  = 'login/index';
$route['logout'] = 'login/logout';

// ============================================
// PANEL PRINCIPAL
// ============================================
$route['panel']                              = 'panel/index';
$route['panel/ver_inventario']              = 'panel/ver_inventario';
$route['panel/ver_inventario/(:num)']       = 'panel/ver_inventario/$1';
$route['panel/filtrar_inventario']          = 'panel/filtrar_inventario';
$route['panel/buscar_inventario']           = 'panel/buscar_inventario';
$route['panel/detalles/(:any)']             = 'panel/detalles/$1';
$route['panel/editar/(:any)']               = 'panel/editar/$1';
$route['panel/registrar']                   = 'panel/view/registrar';
$route['panel/orden_mantenimiento/(:any)']  = 'panel/orden_mantenimiento/$1';

// ============================================
// INVENTARIO
// ============================================
$route['inventario/registrar']                              = 'inventario/registrar';
$route['inventario/editar']                                 = 'inventario/editar';
$route['inventario/eliminar/(:any)']                        = 'inventario/eliminar/$1';
$route['inventario/actualizar_estado/(:any)/(:any)']        = 'inventario/actualizar_estado/$1/$2';
$route['inventario/nuevaMarca']                             = 'inventario/nuevaMarca';
$route['inventario/nuevoTipo']                              = 'inventario/nuevoTipo';

// ============================================
// GRUPOS
// ============================================
$route['grupos/vista']                                          = 'grupos/vista';
$route['grupos/vista_asignar/(:any)/(:num)/(:num)']             = 'grupos/vista_asignar/$1/$2/$3';
$route['grupos/asignar']                                        = 'grupos/asignar';
$route['grupos/detalles/(:any)/(:num)']                         = 'grupos/detalles/$1/$2';
$route['grupos/mantenimiento/(:any)/(:num)']                    = 'grupos/mantenimiento/$1/$2';
$route['grupos/todos_mantenimiento/(:any)/(:num)']              = 'grupos/todos_mantenimiento/$1/$2';

// ============================================
// ÓRDENES
// ============================================
$route['orden']                             = 'orden/index';
$route['orden/registrar']                   = 'orden/registrar';
$route['orden/ver_ordenesEquipo/(:any)']    = 'orden/ver_ordenesEquipo/$1';

// ============================================
// REPORTES
// ============================================
$route['reporteservicios']                              = 'reporteservicios/index';
$route['reporteservicios/reporte/(:num)']               = 'reporteservicios/reporte/$1';
$route['reporteservicios/actualizar_mes/(:num)/(:num)'] = 'reporteservicios/actualizar_mes/$1/$2';
$route['reporteservicios/actualizar_servicios']         = 'reporteservicios/actualizar_servicios';
$route['reporteservicios/generarReporte/(:num)']        = 'reporteservicios/generarReporte/$1';

// ============================================
// REQUISICIONES
// ============================================
$route['requisiciones']         = 'requisiciones/index';
$route['requisiciones/nueva']   = 'requisiciones/nueva';
$route['requisiciones/crear']   = 'requisiciones/crear';

// ============================================
// PDF (controlador genérico)
// ============================================
$route['excel']                     = 'excel/index';
$route['pdf/generarPdfEquipos']     = 'pdf/generarPdfEquipos';

// ============================================
// PORTAL
// ============================================
$route['portal/acerca_de']  = 'portal/view/Informacion';
$route['portal/equipo']     = 'portal/view/equipo';

// ============================================
// PERFIL
// ============================================
$route['perfil']            = 'perfil/editar';
$route['perfil/actualizar'] = 'perfil/actualizar';

// ============================================
// PROGRAMA ANUAL DE MANTENIMIENTO
// ─ Una sola definición por ruta, todas apuntan
//   a ProgramaAnual (mayúscula = nombre real del archivo)
// ============================================
$route['programa-anual']                                    = 'ProgramaAnual/index';
$route['programa-anual/index']                              = 'ProgramaAnual/index';
$route['programa-anual/crear']                              = 'ProgramaAnual/crear';
$route['programa-anual/actividades/(:num)']                 = 'ProgramaAnual/actividades/$1';
$route['programa-anual/guardar_actividad']                  = 'ProgramaAnual/guardar_actividad';
$route['programa-anual/eliminar/(:num)']                    = 'ProgramaAnual/eliminar/$1';
$route['programa-anual/eliminar_actividad/(:num)/(:num)']   = 'ProgramaAnual/eliminar_actividad/$1/$2';
$route['programa-anual/pdf/(:num)']                         = 'ProgramaAnual/pdf/$1';
$route['programa-anual/guardar_firmas'] = 'programaanual/guardar_firmas';

// ============================================
// ORDEN DE MANTENIMIENTO
// ============================================
$route['orden-mantenimiento']                       = 'ordenmantenimiento/index';
$route['orden-mantenimiento/index']                 = 'ordenmantenimiento/index';
$route['orden-mantenimiento/crear']                 = 'ordenmantenimiento/crear';
$route['orden-mantenimiento/editar/(:num)']         = 'ordenmantenimiento/editar/$1';
$route['orden-mantenimiento/pdf/(:num)']            = 'ordenmantenimiento/pdf/$1';
$route['orden-mantenimiento/eliminar/(:num)']       = 'ordenmantenimiento/eliminar/$1';
$route['orden-trabajo/crear']                       = 'ordentrabajo/crear';
$route['orden-trabajo/eliminar/(:num)']             = 'ordentrabajo/eliminar/$1';