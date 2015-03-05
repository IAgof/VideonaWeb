<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Videona\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Videona\UtilsBundle\Utility\Utils;
use Videona\DBBundle\Entity\User;

/**
 * Description of PruebaController
 *
 * @author vlf
 */
class PruebaController extends Controller {
    
    /**
     * Función para probar
     */
    public function pruebaAction()
    {
        
//        $em = $this->getDoctrine()->getManager();
        //$users = $em->getRepository('VideonaDBBundle:User')->findOneByUsername('prueba');
        //$users = $em->getRepository('VideonaDBBundle:User')->findAll();
        //if(!is_object($user)){
          //throw $this->createNotFoundException();
        //}
//        $query = $em->createQuery('SELECT u FROM Videona\DBBundle\Entity\User u');
//        $users = $query->getResult();
//        
//        $response = new Response(json_encode(array('name' => $users)));
//        $response->headers->set('Content-Type', 'application/json');
//
//        return $response;
        
        //return new Response($user);
        //$hora = new Utils();
        
//        $hora = Utils::prueba_servicio();
//        $user = new User();
//        
//        $name = $user->findUserByUsername('prueba');
//        ld($name);
//        
//        return new Response($hora);
        //return new Response($hora->prueba_servicio());
        //$helper = $this->get('videona.utils');
        //$hora = $helper->prueba_servicio();
        //return new Response($hora);
        return new Response('ok');
    }
    
    public function loginAction(){
        //$class = $this->getClass();
        //$user = new $class;
        
        return new Response('ok');
        
        
        /*
         * 
         * // Create json response
            $response = array();

            $response[] = array("name" => $params['username'], "email" => $params['password']);


            // JSon response format is :
            // [{"name":"eeee","email":"eee@zzzzz.com"},
            // {"name":"aaaa","email":"aaaaa@zzzzz.com"},{"name":"cccc","email":"bbb@zzzzz.com"}]

            // Set header as json
            //header("Content-type: application/json");

            // send response

            return new Response(json_encode($response));
         */
    }
    
    public function newimageAction(Request $request)
    {
        // Para obtener parámetros del archivo parameters.yml
        //ld($this->container->getParameter('locale'));
        // Imagen de perfil de videona para practicar
        // https://graph.facebook.com/1465342587073990/picture?width=260&height=260
        /*
         * TODO: Videona: crear un objeto imagen que referencie a la entidad imagen
         * Hacer en la base de datos una tabla que recoja los datos de las imágenes:
         * identificador, tamaño, propietario, etc.
         * Actualizar esos datos también en la tabla de usuario.
         * http://symfony.com/doc/current/reference/constraints/Image.html
         */
        $imageurl = 'https://graph.facebook.com/1465342587073990/picture?width=260&height=260';
        $tempname = $imageurl;
        
        $imageinfo = getimagesize($tempname);
        ld($imageinfo);
                
        // Comprobamos si la imagen se encuentra entre el tamaño mínimo y máximo
	$imageminwidth = 16;
	$imageminheight = 16;
	$imagemaxwidth = 1024;
	$imagemaxheight = 1024;
	
	$imageinfo = getimagesize($tempname);
	if (!$imageinfo) {
		echo 'El archivo no contiene una imagen';
		exit;
	}
	$width = $imageinfo[0];
	$height = $imageinfo[1];
	// the type of the uploaded file
	$type = $imageinfo['mime'];
                
        // Si no cumple estas dimensiones, enviamos un mensaje al usuario
	if ($width > $imagemaxwidth || $height > $imagemaxheight){
		echo 'Imagen de perfil demasiado grande';
		exit;
	} 
	if ($width < $imageminwidth || $height < $imageminheight){
		echo 'Imagen de perfil demasiado pequeña';
		exit;
	} 	
	
	// Calculamos la extensión del archivo
	//if (preg_match("/\.([^\.]+)$/", $name, $saved)){
	//	$oldextension = $saved[1];
	//}
        
        // TODO: Videona: revisar las extensiones
        switch ($type) {
            case 'image/gif':
                $extension = '.gif';
                break;
            case 'image/jpeg':
                $extension = '.jpg';
                break;
            case 'image/jpg':
                $extension = '.jpg';
                break;
            case 'image/pjpeg':
                $extension = '.pjpg';
                break;
            case 'image/x-png':
                $extension = '.xpng';
                break;
            case 'image/png':
                $extension = '.png';
                break;
            default:
                $extension = 0;
                break;
        }
        ld($extension);
        return new Response('ok');
	
	// Comprobamos si ha habido error al subir el archivo	
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	if ((($type != "image/gif")
	&& ($type != "image/jpeg")
	&& ($type != "image/jpg")
	&& ($type != "image/pjpeg")
	&& ($type != "image/x-png")
	&& ($type != "image/png"))
	//|| !in_array($oldextension, $allowedExts))
	){
		echo "Invalid file";
		exit;
	}
        
        // Si es correcto insertamos la imagen en la base de datos
        // Crear un nuevo objeto imagen aquí!!
        // Identificador obtenido de la base de datos cuando insertamos los datos
        // Para eso, esta variable debe ir después de obtener la información de la imagen
        $profileiconid = '1';
        
        // Guardamos el archivo en el directorio correspondiente
        // Puedo hacer una carpeta general con el identificador del usuario y ahí
        // dentro meter las carpetas con las imágenes
        // TODO: Videona: definir la estructura de carpetas para guardar imágenes!!
	$directory = $this->get('kernel')->getRootDir() . '/../web/file/profileicons/originals/' . ($profileiconid % 256) . '/';
        ld($directory);
		
	// Comprobamos que el directorio existe o lo creamos si no existe
	$create=true;
	$recursive=true;
	$status = true;
	$directory = trim($directory);
	
	if(!is_dir($directory)) {
		if (!$create) {
			$status = false;
		} else {
			$mask = umask(0000);
			$status = @mkdir($directory, 0700, true);
			umask($mask);
		}
	}
	
	// Copiamos la imagen en el directorio
	$image = $directory . $profileiconid;
	//ld($image);
        copy($tempname, $image);
	
	// Comprobamos que el archivo se ha creado y existe para poder borrar el archivo temporal
	$file = $image;
	if (file_exists($file)) {
		ld('existe');
	} else {
		ld('no existe');
	}
        
        
        return new Response('ok');
        /*
        return $this->render('VideonaUserBundle:Default:new.html.twig', array(
            'form' => $form->createView(),
        ));
         * 
         */
    }
}
