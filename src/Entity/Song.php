<?php

namespace App\Entity;

use App\Repository\SongRepository;
use App\Traits\StatisticsPropertiesTraits;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: SongRepository::class)]
class Song
{

    use StatisticsPropertiesTraits;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groupe(groups:['song'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groupe(groups:['song'])]
    private ?string $name = null;

    #[ORM\Column(length: 55)]
    #[Groupe(groups:['song'])]
    private ?string $artiste = null;

    /**
     * @var Collection<int, pool>k
     */
    #[Groups(groups:['pool'])]
    #[ORM\ManyToMany(targetEntity: Pool::class, inversedBy: 'songs')]
    private Collection $pools;

    public function __construct()
    {
        $this->pool = new ArrayCollection();
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

    public function getArtiste(): ?string
    {
        return $this->artiste;
    }

    public function setArtiste(string $artiste): static
    {
        $this->artiste = $artiste;

        return $this;
    }

    /**
     * @return Collection<int, pool>
     */
    public function getPool(): Collection
    {
        return $this->pool;
    }

    public function addPool(pool $pool): static
    {
        if (!$this->pool->contains($pool)) {
            $this->pool->add($pool);
        }

        return $this;
    }

    public function removePool(pool $pool): static
    {
        $this->pool->removeElement($pool);

        return $this;
    }  
}