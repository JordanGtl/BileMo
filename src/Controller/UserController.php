<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Serializer;

class UserController extends AbstractController
{
    /**
     * @Route("/users", name="user")
     */
    public function index()
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    /**
     * @Route("/api/users/{id}", name="userslist", methods={"GET"})
     */
    public function usercheck($id, UserRepository $userRepository, TokenStorageInterface $tokenStorage)
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer = new ObjectNormalizer($classMetadataFactory);

       $user = $userRepository->findOneBy(['id' => $id]);

       if($user == null)
       {
           $data['@context'] = "/contexts/Error";
           $data['@type'] = "Error";
           $data['hydra:title'] = "An error occurred";
           $data['hydra:description'] = "The user $id does not exist";
           return $this->json($data, 404);
       }

       if($user->getClient() != $tokenStorage->getToken()->getUser())
       {
           $data['@context'] = "/contexts/Error";
           $data['@type'] = "Error";
           $data['hydra:title'] = "An error occurred";
           $data['hydra:description'] = "The user $id does not exist";
           return $this->json($data, 404);
       }

        $serializer = new Serializer(array($normalizer));
        $data = $serializer->normalize($user, 'json', array('groups' => array('get')));

       return $this->json($data);
    }

    /**
     * @Route("/api/users/{id}", name="usersdel", methods={"DELETE"})
     */
    public function userdelete($id, UserRepository $userRepository, TokenStorageInterface $tokenStorage, EntityManagerInterface $em)
    {
        $user = $userRepository->findOneBy(['id' => $id]);

        if($user == null || $user->getClient() != $tokenStorage->getToken()->getUser())
        {
            $data['@context'] = "/contexts/Error";
            $data['@type'] = "Error";
            $data['hydra:title'] = "An error occurred";
            $data['hydra:description'] = "The user $id does not exist";
            return $this->json($data, 404);
        }

        $em->remove($user);
        $em->flush();
    }

    /**
     * @Route("/api/users/{id}", name="usersdel", methods={"PUT"})
     */
    public function useredit($id, UserRepository $userRepository, TokenStorageInterface $tokenStorage, EntityManagerInterface $em, Request $request)
    {
        $user = $userRepository->findOneBy(['id' => $id]);
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer = new ObjectNormalizer($classMetadataFactory);

        if($user == null || $user->getClient() != $tokenStorage->getToken()->getUser())
        {
            $data['@context'] = "/contexts/Error";
            $data['@type'] = "Error";
            $data['hydra:title'] = "An error occurred";
            $data['hydra:description'] = "The user $id does not exist";
            return $this->json($data, 404);
        }

        $put = json_decode($request->getContent());

        if($put->firstname == "")
        {
            $data['@context'] = "/contexts/Error";
            $data['@type'] = "Error";
            $data['hydra:title'] = "An error occurred";
            $data['hydra:description'] = "Firstname cannot be empty";
            return $this->json($data, 400);
        }
        else if($put->lastname == "")
        {
            $data['@context'] = "/contexts/Error";
            $data['@type'] = "Error";
            $data['hydra:title'] = "An error occurred";
            $data['hydra:description'] = "Lastname cannot be empty";
            return $this->json($data, 400);
        }
        else if($put->adress == "")
        {
            $data['@context'] = "/contexts/Error";
            $data['@type'] = "Error";
            $data['hydra:title'] = "An error occurred";
            $data['hydra:description'] = "Adress cannot be empty";
            return $this->json($data, 400);
        }
        else if($put->city == "")
        {
            $data['@context'] = "/contexts/Error";
            $data['@type'] = "Error";
            $data['hydra:title'] = "An error occurred";
            $data['hydra:description'] = "City name cannot be empty";
            return $this->json($data, 400);
        }
        else if($put->postalCode == "")
        {
            $data['@context'] = "/contexts/Error";
            $data['@type'] = "Error";
            $data['hydra:title'] = "An error occurred";
            $data['hydra:description'] = "Postal Code cannot be empty";
            return $this->json($data, 400);
        }

        $user->setFirstname($put->firstname);
        $user->setLastname($put->lastname);
        $user->setAdress($put->adress);
        $user->setCity($put->city);
        $user->setPostalCode($put->postalCode);
        $em->flush();

        $serializer = new Serializer(array($normalizer));
        $data = $serializer->normalize($user, 'json', array('groups' => array('get')));

        return $this->json($data);
    }
}
