<?php

declare(strict_types=1);

namespace Integritty\SyliusProductBadgePlugin\Entity;

use Sylius\Resource\Model\AbstractTranslation;

class ProductBadgeTranslation extends AbstractTranslation implements ProductBadgeTranslationInterface
{
    /** @var mixed */
    protected $id;

    /** @var string|null */
    protected $name;

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }
}
