<?php

namespace App\Entity\Auth;

use App\Entity\Branding\BrandingProject;
use App\Entity\Subscription\Subscription;
use App\Repository\Auth\ClientRepository;
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

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $companyArea = null;

    /**
     * @var Collection<int, Subscription>
     */
    #[ORM\OneToMany(targetEntity: Subscription::class, mappedBy: 'client')]
    private Collection $subscriptions;

    #[ORM\Column(nullable: true)]
    private ?int $tokendSent = null;

    public function __construct()
    {
        $this->brandingProjects = new ArrayCollection();
        $this->subscriptions = new ArrayCollection();
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

    public function getCompanyArea(): ?string
    {
        return $this->companyArea;
    }

    public function setCompanyArea(?string $companyArea): static
    {
        $this->companyArea = $companyArea;

        return $this;
    }

    /**
     * @return Collection<int, Subscription>
     */
    public function getSubscriptions(): Collection
    {
        return $this->subscriptions;
    }

    public function addSubscription(Subscription $subscription): static
    {
        if (!$this->subscriptions->contains($subscription)) {
            $this->subscriptions->add($subscription);
            $subscription->setClient($this);
        }

        return $this;
    }

    public function removeSubscription(Subscription $subscription): static
    {
        if ($this->subscriptions->removeElement($subscription)) {
            // set the owning side to null (unless already changed)
            if ($subscription->getClient() === $this) {
                $subscription->setClient(null);
            }
        }

        return $this;
    }

    public function getTokendSent(): ?int
    {
        return $this->tokendSent;
    }

    public function setTokendSent(?int $tokendSent): static
    {
        $this->tokendSent = $tokendSent;

        return $this;
    }
}
