<?php

namespace App\Entity\Branding;

use App\Repository\Branding\BackgroundJobTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BackgroundJobTypeRepository::class)]
class BackgroundJobType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $name = null;

    /**
     * @var Collection<int, BackgroundJob>
     */
    #[ORM\OneToMany(targetEntity: BackgroundJob::class, mappedBy: 'jobType')]
    private Collection $backgroundJobs;

    public function __construct()
    {
        $this->backgroundJobs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, BackgroundJob>
     */
    public function getBackgroundJobs(): Collection
    {
        return $this->backgroundJobs;
    }

    public function addBackgroundJob(BackgroundJob $backgroundJob): static
    {
        if (!$this->backgroundJobs->contains($backgroundJob)) {
            $this->backgroundJobs->add($backgroundJob);
            $backgroundJob->setJobType($this);
        }

        return $this;
    }

    public function removeBackgroundJob(BackgroundJob $backgroundJob): static
    {
        if ($this->backgroundJobs->removeElement($backgroundJob)) {
            // set the owning side to null (unless already changed)
            if ($backgroundJob->getJobType() === $this) {
                $backgroundJob->setJobType(null);
            }
        }

        return $this;
    }
}
