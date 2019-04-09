<?php
namespace LittleElephantClient\Model;

class BusinessCard implements \LittleElephantClient\Model\DocumentInterface
{
    public const TYPE = 'BUSINESS_CARD';

    /**
     * Full name
     *
     * @var string|null
     */
    private $fullName = null;

    /**
     * Telephones
     *
     * @var string[]
     */
    private $telephones = [];

    /**
     * Email
     *
     * @var string|null
     */
    private $email = null;

    /**
     * Website
     *
     * @var string|null
     */
    private $website = null;

    /**
     * Get full name
     *
     * @return string|null
     */
    public function getFullName(): ?string {
        return $this->fullName;
    }

    /**
     * Get telephone
     *
     * @return string[]
     */
    public function getTelephones(): array {
        return $this->telephones;
    }

    /**
     * Get email
     *
     * @return string|null
     */
    public function getEmail(): ?string {
        return $this->email;
    }

    /**
     * Get website
     *
     * @return string|null
     */
    public function getWebsite(): ?string {
        return $this->website;
    }

    /**
     * Set full name
     *
     * @param string $fullName
     * @return \LittleElephantClient\Model\BusinessCard
     */
    public function setFullName(string $fullName): \LittleElephantClient\Model\BusinessCard {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Set telephones
     *
     * @param array $telephones
     * @return \LittleElephantClient\Model\BusinessCard
     */
    public function setTelephones(array $telephones): \LittleElephantClient\Model\BusinessCard {
        $this->telephones = $telephones;

        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return \LittleElephantClient\Model\BusinessCard
     */
    public function setEmail(string $email): \LittleElephantClient\Model\BusinessCard {
        $this->email = $email;

        return $this;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return \LittleElephantClient\Model\BusinessCard
     */
    public function setWebsite(string $website): \LittleElephantClient\Model\BusinessCard {
        $this->website = $website;

        return $this;
    }


    /**
     *
     * @return array
     */
    public function toArray(): array {
        return [
            'fullName'   => $this->fullName,
            'telephones' => $this->telephones,
            'email'      => $this->email,
            'website'    => $this->website
        ];
    }
}