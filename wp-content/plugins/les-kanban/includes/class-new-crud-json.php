<?php
/**
 * Proporcionar un manejo de datos CRUD
*
* Este archivo se utiliza para marcar los aspectos de administración del plugin.
*
*
* Este archivo permite crear la estructura de un CRUD en
 * formato json para ser guardado en una BBDD
 */

class NEW_CRUD_JSON{

  /**
   * Permite crear la estructura base para guardar los datos
   * de los items con el formato json
   *
   */
  public function add_user( $data, $nombres, $apellidos, $email, $imgUrl ){

    if( $data == '' ){

      $data = [
        
        "users" => [
          [
            "id"        => 1,
            "nombres"   => $nombres,
            "apellidos" => $apellidos,
            "email"     => $email,
            "imgUrl"    => $imgUrl
          ]
        ]
      ];

    }else{

      $users_decode   = json_decode( $data, true );
      $last_user      = end( $users_decode['users'] );
      $last_user_id   = $last_user['id'];
      $insert_user_id = ++$last_user_id;

      $users_decode['users'][] = [
        "id"        => $insert_user_id,
        "nombres"   => $nombres,
        "apellidos" => $apellidos,
        "email"     => $email,
        "imgUrl"    => $imgUrl
      ];

      $data = $users_decode;

    }

    return $data;

  }

  /**
   * Permite convertir los datos de los usuarios con el formato json a un array
   * para luego ser iterado con un foreach
   *
   */
  public function read_user( $data ){

    if( $data != '' ){

      $data = json_decode( $data, true );
      $output = '';

      foreach( $data['users'] as $valor ){

        $id         = $valor['id'];
        $nombres    = $valor['nombres'];
        $apellidos  = $valor['apellidos'];
        $email      = $valor['email'];
        $imgUrl     = $valor['imgUrl'];

        $output .= "
        <tr data-user='$id'>
            <td>
                <img class='new_media_img' src='$imgUrl' alt='$nombres $apellidos'>
            </td>
            <td>$nombres</td>
            <td>$apellidos</td>
            <td>$email</td>
            <td>
                <span data-edit='$id' class='btn btn-floating waves-effect weves-light'>
                    <i class='tiny material-icons'>mode_edit</i>
                </span>
            </td>
            <td>
                <span data-remove='$id' class='btn btn-floating waves-effect weves-light red darken-1'>
                    <i class='tiny material-icons'>close</i>
                </span>
            </td>
        </tr>
        ";

      }

      return $output;

    }

  }

  /**
   * Permite actualizar los datos del usuario
   * 
   * @return array
   */
  public function update_user( $ar_user, $idUser, $nombres, $apellidos, $email, $imgUrl ){

    $ar_user = json_decode( $ar_user, true );

    foreach( $ar_user['users'] as $key => $value ){

      $id = $value['id'];

      if( $idUser == $id ){

        $ar_user['users'][$key]['nombres']    = $nombres;
        $ar_user['users'][$key]['apellidos']  = $apellidos;
        $ar_user['users'][$key]['email']      = $email;
        $ar_user['users'][$key]['imgUrl']     = $imgUrl;

        break;

      }

    }

    return $ar_user;
    
  }

  /**
   * Permite eliminar un usuario
   * 
   */
  public function delete_user( $ar_user, $id_delete ){

    $ar_user = json_decode( $ar_user, true );

    foreach( $ar_user['users'] as $key => $value ){

      $id = $value['id'];

      if( $id_delete == $id ){

        unset( $ar_user['users'][$key] );

        break;

      }

    }

    return $ar_user;
    
  }

}

