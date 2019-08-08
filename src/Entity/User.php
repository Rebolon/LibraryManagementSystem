<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ApiResource(
 *     iri="http://schema.org/Person",
 *     accessControl="is_granted('ROLE_ADMIN')",
 *     attributes={
 *          "access_control"="is_granted('ROLE_ADMIN')",
 *          "status_code"=403,
 *          "pagination_client_enabled"=true,
 *     })
 *
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ApiProperty(iri="http://schema.org/identifier")
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ApiProperty(iri="http://schema.org/email")
     *
     * @ORM\Column(type="string", length=180, unique=true, nullable=false)
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank())
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $apiToken;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $apiTokenTtl;

    /**
    * @ApiProperty(iri="http://schema.org/Corporation")
    *
    * @ORM\ManyToOne(targetEntity="App\Entity\Company", inversedBy="users")
    */
    private $company;

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @ApiProperty(iri="http://schema.org/name")
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    //public function setRoles(array $roles): self
    public function setRoles($roles): self
    {
        // @todo i didn't find a quick solution to react-admin that does't manage ["value"] as array, but as string which cause the Api to fail
        // i prefer to type the signature ith array $roles but for instance i just want it to work in both case: if i send array it's ok, and with
        // react admin it will also works
        if (!is_array($roles)) {
            $roles = explode(',', $roles);
        }

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getApiToken(): ?string
    {
        return (string) $this->apiToken;
    }

    public function setApiToken(string $token): self
    {
        $this->apiToken = $token;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getApiTokenTtl(): ?DateTime
    {
        return $this->apiTokenTtl;
    }

    public function setApiTokenTtl(DateTime $ttl): self
    {
        $this->apiTokenTtl = $ttl;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     * @return User
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
