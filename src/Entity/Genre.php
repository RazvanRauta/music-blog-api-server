<?php

/**
 * @author Razvan Rauta
 * 21.05.2019
 * 19:31
 */

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
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
 * @ORM\Entity(repositoryClass="App\Repository\GenreRepository")
 */
class Genre
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get","post", "get-song-with-user","songs"})
     * @Assert\NotBlank()
     * @Assert\Length(min=2)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Song", mappedBy="genre")
     */
    private $songs;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getSongs(): Collection
    {
        return $this->songs;
    }


}
