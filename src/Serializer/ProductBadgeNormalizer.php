<?php

namespace Integritty\SyliusProductBadgePlugin\Serializer;

use Integritty\SyliusProductBadgePlugin\Entity\ProductInterface;
use Symfony\Component\Serializer\Encoder\NormalizationAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Webmozart\Assert\Assert;

final class ProductBadgeNormalizer implements NormalizerInterface, NormalizationAwareInterface
{
    use NormalizerAwareTrait;
    private const ALREADY_CALLED = 'PRODUCT_BADGE_NORMALIZER_ALREADY_CALLED';

    /** @param array<string, mixed> $context */
    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof ProductInterface && !isset($context[self::ALREADY_CALLED]);
    }

    /**
     * @param ProductInterface $object
     * @param array<string, mixed> $context
     *
     * @return array<string, mixed>
     */
    public function normalize(mixed $object, ?string $format = null, array $context = []): array
    {
        Assert::isInstanceOf($object, ProductInterface::class);
        Assert::keyNotExists($context, self::ALREADY_CALLED);
        $context[self::ALREADY_CALLED] = true;
        $data = $this->normalizer->normalize($object, $format, $context);

        $data['productBadges'] = [];
        foreach ($object->getProductBadges() as $badge) {
            $data['productBadges'][] = [
                'id' => $badge->getId(),
                'cssClass' => $badge->getCssClass()
            ];
        }

        return $data;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [ProductInterface::class => false];
    }
}
