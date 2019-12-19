<?php
// src/Contact/Controller/ContactController.php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * Class ContactController
 *
 * Define global route to controller
 * @Route("/contact")
 */
class ContactController 
{

	/**
 	* Index action
 	* @param  Environment $twig [Template to return]
 	* @return Response
 	*
 	* @Route("/")
 	*/
	public function index(Environment $twig): Response
	{
		$content = $twig->render('Contact/index.html.twig');
		return new Response($content);
	}

}