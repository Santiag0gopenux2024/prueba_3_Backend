<?php

declare(strict_types=1);

namespace App\Controller;

use App\Document\LeaseContract;
use App\Form\LeaseContractType;
use App\Repository\LeaseContractRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LeaseContractController extends AbstractController
{
    private $leaseContractRepository;
    private $dm;

    public function __construct(LeaseContractRepository $leaseContractRepository, DocumentManager $dm)
    {
        $this->leaseContractRepository = $leaseContractRepository;
        $this->dm = $dm;
    }

    /**
     * @Route("/contracts", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $contract = new LeaseContract();
        $form = $this->createForm(LeaseContractType::class, $contract, ['method' => 'POST']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->dm->persist($contract);
            $this->dm->flush();

            return new JsonResponse(['status' => 'Contrato creado!'], Response::HTTP_CREATED);
        }

        return new JsonResponse($form->getErrors(), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/contracts/{id}", methods={"GET"})
     */
    public function show(string $id): JsonResponse
    {
        $contract = $this->leaseContractRepository->findContractById($id);

        if (!$contract) {
            return new JsonResponse(['status' => 'Contrato no encontrado'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($contract);
    }

    /**
     * @Route("/contracts/{id}", methods={"PUT"})
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $contract = $this->leaseContractRepository->findContractById($id);

        if (!$contract) {
            return new JsonResponse(['status' => 'Contrato no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(LeaseContractType::class, $contract, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->dm->flush();

            return new JsonResponse(['status' => 'Contrato actualizado!'], Response::HTTP_OK);
        }

        return new JsonResponse($form->getErrors(), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/contracts/{id}", methods={"DELETE"})
     */
    public function delete(string $id): JsonResponse
    {
        $contract = $this->leaseContractRepository->findContractById($id);

        if (!$contract) {
            return new JsonResponse(['status' => 'Contrato no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $this->dm->remove($contract);
        $this->dm->flush();

        return new JsonResponse(['status' => 'Contrato eliminado!'], Response::HTTP_OK);
    }
}
