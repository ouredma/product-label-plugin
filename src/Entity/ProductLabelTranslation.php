<?php

declare(strict_types=1);

namespace Integritty\SyliusProductLabelPlugin\Entity;

use Sylius\Resource\Model\AbstractTranslation;
use Symfony\Component\Serializer\Annotation\Groups;

#[Groups(['sylius:shop:product:show'])]
class ProductLabelTranslation extends AbstractTranslation implements ProductLabelTranslationInterface
{
    /** @var int|null */
    protected $id;

    /** @var string|null */
    protected $name;

    public function getId(): int|null
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
