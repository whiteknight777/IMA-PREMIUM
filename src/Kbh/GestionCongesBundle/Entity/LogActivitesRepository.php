<?php

namespace Kbh\GestionCongesBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * LogActivitesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LogActivitesRepository extends EntityRepository
{
    public function findActivites($salarie){
        $qb = $this->createQueryBuilder('n');

        $qb->where('n.salarie = :salarie')
           ->setParameter('salarie', $salarie)
           ->orderBy('n.dateCreation', 'DESC');

        return $qb->getQuery()->getResult();
    }
    
    public function findActivitesSupAdmin(){
        $qb = $this->createQueryBuilder('n');

        $qb->orderBy('n.dateCreation', 'DESC');

        return $qb->getQuery()->getResult();
    }

    public function findMonthActivities($month, $salarie){
        $qb = $this->createQueryBuilder('n');
        //Récupération de l'année
        $today = new \DateTime();
        $year = date('Y', $today->getTimestamp());
        $day = $year.'-'.$month.'-15';
        
        //Création des dates intervalles
        $datedebut = $year.'-'.$month.'-01';
        $dateFin = $year.'-'.$month.'-28';
        
        $qb->where(':day BETWEEN :debut AND :fin')
             ->andWhere('n.salarie = :salarie ')  
            ->setParameter('debut', $datedebut)
            ->setParameter('fin', $dateFin)
            ->setParameter('day', $today)
            ->setParameter('salarie', $salarie);

        return $qb->getQuery()->getResult();
    }
}