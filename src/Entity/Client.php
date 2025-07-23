<?php

namespace App\Entity;

use App\Entity\Branding\BrandingProject;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $companyName = null;

    #[ORM\OneToOne(inversedBy: 'client', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userInfo = null;

    /**
     * @var Collection<int, BrandingProject>
     */
    #[ORM\OneToMany(targetEntity: BrandingProject::class, mappedBy: 'client')]
    private Collection $brandingProjects;

    public function __construct()
    {
        $this->brandingProjects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): static
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getUserInfo(): ?User
    {
        return $this->userInfo;
    }

    public function setUserInfo(User $userInfo): static
    {
        $this->userInfo = $userInfo;

        return $this;
    }

    /**
     * @return Collection<int, BrandingProject>
     */
    public function getBrandingProjects(): Collection
    {
        return $this->brandingProjects;
    }

    public function addBrandingProject(BrandingProject $brandingProject): static
    {
        if (!$this->brandingProjects->contains($brandingProject)) {
            $this->brandingProjects->add($brandingProject);
            $brandingProject->setClient($this);
        }

        return $this;
    }

    public function removeBrandingProject(BrandingProject $brandingProject): static
    {
        if ($this->brandingProjects->removeElement($brandingProject)) {
            // set the owning side to null (unless already changed)
            if ($brandingProject->getClient() === $this) {
                $brandingProject->setClient(null);
            }
        }

        return $this;
    }
}
