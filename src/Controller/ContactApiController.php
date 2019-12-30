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
 * Class ContactApiController
 *
 * Define global route to controller
 * @Route("/contact/api")
 */
class ContactApiController extends AbstractController
{

    /**
    * Index Action render api twig
    * @param  Environment $twig
    * @return Response
    *
    * @Route("/", name="contact_api_index")
    */
    public function index(Environment $twig): Response
    {
        $content = $twig->render('api.html.twig');
        return new Response($content);
    }

    /**
    * viewById Action display information of contact according to id search
    * @param  int $id id contact
    * @return mixed
    *
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
    * viewByFirstname Action display information of contact according to firstname search
    * @param  string $firstname firstname of contact
    * @return mixed
    *
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
    * viewByLastname Action display information of contact according to lastname search
    * @param  string $lastname lastname of contact
    * @return mixed
    *
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
    * viewByFullname Action display information of contact according to fullname search
    * @param  string $fullname fullname of contact
    * @return mixed
    *
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
    * viewByEmail Action display information of contact according to email search
    * @param  string $email email of contact
    * @return mixed
    *
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
    * search Action display information of contact according to search term
    * @param  string $search term of search can be firstname, lastname, fullname or email
    * @return mixed
    *
    * @Route("/search/{search}")
    * @Method({"GET"})
    */
    public function search(string $search)
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
    * viewAll Action display all contact, repository or trash
    * @return mixed
    *
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
    * viewContacts Action diplay all contact of repository
    * @return mixed
    *
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
    * viewTrash Action display all contact of trash
    * @return mixed
    * 
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
    * delete Action delete a contact definitely
    * @param  int $id id contact
    * @return JsonReponse
    *
    * @Route("/delete/{id}")
    * @Method({"DELETE"})
    */
    public function delete(int $id): JsonResponse
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
    * trash Action send a contact to the trash
    * @param  int $id id contact
    * @return JsonReponse
    *
    * @Route("/trash/{id}")
    * @Method({"POST"})
    */
    public function trash(int $id): JsonResponse
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
    * removeFromTrash Action remove a contact from trash and add it to repository
    * @param  int $id id contact
    * @return JsonReponse
    *
    * @Route("/removeFromTrash/{id}")
    * @Method({"POST"})
    */
    public function removeFromTrash(int $id): JsonResponse
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
    * add Action add contact
    * @param  Request $request 
    * @return JsonReponse 
    * 
    * @Route("/add")
    * @Method({"POST"})
    */
    public function add(Request $request): JsonResponse
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
    * edit Action edit contact
    * @param  Request $request 
    * @param  int     $id      id contact
    * @return JsonReponse
    *
    * @Route("/edit/{id}")
    * @Method({"POST"})
    */
    public function edit(Request $request, int $id): JsonResponse
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

        $entityManager->persist($result);
        $entityManager->flush();

        return new JsonResponse(['message' => "Contact : ".$id." édité."], Response::HTTP_OK);
    }
}
