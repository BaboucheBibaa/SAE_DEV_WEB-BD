<?php

require_once __DIR__ . '/../lib/jpgraph-4.4.3/src/jpgraph.php';
require_once __DIR__ . '/../lib/jpgraph-4.4.3/src/jpgraph_line.php';

class ServiceCA
{
    private $CA;

    public function __construct()
    {
        $this->CA = new CA();
    }

    public function getCAByBoutique($idBoutique, $annee = null)
    {
        return $this->CA->getCAByBoutique($idBoutique, $annee);
    }

    public function getCASeriesByBoutique($idBoutique, $annee = null)
    {
        return $this->CA->getCASeriesByBoutique($idBoutique, $annee);
    }

    public function sommeCA($idBoutique, $annee = null)
    {
        return $this->CA->sommeCA($idBoutique, $annee);
    }

    public function moyenneCA($idBoutique, $annee = null)
    {
        return $this->CA->moyenneCA($idBoutique, $annee);
    }

    public function getCAJournalier($idBoutique)
    {
        return $this->CA->getCAJournee($idBoutique);
    }

    public function getCAMensuel($idBoutique)
    {
        return $this->CA->getCAMensuel($idBoutique);
    }

    public function minMaxCA($idBoutique, $annee = null)
    {
        return $this->CA->minMaxCA($idBoutique, $annee);
    }

    
}