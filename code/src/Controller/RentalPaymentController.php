<?php

declare(strict_types=1);

namespace App\Controller;

use App\Document\RentalPayment;
use App\Form\RentalPaymentType;
use App\Repository\RentalPaymentRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RentalPaymentController extends AbstractController
{
    private $rentalPaymentRepository;
    private $dm;

    public function __construct(RentalPaymentRepository $rentalPaymentRepository, DocumentManager $dm)
    {
        $this->rentalPaymentRepository = $rentalPaymentRepository;
        $this->dm = $dm;
    }

    /**
     * @Route("/payments", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $payment = new RentalPayment();
        $form = $this->createForm(RentalPaymentType::class, $payment, ['method' => 'POST']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->dm->persist($payment);
            $this->dm->flush();

            return new JsonResponse(['status' => 'Pago registrado!'], Response::HTTP_CREATED);
        }

        return new JsonResponse($form->getErrors(true), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/payments/{id}", methods={"GET"})
     */
    public function show(string $id): JsonResponse
    {
        $payment = $this->rentalPaymentRepository->findPaymentById($id);

        if (!$payment) {
            return new JsonResponse(['status' => 'Pago no encontrado'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($payment);
    }

    /**
     * @Route("/payments/{id}", methods={"PUT"})
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $payment = $this->rentalPaymentRepository->findPaymentById($id);

        if (!$payment) {
            return new JsonResponse(['status' => 'Pago no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(RentalPaymentType::class, $payment, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->dm->flush();

            return new JsonResponse(['status' => 'Pago actualizado!'], Response::HTTP_OK);
        }

        return new JsonResponse($form->getErrors(), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/payments/{id}", methods={"DELETE"})
     */
    public function delete(string $id): JsonResponse
    {
        $payment = $this->rentalPaymentRepository->findPaymentById($id);

        if (!$payment) {
            return new JsonResponse(['status' => 'Pago no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $this->dm->remove($payment);
        $this->dm->flush();

        return new JsonResponse(['status' => 'Pago eliminado!'], Response::HTTP_OK);
    }
}
