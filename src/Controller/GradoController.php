<?php

namespace App\Controller;

use App\Entity\Grado;
use App\Form\GradoType;
use App\Repository\GradoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/grado")
 */
class GradoController extends AbstractController
{
    /**
     * @Route("/", name="grado_index", methods={"GET"})
     */
    public function index(GradoRepository $gradoRepository): Response
    {
        return $this->render('grado/index.html.twig', [
            'grados' => $gradoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="grado_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $grado = new Grado();
        $form = $this->createForm(GradoType::class, $grado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($grado);
            $entityManager->flush();

            return $this->redirectToRoute('grado_index');
        }

        return $this->render('grado/new.html.twig', [
            'grado' => $grado,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="grado_show", methods={"GET"})
     */
    public function show(Grado $grado): Response
    {
        return $this->render('grado/show.html.twig', [
            'grado' => $grado,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="grado_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Grado $grado): Response
    {
        $form = $this->createForm(GradoType::class, $grado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('grado_index');
        }

        return $this->render('grado/edit.html.twig', [
            'grado' => $grado,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="grado_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Grado $grado): Response
    {
        if ($this->isCsrfTokenValid('delete'.$grado->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($grado);
            $entityManager->flush();
        }

        return $this->redirectToRoute('grado_index');
    }
}
