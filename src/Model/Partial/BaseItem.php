<?php
namespace LittleElephantClient\Model\Partial;

abstract class BaseItem
{
    /**
     * Name
     *
     * @var string|null
     */
    private $name = null;

    /**
     * Value
     *
     * @var float
     */
    private $value = null;

    /**
     * Get name
     *
     * @return string
     */
    public final function getName(): string {
        return $this->name;
    }

    /**
     * Get value
     * @return float
     */
    public final function getValue(): float {
        return $this->value;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return \LittleElephantClient\Model\Partial\BaseItem
     */
    public final function setName(string $name): \LittleElephantClient\Model\Partial\BaseItem {
        $this->name = $name;

        return $this;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return \LittleElephantClient\Model\Partial\BaseItem
     */
    public final function setValue(string $value): \LittleElephantClient\Model\Partial\BaseItem {
        $this->value = \floatval($value);

        return $this;
    }
}