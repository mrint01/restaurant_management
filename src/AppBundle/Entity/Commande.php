<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ommandeRepository")
 */
class Commande
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Usr
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usr")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_client", referencedColumnName="id")
     * })
     */
    private $id_client;

    /**
     * @var string
     *
     * @ORM\Column(name="ArticleName", type="string", length=255)
     */
    private $articleName;

    /**
     * @var string
     *
     * @ORM\Column(name="PrixCmd", type="string", length=255)
     */
    private $prixCmd;

 /**
     * @var string
     *
     * @ORM\Column(name="dateCmd", type="date", length=255)
     */
    private $dateCmd;



    /**
     * @var string
     *
     * @ORM\Column(name="EtatCmd", type="string")
     */
    private $EtatCmd;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIdClient()
    {
        return $this->id_client;
    }

    /**
     * @param mixed $id_client
     */
    public function setIdClient($id_client)
    {
        $this->id_client = $id_client;
    }

    /**
     * @return string
     */
    public function getArticleName()
    {
        return $this->articleName;
    }

    /**
     * @param string $articleName
     */
    public function setArticleName($articleName)
    {
        $this->articleName = $articleName;
    }

    /**
     * @return string
     */
    public function getPrixCmd()
    {
        return $this->prixCmd;
    }

    /**
     * @param string $prixCmd
     */
    public function setPrixCmd($prixCmd)
    {
        $this->prixCmd = $prixCmd;
    }

    /**
     * @return string
     */
    public function getEtatCmd()
    {
        return $this->EtatCmd;
    }

    /**
     * @param string $EtatCmd
     */
    public function setEtatCmd($EtatCmd)
    {
        $this->EtatCmd = $EtatCmd;
    }

    /**
     * @return string
     */
    public function getDateCmd()
    {
        return $this->dateCmd;
    }

    /**
     * @param string $dateCmd
     */
    public function setDateCmd($dateCmd)
    {
        $this->dateCmd = $dateCmd;
    }



}

