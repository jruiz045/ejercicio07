<?php

namespace App\Controller;

use App\Entity\Alumno;
use App\Entity\Asignatura;
use App\Form\AlumnoType;
use App\Repository\AlumnoRepository;
use App\Repository\AsignaturaRepository;
use App\Repository\NotaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * @Route("/alumno")
 */
class AlumnoController extends AbstractController
{
    /**
     * @Route("/", name="alumno_index", methods={"GET"})
     */
    public function index(AlumnoRepository $alumnoRepository): Response
    {
        return $this->render('alumno/index.html.twig', [
            'alumnos' => $alumnoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="alumno_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $alumno = new Alumno();
        $form = $this->createForm(AlumnoType::class, $alumno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($alumno);
            $entityManager->flush();

            return $this->redirectToRoute('alumno_index');
        }

        return $this->render('alumno/new.html.twig', [
            'alumno' => $alumno,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="alumno_show", methods={"GET"})
     */
    public function show(Alumno $alumno): Response
    {
        return $this->render('alumno/show.html.twig', [
            'alumno' => $alumno,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="alumno_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Alumno $alumno): Response
    {
        $form = $this->createForm(AlumnoType::class, $alumno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('alumno_index');
        }

        return $this->render('alumno/edit.html.twig', [
            'alumno' => $alumno,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="alumno_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Alumno $alumno): Response
    {
        if ($this->isCsrfTokenValid('delete'.$alumno->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($alumno);
            $entityManager->flush();
        }

        return $this->redirectToRoute('alumno_index');
    }
    
    /**
     * @Route("/{id}/notas", name="alumno_notas", methods={"GET"})
     */
    public function notas(Request $request, Alumno $alumno, NotaRepository $notaRepository) : Response
    {
        $form = $this->createForm(AlumnoType::class, $alumno);
        $form->handleRequest($request);

        return $this->render('alumno/notas.html.twig', [
            //'notas' => $alumno->getNotas(),
            'notas' => $notaRepository->findNotasByAlumno($alumno->getId()),
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/{id}/asignaturas", name="alumno_asignaturas", methods={"GET"})
     */
    public function asignaturas(Request $request, Alumno $alumno) : Response
    {
        $form = $this->createForm(AlumnoType::class, $alumno);
        $form->handleRequest($request);

        return $this->render('alumno/asignaturas.html.twig', [
            'alumno' => $alumno,
            'asignaturas' => $alumno->getAsignaturas(),
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/{id}/asignaturas/add", name="alumno_asignaturas_add", methods={"GET","POST"})
     */
    public function addAsignatura(Request $request, Alumno $alumno, AsignaturaRepository $asignaturaRepository)
    {
        $form = $this->createFormBuilder()
            ->add('asignatura', EntityType::class, [
                 'class' => Asignatura::class,
                 'choice_label' => 'nombre',
            ])  
            ->add('Save', SubmitType::class)
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ssignaturaId = $form->get('asignatura')->getData()->getId();
            $asignatura = $asignaturaRepository->find($ssignaturaId);
            $alumno->addAsignatura($asignatura);
            $this->getDoctrine()->getManager()->flush();
            
            return $this->redirectToRoute('alumno_asignaturas', [
                'id' => $alumno->getId()
            ]);
        }

        return $this->render('alumno/asignaturas_add.html.twig', [
            'form' => $form->createView(),
            'alumno' => $alumno
        ]);
    }
    
    /*public function addAsignatura(AsignaturaRepository $asignaturaRepository, Request $request, Alumno $alumno, Asignatura $asignatura): Response
    {
        $form = $this->createForm(AlumnoType::class, $alumno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $alumno->addAsignatura($asignatura);
            $entityManager->persist($alumno);
            $entityManager->flush();

            return $this->redirectToRoute('alumno_asigntaruras');
        }
        
        return $this->render('alumno/asignaturas_add.html.twig', [
            'alumno' => $alumno,
            'asignaturas' => $asignaturaRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }*/
    
    /**
     * @Route("/{alumno}/asignatura/{asignatura}/remove", name="alumno_asignaturas_remove", methods={"GET","POST"})
     */
    public function removeAsignatura(Alumno $alumno, Asignatura $asignatura)
    {
        //dump($alumno);
        //dump($asignatura);
        //exit;
        $alumno->removeAsignatura($asignatura);
        $this->getDoctrine()->getManager()->flush();
        
        return $this->redirectToRoute('alumno_asignaturas', [
                'id' => $alumno->getId()
        ]);
        
    }
}
