<?php

/**
 * @author Razvan Rauta
 * 21.05.2019
 * 19:40
 */

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     attributes={"order"={"published": "DESC"}, "maximum_items_per_page"=30},
 *     itemOperations={
 *         "get"={
 *             "normalization_context"={
 *                 "groups"={"get-song-with-user"}
 *             }
 *          },
 *         "put"={
 *             "access_control"="is_granted('ROLE_ADMIN') or (is_granted('ROLE_SUPERADMIN') and object.getUser() == user)"
 *         }
 *     },
 *     collectionOperations={
 *         "get",
 *         "post"={
 *             "access_control"="is_granted('ROLE_ADMIN')"
 *         }
 *     },
 *     denormalizationContext={
 *         "groups"={"post"}
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\SongRepository")
 */
class Song implements UserEntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get-song-with-user"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=2)
     * @Groups({"post", "get-song-with-user"})
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post", "get-song-with-user"})
     * @Assert\NotBlank()
     * @Assert\Length(min=2)
     */
    private $artist;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"post", "get-song-with-user"})
     * @Assert\NotBlank()
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"post", "get-song-with-user"})
     */
    private $duration;

    /**
     * @ORM\Column(type="date")
     * @Groups({"post", "get-song-with-user"})
     */
    private $published;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="songs")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"get-song-with-user"})
     */
    private $user;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Genre", inversedBy="songs")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"post", "get-song-with-user"})
     */
    private $genre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getArtist(): ?string
    {
        return $this->artist;
    }

    public function setArtist(string $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration($duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getPublished(): ?\DateTimeInterface
    {
        return $this->published;
    }

    public function setPublished(\DateTimeInterface $published): self
    {
        $this->published = $published;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): UserEntityInterface
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Genre
     */
    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    /**
     * @param Genre $genre
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }


}
