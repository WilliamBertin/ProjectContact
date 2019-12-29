<?php
// src/Controller/ContactApiController.php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;
use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use JMS\Serializer\SerializationContext;

/**
 * Class ContactController
 *
 * Define global route to controller
 * @Route("/contact/api")
 */
class ContactApiController extends AbstractController
{


    /**
    * @Route("/", name="contact_api_index")
    */
    public function index(Environment $twig): Response
    {
        $content = $twig->render('api.html.twig');
        return new Response($content);
    }

    /**
     * @Route("/viewById/{id}")
     * @Method({"GET"})
     */
    public function viewById(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $result = $entityManager->getRepository(Contact::class)->find($id);
        if (empty($result)) {
            return new JsonResponse(['message' => "Contact non trouvé pour l'id : ".$id], Response::HTTP_NOT_FOUND);
        }
        $data = $this->get('serializer')->serialize($result, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/viewByFirstname/{firstname}")
     * @Method({"GET"})
     */
    public function viewByFirstname(string $firstname)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $result = $entityManager->getRepository(Contact::class)->findBy(array('firstname' => $firstname));
        if (empty($result)) {
            return new JsonResponse(['message' => "Contact non trouvé pour le nom : ".$firstname], Response::HTTP_NOT_FOUND);
        }
        $data = $this->get('serializer')->serialize($result, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/viewByLastname/{lastname}")
     * @Method({"GET"})
     */
    public function viewByLastname(string $lastname)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $result = $entityManager->getRepository(Contact::class)->findBy(array('lastname' => $lastname));
        if (empty($result)) {
            return new JsonResponse(['message' => "Contact non trouvé pour le prénom : ".$lastname], Response::HTTP_NOT_FOUND);
        }
        $data = $this->get('serializer')->serialize($result, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

     /**
     * @Route("/viewByFullname/{fullname}")
     * @Method({"GET"})
     */
    public function viewByFullname(string $fullname)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $result = $entityManager->getRepository(Contact::class)->findBy(array('fullname' => $fullname));
        if (empty($result)) {
            return new JsonResponse(['message' => "Contact non trouvé pour le nom complet : ".$fullname], Response::HTTP_NOT_FOUND);
        }
        $data = $this->get('serializer')->serialize($result, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

     /**
     * @Route("/viewByEmail/{email}")
     * @Method({"GET"})
     */
    public function viewByEmail(string $email)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $result = $entityManager->getRepository(Contact::class)->findBy(array('email' => $email));
        if (empty($result)) {
            return new JsonResponse(['message' => "Contact non trouvé pour l'email' : ".$email], Response::HTTP_NOT_FOUND);
        }
        $data = $this->get('serializer')->serialize($result, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

     /**
     * @Route("/search/{search}")
     * @Method({"GET"})
     */
    public function search($search)
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        $result = $entityManager
        ->createQuery(
            'SELECT contact FROM App:Contact contact WHERE 
            contact.firstname LIKE :search OR
            contact.lastname  LIKE :search OR
            contact.fullname  LIKE :search OR
            contact.email     LIKE :search '
        )
        ->setParameter('search', '%' . $search . '%')
        ->getResult();

        if (empty($result)) {
            return new JsonResponse(['message' => "Contact non trouvé pour la recherche ' : ".$search], Response::HTTP_NOT_FOUND);
        }
        $data = $this->get('serializer')->serialize($result, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/viewAll")
     * @Method({"GET"})
     */
    public function viewAll()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $result =  $entityManager->getRepository(Contact::class)->findAll();
        if (empty($result)) {
            return new JsonResponse(['message' => "Vous n'avez pas encore de contact dans votre répertoire ou votre corbeille"], Response::HTTP_NOT_FOUND);
        }
        $data = $this->get('serializer')->serialize($result, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/viewContacts")
     * @Method({"GET"})
     */
    public function viewContacts()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $result = $entityManager->getRepository(Contact::class)->findBy(array('isTrash' => false));
        if (empty($result)) {
            return new JsonResponse(['message' => "Vous n'avez pas encore de contact dans votre répertoire"], Response::HTTP_NOT_FOUND);
        }
        $data = $this->get('serializer')->serialize($result, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

     /**
     * @Route("/viewTrash")
     * @Method({"GET"})
     */
    public function viewTrash()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $result = $entityManager->getRepository(Contact::class)->findBy(array('isTrash' => true));
        if (empty($result)) {
            return new JsonResponse(['message' => "Vous n'avez pas encore de contact dans votre corbeille"], Response::HTTP_NOT_FOUND);
        }
        $data = $this->get('serializer')->serialize($result, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $result = $entityManager->getRepository(Contact::class)->find($id);
        if (empty($result)) {
            return new JsonResponse(['message' => "Contact non trouvé pour l'id : ".$id], Response::HTTP_NOT_FOUND);
        }
        $entityManager->remove($result);
        $entityManager->flush();
        return new JsonResponse(['message' => "Contact : ".$id." Supprimé."], Response::HTTP_OK);
    }

    /**
     * @Route("/trash/{id}")
     * @Method({"POST"})
     */
    public function trash(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $result = $entityManager->getRepository(Contact::class)->find($id);
        if (empty($result)) {

            return new JsonResponse(['message' => "Contact non trouvé pour l'id : ".$id], Response::HTTP_NOT_FOUND);
        }
        $result->setIsTrash(true);
        $entityManager->flush();

        return new JsonResponse(['message' => "Contact : ".$id." ajouté à la corbeille."], Response::HTTP_OK);
    }

    /**
     * @Route("/removeFromTrash/{id}")
     * @Method({"POST"})
     */
    public function removeFromTrash(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $result = $entityManager->getRepository(Contact::class)->find($id);
        if (empty($result)) {
            return new JsonResponse(['message' => "Contact non trouvé pour l'id : ".$id], Response::HTTP_NOT_FOUND);
        }
        $result->setIsTrash(false);
        $entityManager->flush();

        return new JsonResponse(['message' => "Contact : ".$id." retiré de la corbeille."], Response::HTTP_OK);
    }

    /**
     * @Route("/add")
     * @Method({"POST"})
     */
    public function add(Request $request)
    {
        $firstname = $request->get('firstname'); 
        $lastname = $request->get('lastname'); 
        $fullname = $request->get('fullname'); 
        $email = $request->get('email');

        if (empty($fullname) || empty($email)) 
        {
            return new JsonResponse(['message' => "Les informations de mail et fullname ne peuvent être vide"], Response::HTTP_BAD_REQUEST);
        }

        $contact = new Contact();
        $contact->setFirstname($firstname);
        $contact->setLastname($lastname);
        $contact->setFullname($fullname);
        $contact->setEmail($email);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($contact);
        $entityManager->flush();

        return new JsonResponse(['message' => "Contact créé."], Response::HTTP_CREATED);
    }

     /**
     * @Route("/edit/{id}")
     * @Method({"POST"})
     */
    public function edit(Request $request, int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $result = $entityManager->getRepository(Contact::class)->find($id);
        if (empty($result)) {
            return new JsonResponse(['message' => "Contact non trouvé pour l'id : ".$id], Response::HTTP_NOT_FOUND);
        }

        $firstname = $request->get('firstname'); 
        $lastname = $request->get('lastname'); 
        $fullname = $request->get('fullname'); 
        $email = $request->get('email');

        if (empty($fullname) || empty($email)) 
        {
            return new JsonResponse(['message' => "Les informations de mail et fullname ne peuvent être vide"], Response::HTTP_BAD_REQUEST);
        }

        $result->setFirstname($firstname);
        $result->setLastname($lastname);
        $result->setFullname($fullname);
        $result->setEmail($email);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($result);
        $entityManager->flush();

        return new JsonResponse(['message' => "Contact : ".$id." édité."], Response::HTTP_OK);
    }
}
