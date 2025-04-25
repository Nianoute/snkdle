<?php

namespace App\Entity;

use App\Repository\SongRepository;
use App\Traits\StatisticsPropertiesTraits;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PoolRepository::class)]
class Pool
{
    // use StatisticsPropertiesTraits;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['pool'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['pool'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['pool'])]
    private ?string $shortname = null;

    /**
     * @var Collection<int, Song>
     */
    #[Groupe(['song'])]
    #[ORM\ManyToMany(targetEntity: Song::class, mappedBy: 'pools')]
    private Collection $songs;

    public function __construct()
    {
        $this->songs = new ArrayCollection();
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

    public function getShortname(): ?string
    {
        return $this->shortname;
    }

    public function setShortname(string $shortname): static
    {
        $this->shortname = $shortname;

        return $this;
    }

    /**
     * @return Collection<int, Song>
     */
    public function getSongs(): Collection
    {
        return $this->songs;
    }

    public function addSong(Song $song): static
    {
        if (!$this->songs->contains($song)) {
            $this->songs->add($song);
            $song->addPool($this);
        }

        return $this;
    }

    public function removeSong(Song $song): static
    {
        if ($this->songs->removeElement($song)) {
            $song->removePool($this);
        }

        return $this;
    }
}
