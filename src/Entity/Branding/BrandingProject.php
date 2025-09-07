<?php

namespace App\Entity\Branding;

use App\Entity\Auth\Client;
use App\Enum\BrandingStatus;
use App\Repository\Branding\BrandingProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BrandingProjectRepository::class)]
class BrandingProject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: BrandingStatus::class)]
    private ?BrandingStatus $status = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $deadLine = null;

    #[ORM\ManyToOne(inversedBy: 'brandingProjects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    /**
     * @var Collection<int, DesignBrief>
     */
    #[ORM\OneToMany(targetEntity: DesignBrief::class, mappedBy: 'branding', orphanRemoval: true)]
    private Collection $designBriefs;

    /**
     * @var Collection<int, BrandAiPromptHistory>
     */
    #[ORM\OneToMany(targetEntity: BrandAiPromptHistory::class, mappedBy: 'branding')]
    private Collection $brandAiPromptHistories;

    /**
     * @var Collection<int, LogoVersion>
     */
    #[ORM\OneToMany(targetEntity: LogoVersion::class, mappedBy: 'branding', cascade: ['persist'])]
    private Collection $logos;

    public function __construct()
    {
        $this->designBriefs = new ArrayCollection();
        $this->brandAiPromptHistories = new ArrayCollection();
        $this->logos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?BrandingStatus
    {
        return $this->status;
    }

    public function setStatus(BrandingStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeadLine(): ?\DateTimeImmutable
    {
        return $this->deadLine;
    }

    public function setDeadLine(\DateTimeImmutable $deadLine): static
    {
        $this->deadLine = $deadLine;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, DesignBrief>
     */
    public function getDesignBriefs(): Collection
    {
        return $this->designBriefs;
    }

    public function addDesignBrief(DesignBrief $designBrief): static
    {
        if (!$this->designBriefs->contains($designBrief)) {
            $this->designBriefs->add($designBrief);
            $designBrief->setBranding($this);
        }

        return $this;
    }

    public function removeDesignBrief(DesignBrief $designBrief): static
    {
        if ($this->designBriefs->removeElement($designBrief)) {
            // set the owning side to null (unless already changed)
            if ($designBrief->getBranding() === $this) {
                $designBrief->setBranding(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BrandAiPromptHistory>
     */
    public function getBrandAiPromptHistories(): Collection
    {
        return $this->brandAiPromptHistories;
    }

    public function addBrandAiPromptHistory(BrandAiPromptHistory $brandAiPromptHistory): static
    {
        if (!$this->brandAiPromptHistories->contains($brandAiPromptHistory)) {
            $this->brandAiPromptHistories->add($brandAiPromptHistory);
            $brandAiPromptHistory->setBranding($this);
        }

        return $this;
    }

    public function removeBrandAiPromptHistory(BrandAiPromptHistory $brandAiPromptHistory): static
    {
        if ($this->brandAiPromptHistories->removeElement($brandAiPromptHistory)) {
            // set the owning side to null (unless already changed)
            if ($brandAiPromptHistory->getBranding() === $this) {
                $brandAiPromptHistory->setBranding(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LogoVersion>
     */
    public function getLogos(): Collection
    {
        return $this->logos;
    }

    public function addLogo(LogoVersion $logo): static
    {
        if (!$this->logos->contains($logo)) {
            $this->logos->add($logo);
            $logo->setBranding($this);
        }

        return $this;
    }

    public function removeLogo(LogoVersion $logo): static
    {
        if ($this->logos->removeElement($logo)) {
            // set the owning side to null (unless already changed)
            if ($logo->getBranding() === $this) {
                $logo->setBranding(null);
            }
        }

        return $this;
    }
}
