<?php
// src/Controller/ContactController.php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;
use App\Entity\Contact;
use App\Form\ContactForm;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ContactController
 *
 * Define global route to controller
 * @Route("/contact")
 */
class ContactController extends AbstractController
{
	/**
 	* Index action
 	* @param  Environment $twig [Template to return]
 	* @return Response
 	*
 	* @Route("/", name="oc_contact_index")
 	*/
	public function index(Environment $twig): Response
	{
		$content = $twig->render('index.html.twig');
		return new Response($content);
	}

	/**
 	* @Route("/add", name="oc_contact_add")
 	*/
	public function add(Environment $twig, Request $request): Response
	{
		$contact = new Contact();

		$form = $this->createForm(ContactForm::class, $contact, array (
			'action' => $this->generateUrl('oc_contact_add'),
			'method' => 'POST'));

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid())
		{
			$contact = $form->getData();

			$entityManager = $this->getDoctrine()->getManager();
        	$entityManager->persist($contact);
        	$entityManager->flush();
		
			return $this->redirectToRoute('oc_contact_index');
		}

		$content = $twig->render('add.html.twig', array(
            'form' => $form->createView()
        ));
		return new Response($content);
	}

	/**
 	* @Route("/", name="oc_contact_view")
 	*/
	public function view(Environment $twig)
	{
		$entityManager = $this->getDoctrine()->getManager();
		$contacts = $entityManager->getRepository(Contact::class)->findAll();
		$content = '';
		if (empty($contacts))
		{
			return new Response('Votre liste de contact est vide pour le moment.');
		}
		else {
			foreach ($contacts as $contact) 
			{
				 $form    = $this->createForm(ContactForm::class, $contact, array (
				'action'  => $this->generateUrl('oc_contact_edit', ['id' => $contact->getId()]),
				'method'  => 'POST'));
				 $content .= $twig->render('edit.html.twig', [
	            'form'    => $form->createView()
	            ]);
			}
		}
		return new Response($content);
	}

	/**
	 * @Route("/edit/{id}", name="oc_contact_edit", requirements={"id" ="\d+"})
	 */
	public function edit(int $id, Request $request, Contact $contact): Response
	{
		$form = $this->createForm(ContactForm::class, $contact);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid())
		{
			$contact = $form->getData();
			$entityManager = $this->getDoctrine()->getManager();
        	$entityManager->flush();
		
			return $this->redirectToRoute('oc_contact_index');
		}
		$content = $twig->render('index.html.twig');
		return new Response($content);	
	}
}