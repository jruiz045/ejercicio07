<?php

namespace App\Controller;

use App\Entity\Asignatura;
use App\Form\AsignaturaType;
use App\Repository\AsignaturaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/asignatura")
 */
class AsignaturaController extends AbstractController
{
    /**
     * @Route("/", name="asignatura_index", methods={"GET"})
     */
    public function index(AsignaturaRepository $asignaturaRepository): Response
    {
        return $this->render('asignatura/index.html.twig', [
            'asignaturas' => $asignaturaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="asignatura_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $asignatura = new Asignatura();
        $form = $this->createForm(AsignaturaType::class, $asignatura);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($asignatura);
            $entityManager->flush();

            return $this->redirectToRoute('asignatura_index');
        }

        return $this->render('asignatura/new.html.twig', [
            'asignatura' => $asignatura,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="asignatura_show", methods={"GET"})
     */
    public function show(Asignatura $asignatura): Response
    {
        return $this->render('asignatura/show.html.twig', [
            'asignatura' => $asignatura,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="asignatura_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Asignatura $asignatura): Response
    {
        $form = $this->createForm(AsignaturaType::class, $asignatura);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('asignatura_index');
        }

        return $this->render('asignatura/edit.html.twig', [
            'asignatura' => $asignatura,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="asignatura_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Asignatura $asignatura): Response
    {
        if ($this->isCsrfTokenValid('delete'.$asignatura->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($asignatura);
            $entityManager->flush();
        }

        return $this->redirectToRoute('asignatura_index');
    }
}
