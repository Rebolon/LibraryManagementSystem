<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     iri="https://schema.org/Corporation",
 *     accessControl="is_granted('ROLE_ADMIN')",
 *     attributes={
 *          "access_control"="is_granted('ROLE_ADMIN')",
 *          "status_code"=403,
 *          "pagination_client_enabled"=true,
 *     })
 * @ORM\Entity(repositoryClass="App\Repository\CompanyRepository")
 */
class Company
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ApiProperty(iri="http://schema.org/name")
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ApiProperty(iri="http://schema.org/leiCode")
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Luhn()
     */
    private $siren;

    /**
     * @ApiProperty(iri="http://schema.org/telephone")
     *
     * @ORM\Column(type="string", length=20, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^\+?\d{2,3} ?\d{2,3} ?\d{2,3} ?\d{2,3}$/")
     */
    private $phone;

    /**
     * @ApiProperty(iri="http://schema.org/email")
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ApiProperty(iri="http://schema.org/streetAddress")
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $postalAddress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $postalAddressExtra;

    /**
     * @ApiProperty(iri="http://schema.org/postalCode")
     *
     * @ORM\Column(type="string", length=32, nullable=false)
     * @Assert\NotBlank()
     */
    private $postCode;

    /**
     * @ApiProperty(iri="http://schema.org/addressLocality")
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $city;

    /**
     * @ApiProperty(iri="http://schema.org/addressCountry")
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $country;

    /**
     * @ApiProperty(iri="http://schema.org/Boolean")
     *
     * @ORM\Column(type="boolean", options={"default"=true})
     */
    private $active = true;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Subscription", mappedBy="company")
     */
    private $subscriptions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="company")
     */
    private $users;

    public function __construct()
    {
        $this->subscriptions = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

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

    public function getSiren(): ?string
    {
        return $this->siren;
    }

    public function setSiren(?string $siren): self
    {
        $this->siren = $siren;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPostalAddress(): ?string
    {
        return $this->postalAddress;
    }

    public function setPostalAddress(string $postalAddress): self
    {
        $this->postalAddress = $postalAddress;

        return $this;
    }

    public function getPostalAddressExtra(): ?string
    {
        return $this->postalAddressExtra;
    }

    public function setPostalAddressExtra(?string $postalAddressExtra): self
    {
        $this->postalAddressExtra = $postalAddressExtra;

        return $this;
    }

    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    public function setPostCode(string $postCode): self
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection|Subscription[]
     */
    public function getSubscriptions(): Collection
    {
        return $this->subscriptions;
    }

    public function addSubscription(Subscription $subscription): self
    {
        if (!$this->subscriptions->contains($subscription)) {
            $this->subscriptions[] = $subscription;
            $subscription->setCompany($this);
        }

        return $this;
    }

    public function removeSubscription(Subscription $subscription): self
    {
        if ($this->subscriptions->contains($subscription)) {
            $this->subscriptions->removeElement($subscription);
            // set the owning side to null (unless already changed)
            if ($subscription->getCompany() === $this) {
                $subscription->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setCompany($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getCompany() === $this) {
                $user->setCompany(null);
            }
        }

        return $this;
    }
}
