<?php

declare(strict_types=1);

namespace App\Controller;

use App\Document\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $userRepository;
    private $dm;

    public function __construct(UserRepository $userRepository, DocumentManager $dm)
    {
        $this->userRepository = $userRepository;
        $this->dm = $dm;
    }

    /**
     * @Route("/users", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, ['method' => 'POST']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->dm->persist($user);
            $this->dm->flush();

            return new JsonResponse(['status' => 'Usuario creado!'], Response::HTTP_CREATED);
        }

        return new JsonResponse($form->getErrors(), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/users/{id}", methods={"GET"})
     */
    public function show(string $id): JsonResponse
    {
        $user = $this->userRepository->findUserById($id);

        if (!$user) {
            return new JsonResponse(['status' => 'Usuario no encontrado'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($user);
    }

    /**
     * @Route("/users/{id}", methods={"PUT"})
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $user = $this->userRepository->findUserById($id);

        if (!$user) {
            return new JsonResponse(['status' => 'Usuario no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(UserType::class, $user, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->dm->flush();

            return new JsonResponse(['status' => 'Usuario actualizado!'], Response::HTTP_OK);
        }

        return new JsonResponse($form->getErrors(), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/users/{id}", methods={"DELETE"})
     */
    public function delete(string $id): JsonResponse
    {
        $user = $this->userRepository->findUserById($id);

        if (!$user) {
            return new JsonResponse(['status' => 'Usuario no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $this->dm->remove($user);
        $this->dm->flush();

        return new JsonResponse(['status' => 'Usuario eliminado!'], Response::HTTP_OK);
    }
}
