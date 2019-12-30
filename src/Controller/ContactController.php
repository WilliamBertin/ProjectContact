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
 	* addFlash Add notice to body
 	* @param  string $type    
 	* @param  string $message
 	* @return void  
 	*/
	protected function addFlash(string $type, string $message): void
    {
        $this->container->get('session')->getFlashBag()->add($type, $message);
    }

	/**
 	* Index action render index twig
 	* @param  Environment $twig
 	* @return Response
 	*
 	* @Route("/", name="contact_index")
 	*/
	public function index(Environment $twig): Response
	{
		$content = $twig->render('index.html.twig');
		return new Response($content);
	}

	/**
 	* Add Action render from add contact and post
 	* @param   Environment $twig
 	* @param   Request     $request
 	* @return  Response
 	*
 	* @Route("/add", name="contact_add")
 	*/
	public function add(Environment $twig, Request $request): Response
	{
		$contact = new Contact();

		$form = $this->createForm(ContactForm::class, $contact, array (
			'action' => $this->generateUrl('contact_add'),
			'method' => 'POST'));

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid())
		{
			$contact = $form->getData();
			$entityManager = $this->getDoctrine()->getManager();
        	$entityManager->persist($contact);
        	$entityManager->flush();
		
			$this->addFlash('success', 'Contact ajouté à votre répertoire');

			return $this->redirectToRoute('contact_index');
		}

		$content = $twig->render('add.html.twig', array(
            'form' => $form->createView()
        ));
		return new Response($content);
	}

	/**
 	* View Action render repository of contact
 	* @param  Environment $twig 
 	* @return Response
 	* 
 	* @Route("/", name="contact_view")
 	*/
	public function view(Environment $twig): Response
	{
		$entityManager = $this->getDoctrine()->getManager();
		$contacts = $entityManager->getRepository(Contact::class)->findBy(array('isTrash' => false));
		$content = '';
		if (empty($contacts))
		{
			return new Response('<div class="contactApp-container__content-notice">Votre liste de contact est vide pour le moment.</div>');
		}
		else {
			foreach ($contacts as $contact) 
			{
				 $form    = $this->createForm(ContactForm::class, $contact, array (
				'action'  => $this->generateUrl('contact_edit', ['id' => $contact->getId()]),
				'method'  => 'POST'));
				 $content .= $twig->render('edit.html.twig', [
	            'form'    => $form->createView()
	            ]);
			}
		}
		return new Response($content);
	}

	/**
 	* Edit Action handle edit form post, trash post and delete post
 	* @param  int          $id      id contact
 	* @param  bool|boolean $isTrash true if contact is on trash
 	* @param  Request      $request 
 	* @param  Contact      $contact 
 	* @param  Environment  $twig    
 	* @return Response 
 	*
 	* @Route("/edit/{id}", name="contact_edit", requirements={"id" ="\d+"})
 	*/
	public function edit(int $id, bool $isTrash = false, Request $request, Contact $contact, Environment $twig): Response
	{
		$form = $this->createForm(ContactForm::class, $contact);
		$form->handleRequest($request);
		$entityManager = $this->getDoctrine()->getManager();

		//Case of edit contact
		if ($form->isSubmitted() && $form->isValid() && $request->request->has('edit'))
		{
			$isTrash ?: $contact->setIsTrash(false);
			$contact = $form->getData();
		
        	$entityManager->flush();

		 	$this->addFlash('success', 'Contact édité');

			return $this->redirectToRoute('contact_index');
		}
		//Case of trash contact
		else if ($form->isSubmitted() && $form->isValid() && $request->request->has('trash'))
		{
			$contact = $form->getData();
			$contact->setIsTrash(true);

        	$entityManager->flush();

        	$this->addFlash('success', 'Contact ajouté à votre corbeille');

			return $this->redirectToRoute('contact_index');
		}
		//Case of delete contact
		else if ($form->isSubmitted() && $form->isValid() && $request->request->has('delete'))
		{
			$contact = $entityManager->getRepository(Contact::class)->find($id);
			$entityManager->remove($contact);
        	$entityManager->flush();

        	$this->addFlash('success', 'Contact supprimé définitivement');

			return $this->redirectToRoute('contact_index');
		}
		$this->addFlash('error', 'Un problème est survenu');
		$content = $twig->render('index.html.twig');
		return new Response($content);	
	}

	/**
 	* Trash action render all contact in trash and post if delete or edit
 	* @param  Environment $twig
 	* @return Response
 	*
 	* @Route("/", name="contact_trash")
 	*/
	public function trash(Environment $twig): Response
	{
		$entityManager = $this->getDoctrine()->getManager();
		$contacts = $entityManager->getRepository(Contact::class)->findBy(array('isTrash' => true));
		$content = '';
		if (empty($contacts))
		{
			$content = $twig->render('trash.html.twig', array('emptyTrash' => true));
			return new Response($content);
		}
		else {
			foreach ($contacts as $contact) 
			{
				 $form    =  $this->createForm(ContactForm::class, $contact, array (
				'action'  => $this->generateUrl('contact_edit', ['id' => $contact->getId(), 'isTrash' => true]),
				'method'  => 'POST'));
				 $content .= $twig->render('trash.html.twig', [
	            'form'    => $form->createView()
	            ]);
			}
		}
		return new Response($content);
	}
}
