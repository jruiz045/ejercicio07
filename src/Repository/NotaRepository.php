<?php

namespace App\Repository;

use App\Entity\Nota;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Nota|null find($id, $lockMode = null, $lockVersion = null)
 * @method Nota|null findOneBy(array $criteria, array $orderBy = null)
 * @method Nota[]    findAll()
 * @method Nota[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Nota::class);
    }

    // /**
    //  * @return Nota[] Returns an array of Nota objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Nota
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
    public function findNotasByAlumno($alumno_id) {
         
         $query = $this->getEntityManager()->createQuery(
                 'SELECT MAX(n.nota) nota, MAX(n.fecha) fecha, MAX(n.nConvocatoria) nConvocatoria, MAX(n.id) id '
                 . 'FROM App:Nota n '
                 . 'WHERE n.alumnoId = ?1 '
                 . 'GROUP BY n.asignaturaId ');
         
         $query->setParameter(1, $alumno_id);
         $notas = $query->getResult();
         return $notas;
    }
}
