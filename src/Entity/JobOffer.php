<?php

namespace App\Entity;

use App\Repository\JobOfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobOfferRepository::class)]
class JobOffer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $Title = null;

    #[ORM\Column(length: 100)]
    private ?string $Location = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Detailled_description = null;

    #[ORM\ManyToOne(inversedBy: 'jobOffers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recrutor $recrutor = null;

    #[ORM\OneToMany(mappedBy: 'jobOffer', targetEntity: Candidature::class, orphanRemoval: true)]
    private Collection $candidatures;

    #[ORM\Column]
    private ?bool $validated = null;

    #[ORM\ManyToOne(inversedBy: 'jobOffers')]
    private ?Consultant $consultant = null;

    public function __construct()
    {
        $this->candidatures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->Location;
    }

    public function setLocation(string $Location): self
    {
        $this->Location = $Location;

        return $this;
    }

    public function getDetailledDescription(): ?string
    {
        return $this->Detailled_description;
    }

    public function setDetailledDescription(string $Detailled_description): self
    {
        $this->Detailled_description = $Detailled_description;

        return $this;
    }

    public function getRecrutor(): ?Recrutor
    {
        return $this->recrutor;
    }

    public function setRecrutor(?Recrutor $recrutor): self
    {
        $this->recrutor = $recrutor;

        return $this;
    }

    /**
     * @return Collection<int, Candidature>
     */
    public function getCandidatures(): Collection
    {
        return $this->candidatures;
    }

    public function addCandidature(Candidature $candidature): self
    {
        if (!$this->candidatures->contains($candidature)) {
            $this->candidatures->add($candidature);
            $candidature->setJobOffer($this);
        }

        return $this;
    }

    public function removeCandidature(Candidature $candidature): self
    {
        if ($this->candidatures->removeElement($candidature)) {
            // set the owning side to null (unless already changed)
            if ($candidature->getJobOffer() === $this) {
                $candidature->setJobOffer(null);
            }
        }

        return $this;
    }

    public function isValidated(): ?bool
    {
        return $this->validated;
    }

    public function setValidated(bool $validated): self
    {
        $this->validated = $validated;

        return $this;
    }

    public function getConsultant(): ?Consultant
    {
        return $this->consultant;
    }

    public function setConsultant(?Consultant $consultant): self
    {
        $this->consultant = $consultant;

        return $this;
    }
}
