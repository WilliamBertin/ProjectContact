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

	protected function addFlash($type, $message)
    {
        $this->container->get('session')->getFlashBag()->add($type, $message);
    }

	/**
 	* Index action
 	* @param  Environment $twig [Template to return]
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
 	* @Route("/", name="contact_view")
 	*/
	public function view(Environment $twig)
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
	 * @Route("/edit/{id}", name="contact_edit", requirements={"id" ="\d+"})
	 */
	public function edit(int $id, bool $isTrash = false, Request $request, Contact $contact, Environment $twig): Response
	{
		$form = $this->createForm(ContactForm::class, $contact);

		$form->handleRequest($request);
		$entityManager = $this->getDoctrine()->getManager();

		if ($form->isSubmitted() && $form->isValid() && $request->request->has('edit'))
		{
			$isTrash ?: $contact->setIsTrash(false);
			$contact = $form->getData();
		
        	$entityManager->flush();

		 	$this->addFlash('success', 'Contact édité');

			return $this->redirectToRoute('contact_index');
		}
		else if ($form->isSubmitted() && $form->isValid() && $request->request->has('trash'))
		{
			$contact = $form->getData();
			$contact->setIsTrash(true);

        	$entityManager->flush();

        	$this->addFlash('success', 'Contact ajouté à votre corbeille');

			return $this->redirectToRoute('contact_index');
		}
		else if ($form->isSubmitted() && $form->isValid() && $request->request->has('delete'))
		{
			$contact = $entityManager->getRepository(Contact::class)->find($id);
			$entityManager->remove($contact);
        	$entityManager->flush();

        	$this->addFlash('success', 'Contact supprimé définitivement');

			return $this->redirectToRoute('contact_index');
		}
		$content = '';
		$this->addFlash('error', 'Un problème est survenu');
		$content = $twig->render('index.html.twig');
		return new Response($content);	
	}

	/**
 	* @Route("/", name="contact_trash")
 	*/
	public function trash(Environment $twig)
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