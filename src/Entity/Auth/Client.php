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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slogan = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $tonVoice = null;

    #[ORM\Column(nullable: true)]
    private ?array $qualities = null;

    #[ORM\Column(length: 200)]
    private ?string $publicTarget = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $mainService = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $mainLanguage = null;

    #[ORM\Column(nullable: true)]
    private ?array $colorPreferences = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $typographie = null;

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

    public function getSlogan(): ?string
    {
        return $this->slogan;
    }

    public function setSlogan(?string $slogan): static
    {
        $this->slogan = $slogan;

        return $this;
    }

    public function getTonVoice(): ?string
    {
        return $this->tonVoice;
    }

    public function setTonVoice(?string $tonVoice): static
    {
        $this->tonVoice = $tonVoice;

        return $this;
    }

    public function getQualities(): ?array
    {
        return $this->qualities;
    }

    public function setQualities(?array $qualities): static
    {
        $this->qualities = $qualities;

        return $this;
    }

    public function getPublicTarget(): ?string
    {
        return $this->publicTarget;
    }

    public function setPublicTarget(?string $publicTarget): static
    {
        $this->publicTarget = $publicTarget;

        return $this;
    }

    public function getMainService(): ?string
    {
        return $this->mainService;
    }

    public function setMainService(?string $mainService): static
    {
        $this->mainService = $mainService;

        return $this;
    }

    public function getMainLanguage(): ?string
    {
        return $this->mainLanguage;
    }

    public function setMainLanguage(?string $mainLanguage): static
    {
        $this->mainLanguage = $mainLanguage;

        return $this;
    }

    public function getColorPreferences(): ?array
    {
        return $this->colorPreferences;
    }

    public function setColorPreferences(?array $colorPreferences): static
    {
        $this->colorPreferences = $colorPreferences;

        return $this;
    }

    public function getTypographie(): ?string
    {
        return $this->typographie;
    }

    public function setTypographie(?string $typographie): static
    {
        $this->typographie = $typographie;

        return $this;
    }
}
