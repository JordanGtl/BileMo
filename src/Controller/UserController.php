<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/api/users/{id}", name="userslist")
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
}
