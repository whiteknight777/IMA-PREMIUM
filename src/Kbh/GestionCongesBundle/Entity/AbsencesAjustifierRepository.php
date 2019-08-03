<?php

namespace Kbh\GestionCongesBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * AbsencesAjustifierRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AbsencesAjustifierRepository extends EntityRepository
{
    public function findAbsencesEnAttente(){
       $qb = $this->createQueryBuilder('n');

        $qb->where('n.statut = :statut')
                ->setParameter('statut', "En attente")
                ->setMaxResults(5)
                ->orderBy('n.dateEnvoi', 'DESC');

        return $qb->getQuery()->getResult();
    }
    
    public function findAbsencesJustifiees(){
       $qb = $this->createQueryBuilder('n');

        $qb->where('n.statut = :statut')
                ->setParameter('statut', "Justifiees")
                ->setMaxResults(5)
                ->orderBy('n.dateEnvoi', 'DESC');

        return $qb->getQuery()->getResult();
    }
}