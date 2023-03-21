<?php

namespace App\Entity;

use App\Repository\RecrutorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecrutorRepository::class)]
class Recrutor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $enterprise_address = [];

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $enterprise_name = null;

    #[ORM\OneToOne(inversedBy: 'recrutor', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'recrutor', targetEntity: JobOffer::class, orphanRemoval: true)]
    private Collection $jobOffers;

    public function __construct()
    {
        $this->jobOffers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEnterpriseAddress(): array
    {
        return $this->enterprise_address;
    }

    public function setEnterpriseAddress(?array $enterprise_address): self
    {
        $this->enterprise_address = $enterprise_address;

        return $this;
    }

    public function getEnterpriseName(): ?string
    {
        return $this->enterprise_name;
    }

    public function setEnterpriseName(?string $enterprise_name): self
    {
        $this->enterprise_name = $enterprise_name;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, JobOffer>
     */
    public function getJobOffers(): Collection
    {
        return $this->jobOffers;
    }

    public function addJobOffer(JobOffer $jobOffer): self
    {
        if (!$this->jobOffers->contains($jobOffer)) {
            $this->jobOffers->add($jobOffer);
            $jobOffer->setRecrutor($this);
        }

        return $this;
    }

    public function removeJobOffer(JobOffer $jobOffer): self
    {
        if ($this->jobOffers->removeElement($jobOffer)) {
            // set the owning side to null (unless already changed)
            if ($jobOffer->getRecrutor() === $this) {
                $jobOffer->setRecrutor(null);
            }
        }

        return $this;
    }
}
