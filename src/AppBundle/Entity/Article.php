<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArticleRepository")
 */
class Article
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
     * @var string
     *
     * @ORM\Column(name="code_art", type="string", length=255)
     */
    private $codeArt;

    /**
     * @var string
     *
     * @ORM\Column(name="name_art", type="string", length=255)
     */
    private $nameArt;

    /**
     * @var string
     *
     * @ORM\Column(name="image_art", type="string", length=255)
     */
    private $imageArt;

    /**
     * @var string
     *
     * @ORM\Column(name="prix_art", type="float", length=255)
     */
    private $prixArt;

    /**
     * @var string
     *
     * @ORM\Column(name="type_art", type="string", length=255)
     */
    private $typeArt;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set codeArt
     *
     * @param string $codeArt
     *
     * @return Article
     */
    public function setCodeArt($codeArt)
    {
        $this->codeArt = $codeArt;

        return $this;
    }

    /**
     * Get codeArt
     *
     * @return string
     */
    public function getCodeArt()
    {
        return $this->codeArt;
    }

    /**
     * Set nameArt
     *
     * @param string $nameArt
     *
     * @return Article
     */
    public function setNameArt($nameArt)
    {
        $this->nameArt = $nameArt;

        return $this;
    }

    /**
     * Get nameArt
     *
     * @return string
     */
    public function getNameArt()
    {
        return $this->nameArt;
    }

    /**
     * Set imageArt
     *
     * @param string $imageArt
     *
     * @return Article
     */
    public function setImageArt($imageArt)
    {
        $this->imageArt = $imageArt;

        return $this;
    }

    /**
     * Get imageArt
     *
     * @return string
     */
    public function getImageArt()
    {
        return $this->imageArt;
    }

    /**
     * Set prixArt
     *
     * @param string $prixArt
     *
     * @return Article
     */
    public function setPrixArt($prixArt)
    {
        $this->prixArt = $prixArt;

        return $this;
    }

    /**
     * Get prixArt
     *
     * @return string
     */
    public function getPrixArt()
    {
        return $this->prixArt;
    }

    /**
     * Set typeArt
     *
     * @param string $typeArt
     *
     * @return Article
     */
    public function setTypeArt($typeArt)
    {
        $this->typeArt = $typeArt;

        return $this;
    }

    /**
     * Get typeArt
     *
     * @return string
     */
    public function getTypeArt()
    {
        return $this->typeArt;
    }
}

