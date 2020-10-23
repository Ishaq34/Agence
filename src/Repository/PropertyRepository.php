<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    // Je crée une fonction FindAllVisible ou je spécifie "p" = properties, where properties.sold = false et je return le resultat
    public function findAllVisible()
    {
        return $this->createQueryBuilder('p')               // crée un objet qui concois une requete et on lui ajoute un alias (p comme property)
            -> where ('p.sold = false')                     // parametre
            ->getQuery()                                    // recupere la requete
            ->getResult()                                   // recupere les resultats 
        ;
    }
    public function findById($id)
    {
        return $this->createQueryBuilder('p')
        ->where('p.id = :id')
        ->setParameter('id', $id)
        ->getQuery()
        ->getResult();
    }


}
