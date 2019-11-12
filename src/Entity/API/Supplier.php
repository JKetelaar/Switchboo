<?php
/**
 * @author JKetelaar
 */

namespace App\Entity\API;

class Supplier implements \JsonSerializable
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $logo;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Plan[]
     */
    private $plans;

    /**
     * Supplier constructor.
     * @param int $id
     * @param string $logo
     * @param string $name
     */
    public function __construct(int $id, string $logo, string $name)
    {
        $this->id = $id;
        $this->logo = $logo;
        $this->name = $name;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return ['id' => $this->getId(), 'logo' => $this->getLogo(), 'name' => $this->getName()];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLogo(): string
    {
        return $this->logo;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Plan[]
     */
    public function getPlans(): array
    {
        return $this->plans;
    }

    /**
     * @param Plan[] $plans
     */
    public function setPlans(array $plans): void
    {
        $this->plans = $plans;
    }
}
