<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller Inventario
 *
 * This controller for ...
 *
 * @package   CodeIgniter
 * @category  Controller CI
 * @author    
 * @author    
 * @link      
 * @param     ...
 * @return    ...
 *
 */

class Inventario extends CI_Controller
{
    
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Inventario_model');
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->library('idEncrypt');

  }




  public function registrar()
    {

        $this->form_validation->set_rules('marca', 'Marca', 'required');
        $this->form_validation->set_rules('cod_interno', 'Cod_interno', 'required');
        $this->form_validation->set_rules('tipo', 'Tipo', 'required');
        $this->form_validation->set_rules('estado', 'Estado', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Si la validación falla, recargar la vista con errores
            $this->load->view('panel/registrar');
        }else {
          // Recoger los datos del formulario
          $data_equipo = array(
              'id_marcas' =>$this->idencrypt->decrypt($this->input->post('marca')),
              'cod_interno' => $this->input->post('cod_interno'),
              'id_tipos' => $this->idencrypt->decrypt($this->input->post('tipo')),
              'descripcion' => $this->input->post('descripcion'),
              'id_estados' => $this->idencrypt->decrypt($this->input->post('estado'))
          );

          // Si el tipo es computadora, recoger los datos adicionales
          if ($this->input->post('tipo') == 'SFNGM2UyUzVYZ3JTT3ZFTGZRMnlaZz09') {
              $data_ccompu = array(
                  'procesador' => $this->input->post('procesador'),
                  'tarjeta' => $this->input->post('tarjeta_madre'),
                  'ram' => $this->input->post('ram')
              );

              // Llamar al modelo para insertar los datos en ccompu y obtener el ID insertado
              $id_ccompu = $this->Inventario_model->registrar_ccompu($data_ccompu);
              $data_equipo['id_ccompus'] = $id_ccompu;
          }

          // Llamar al modelo para insertar los datos en equipos
          if ($id_equipo =$this->Inventario_model->registrar_inventario($data_equipo)) {
            // Manejar la carga de la imagen
              $config['upload_path'] = './recursos-panel/images/equipos/'; // Directorio donde se guardarán las imágenes
              $config['allowed_types'] = 'jpg|jpeg|png'; // Tipos de archivos permitidos
              $config['max_size'] = 4096; 
              $config['file_name'] = $id_equipo;

              $this->load->library('upload', $config);
              
              if($this->upload->do_upload('imagen')){
                $data =  $this->upload->data();
                $path_img = $data['file_name'];  
              }else{
                $error = array('error' => $this->upload->display_errors());
              }
              $data = array(
                'imagen' => $path_img
              );
              $this->Inventario_model->actualizar_imagen_equipo($id_equipo, $data);
              // Redirigir a una página de éxito
              redirect('panel/ver_inventario');
          } else {
              // Mostrar un mensaje de error
              $this->load->view('panel/registrar', array('error' => 'Error al registrar el inventario.'));
          }

        }
    }

    public function editar(){
      $this->form_validation->set_rules('marca', 'Marca', 'required');
        $this->form_validation->set_rules('cod_interno', 'Cod_interno', 'required');
        $this->form_validation->set_rules('tipo', 'Tipo', 'required');
        $this->form_validation->set_rules('estado', 'Estado', 'required');

        if ($this->form_validation->run() == FALSE) {
          // Si la validación falla, recargar la vista con errores
          $this->load->view('panel/editar');
      }else {
        // Recoger los datos del formulario
        $id_equipo = $this->idencrypt->decrypt($this->input->post('id_equipos'));
        $id_ccompus = $this->input->post('id_ccompus');
        $data_equipo_up = array(
            'id_marcas' => $this->input->post('marca'),
            'cod_interno' => $this->input->post('cod_interno'),
            'id_tipos' => $this->input->post('tipo'),
            'descripcion' => $this->input->post('descripcion'),
            'id_estados' => $this->input->post('estado')
        );
        
        // Si el tipo es computadora, recoger los datos adicionales
        if ($this->input->post('tipo') == 'SFNGM2UyUzVYZ3JTT3ZFTGZRMnlaZz09') {
            
            $data_ccompu_up = array(
                'procesador' => $this->input->post('procesador'),
                'tarjeta' => $this->input->post('tarjeta_madre'),
                'ram' => $this->input->post('ram')
            );

            // Llamar al modelo para insertar los datos en ccompu y obtener el ID insertado
            $this->Inventario_model->actualizar_ccompu($data_ccompu_up, $id_ccompus);
        }

        // Llamar al modelo para insertar los datos en equipos
        if ($this->Inventario_model->actualizar_inventario($data_equipo_up, $id_equipo)) {
          if(!empty($_FILES['imagen']['name'])){
             //borrar la imagen anterior
             $directorio_imagenes = './recursos-panel/images/equipos/'; // Directorio donde se guardan las imágenes

             $extensiones_permitidas = ['png', 'jpg', 'jpeg']; // Extensiones permitidas
             foreach ($extensiones_permitidas as $extension) {
                 $archivo_a_eliminar = $directorio_imagenes . $id_equipo . '.' . $extension; // Ruta del archivo a eliminar
                 if (file_exists($archivo_a_eliminar)) {
                     unlink($archivo_a_eliminar); // Eliminar el archivo si existe
                 }
             }
             // Manejar la carga de la imagen
             $config['upload_path'] = './recursos-panel/images/equipos/'; // Directorio donde se guardarán las imágenes
             $config['allowed_types'] = 'jpg|jpeg|png'; // Tipos de archivos permitidos
             $config['max_size'] = 4096; 
             $config['file_name'] = $id_equipo;
 
             $this->load->library('upload', $config);
             
             if($this->upload->do_upload('imagen')){
              $data =  $this->upload->data();
              $path_img = $data['file_name'];  
             }else{
               $error = array('error' => $this->upload->display_errors());
             }  

             $data = array(
              'imagen' => $path_img
            );
            $this->Inventario_model->actualizar_imagen_equipo($id_equipo, $data);
             // Redirigir a una página de éxito
               redirect('panel/ver_inventario');
          }else{
            redirect('panel/ver_inventario');
          }
         
          } else {
              // Mostrar un mensaje de error
             $this->load->view('panel/', array('error' => 'Error al registrar el inventario.'));
          }
        }
      
    }

    public function eliminar($id){
      $id = $this->idencrypt->decrypt($id);

      $id_ccompu_obj = $this->Inventario_model->obtener_id_ccompu($id);
      if($id_ccompu_obj->id_ccompus != NULL){
        $id_ccompu = $id_ccompu_obj->id_ccompus;
        $this->Inventario_model->eliminar_ccompu($id_ccompu);
      }
      
      $this->Inventario_model->eliminar_equipo($id);
  
      
        //borrar la imagen anterior
        $directorio_imagenes = './recursos-panel/images/equipos/'; // Directorio donde se guardan las imágenes

        $extensiones_permitidas = ['png', 'jpg', 'jpeg']; // Extensiones permitidas
        foreach ($extensiones_permitidas as $extension) {
            $archivo_a_eliminar = $directorio_imagenes . $id . '.' . $extension; // Ruta del archivo a eliminar
            if (file_exists($archivo_a_eliminar)) {
                unlink($archivo_a_eliminar); // Eliminar el archivo si existe
            }
        }
  
        redirect($this->input->server('HTTP_REFERER'));
      }

    public function actualizar_estado($estado, $id){
      $this->Inventario_model->actualizar_estado($estado, $this->idencrypt->decrypt($id));
      redirect('panel/ver_inventario');
    }

    public function nuevaMarca(){
      $this->form_validation->set_rules('marca', 'Marca', 'required');
      $id_equipo = $this->input->post("id_equipos");

      if ($this->form_validation->run() == FALSE) {
        // Si la validación falla, recargar la vista con errores
        $this->load->view('panel/registrar');
    }else {
      // Recoger los datos del formulario
      $data = array(
        'nombre' => $this->input->post('marca') // Utilizar 'nombre' como clave para la columna en la tabla marcas
      );

      // Llamar al modelo para insertar los datos en equipos
      if ($this->Inventario_model->registrar_marca($data)) {


        if(isset($id_equipo) != null || isset($id_equipo) != ""){ // revisar si viene de la pagina de editar
          redirect('panel/editar' ."/". $id_equipo);
        }else{
          redirect('panel/registrar'); // si no viene de la pagina de editar lo mandamos al registro normal
        }
          
      } else {
          // Mostrar un mensaje de error
          $this->load->view('panel/registrar', array('error' => 'Error al agregar marca.'));
      }
    }
    }
   
    public function nuevoTipo(){
      $this->form_validation->set_rules('tipo', 'Tipo', 'required');
      $id_equipo = $this->input->post("id_equipos");


      if ($this->form_validation->run() == FALSE) {
        // Si la validación falla, recargar la vista con errores
        $this->load->view('panel/registrar');
    }else {
      // Recoger los datos del formulario
      $data = array(
        'nombre' => $this->input->post('tipo') // Utilizar 'nombre' como clave para la columna en la tabla marcas
      );

      // Llamar al modelo para insertar los datos en equipos
      if ($this->Inventario_model->registrar_tipo($data)) {
         
        if(isset($id_equipo) != null || isset($id_equipo) != ""){ // revisar si viene de la pagina de editar
          redirect('panel/editar' ."/". $id_equipo);
        }else{
          redirect('panel/registrar'); // si no viene de la pagina de editar lo mandamos al registro normal
        }

      } else {
          // Mostrar un mensaje de error
          $this->load->view('panel/registrar', array('error' => 'Error al agregar tipo.'));
      }
    }
    }
}


/* End of file Inventario.php */
/* Location: ./application/controllers/Inventario.php */