<?php



namespace App\Repository;

use App\Entity\Activitesequencetheorique;
use App\Entity\Sequencetheorique;
use Doctrine\ORM\EntityRepository;

class ActivitesequencetheoriqueRepository extends EntityRepository
{
    /**
     * @return Activitesequencetheorique[]
     */
    public function findAllBySequencetheorique(Sequencetheorique $st)
    {
        return $this->createQueryBuilder('Activitesequencetheorique')
            ->andWhere('Activitesequencetheorique.idsequencetheorique_id = :idsequencetheorique')
            ->setParameter('idsequencetheorique', $st->getId())
            ->orderBy('Activitesequencetheorique.ordre', 'ASC')
//            ->leftJoin('genus.genusScientists', 'genusScientist')
//            ->addSelect('genusScientist')
            ->getQuery()
            ->execute();
    }
}