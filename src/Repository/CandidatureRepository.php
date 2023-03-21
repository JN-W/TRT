<?php

namespace App\Repository;

use App\Entity\Candidature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Candidature>
 *
 * @method Candidature|null find($id, $lockMode = null, $lockVersion = null)
 * @method Candidature|null findOneBy(array $criteria, array $orderBy = null)
 * @method Candidature[]    findAll()
 * @method Candidature[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Candidature::class);
    }

    public function save(Candidature $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Candidature $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Candidature[] Returns an array of Candidature objects
     */
    public function findAllCandidaturesToValidate(): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.validated = :val')
            ->setParameter('val', false)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function cancelCandidature($currentCandidate, $jobOffer)
    {
        $candidatureToCancel =  $this->createQueryBuilder('j')
            ->Where('j.candidate = :currentCandidate ')
            ->andWhere('j.jobOffer = :jobOffer ')
            ->setParameter('currentCandidate', $currentCandidate)
            ->setParameter('jobOffer', $jobOffer)
            ->getQuery()
            ->getResult()
            ;
        dd($candidatureToCancel);
        $this->getEntityManager()->remove($candidatureToCancel);
        $this->getEntityManager()->flush();

    }


//    /**
//     * @return Candidature[] Returns an array of Candidature objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Candidature
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
