<?php

namespace App\Entity\Branding;

use App\Repository\Branding\LogoVersionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogoVersionRepository::class)]
class LogoVersion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $assetUrl = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $approvedAt = null;

    #[ORM\Column(options: ['default' => 0])]
    private int $iterationNumber = 0;

    /**
     * @var Collection<int, ClientFeedBack>
     */
    #[ORM\OneToMany(targetEntity: ClientFeedBack::class, mappedBy: 'logoVersion', orphanRemoval: true)]
    private Collection $clientFeedBacks;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'logos')]
    #[ORM\JoinColumn(nullable: true)]
    private ?BrandingProject $branding = null;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'logos')]
    #[ORM\JoinColumn(nullable: true)]
    private ?DesignBrief $brief = null;

    public function __construct()
    {
        $this->clientFeedBacks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAssetUrl(): ?string
    {
        return $this->assetUrl;
    }

    public function setAssetUrl(string $assetUrl): static
    {
        $this->assetUrl = $assetUrl;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getApprovedAt(): ?\DateTimeImmutable
    {
        return $this->approvedAt;
    }

    public function setApprovedAt(?\DateTimeImmutable $approvedAt): static
    {
        $this->approvedAt = $approvedAt;

        return $this;
    }

    public function getIterationNumber(): ?int
    {
        return $this->iterationNumber;
    }

    public function setIterationNumber(int $iterationNumber): static
    {
        $this->iterationNumber = $iterationNumber;

        return $this;
    }

    /**
     * @return Collection<int, ClientFeedBack>
     */
    public function getClientFeedBacks(): Collection
    {
        return $this->clientFeedBacks;
    }

    public function addClientFeedBack(ClientFeedBack $clientFeedBack): static
    {
        if (!$this->clientFeedBacks->contains($clientFeedBack)) {
            $this->clientFeedBacks->add($clientFeedBack);
            $clientFeedBack->setLogoVersion($this);
        }

        return $this;
    }

    public function removeClientFeedBack(ClientFeedBack $clientFeedBack): static
    {
        if ($this->clientFeedBacks->removeElement($clientFeedBack)) {
            // set the owning side to null (unless already changed)
            if ($clientFeedBack->getLogoVersion() === $this) {
                $clientFeedBack->setLogoVersion(null);
            }
        }

        return $this;
    }

    public function getBranding(): ?BrandingProject
    {
        return $this->branding;
    }

    public function setBranding(?BrandingProject $branding): static
    {
        $this->branding = $branding;

        return $this;
    }

    public function getBrief(): ?DesignBrief
    {
        return $this->brief;
    }

    public function setBrief(?DesignBrief $brief): static
    {
        $this->brief = $brief;

        return $this;
    }
}
