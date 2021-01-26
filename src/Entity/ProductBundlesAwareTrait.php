<?php

declare(strict_types=1);

namespace BitBag\SyliusProductBundlePlugin\Entity;

trait ProductBundlesAwareTrait
{
    /**
     * @var ProductBundleInterface
     * @ORM\OneToOne(
     *     targetEntity="BitBag\SyliusProductBundlePlugin\Entity\ProductBundleInterface",
     *     mappedBy="product",
     *     cascade={"all"}
     * )
    **/
    protected $productBundle;

    public function getProductBundle(): ?ProductBundleInterface
    {
        return $this->productBundle;
    }

    public function setProductBundle(?ProductBundleInterface $productBundle): void
    {
        $this->productBundle = $productBundle;
    }

    public function isBundle(): bool
    {
        return null !== $this->getProductBundle();
    }
}
