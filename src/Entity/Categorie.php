<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 80)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Jeu::class)]
    private Collection $jeu;

    public function __construct()
    {
        $this->jeu = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Jeu>
     */
    public function getJeu(): Collection
    {
        return $this->jeu;
    }

    public function addJeu(Jeu $jeu): static
    {
        if (!$this->jeu->contains($jeu)) {
            $this->jeu->add($jeu);
            $jeu->setCategorie($this);
        }

        return $this;
    }

    public function removeJeu(Jeu $jeu): static
    {
        if ($this->jeu->removeElement($jeu)) {
            // set the owning side to null (unless already changed)
            if ($jeu->getCategorie() === $this) {
                $jeu->setCategorie(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }
}
