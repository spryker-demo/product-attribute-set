<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ProductAttributeSet\Business\Reader;

use Generated\Shared\Transfer\ProductAttributeSetCriteriaTransfer;
use Generated\Shared\Transfer\ProductAttributeSetTransfer;
use Spryker\Zed\Locale\Business\LocaleFacadeInterface;
use Spryker\Zed\ProductAttribute\Business\ProductAttributeFacadeInterface;
use SprykerDemo\Zed\ProductAttributeSet\Persistence\ProductAttributeSetRepositoryInterface;

class ProductAttributeSetReader implements ProductAttributeSetReaderInterface
{
    /**
     * @var \SprykerDemo\Zed\ProductAttributeSet\Persistence\ProductAttributeSetRepositoryInterface
     */
    protected ProductAttributeSetRepositoryInterface $repository;

    /**
     * @var \Spryker\Zed\ProductAttribute\Business\ProductAttributeFacadeInterface
     */
    protected ProductAttributeFacadeInterface $productAttributeFacade;

    /**
     * @var \Spryker\Zed\Locale\Business\LocaleFacadeInterface
     */
    protected LocaleFacadeInterface $localeFacade;

    /**
     * @param \SprykerDemo\Zed\ProductAttributeSet\Persistence\ProductAttributeSetRepositoryInterface $repository
     * @param \Spryker\Zed\ProductAttribute\Business\ProductAttributeFacadeInterface $productAttributeFacade
     * @param \Spryker\Zed\Locale\Business\LocaleFacadeInterface $localeFacade
     */
    public function __construct(
        ProductAttributeSetRepositoryInterface $repository,
        ProductAttributeFacadeInterface $productAttributeFacade,
        LocaleFacadeInterface $localeFacade
    ) {
        $this->repository = $repository;
        $this->productAttributeFacade = $productAttributeFacade;
        $this->localeFacade = $localeFacade;
    }

    /**
     * @param int $idProductAttributeSet
     *
     * @return \Generated\Shared\Transfer\ProductAttributeSetTransfer|null
     */
    public function findProductAttributeSetById(int $idProductAttributeSet): ?ProductAttributeSetTransfer
    {
        $productAttributeSetCriteriaTransfer = new ProductAttributeSetCriteriaTransfer();
        $productAttributeSetCriteriaTransfer->setIdProductAttributeSet($idProductAttributeSet);

        $productAttributeSetTransfer = $this->repository->findProductAttributeSetByCriteria($productAttributeSetCriteriaTransfer);

        if ($productAttributeSetTransfer === null) {
            return null;
        }

        $productManagementAttributeCollectionTransfer = $this->productAttributeFacade->getProductAttributeCollection();
        $this->addProductManagementAttributesToProductAttributeSet($productAttributeSetTransfer, $productManagementAttributeCollectionTransfer);

        return $productAttributeSetTransfer;
    }

    /**
     * @param string $name
     *
     * @return \Generated\Shared\Transfer\ProductAttributeSetTransfer|null
     */
    public function findProductAttributeSetByName(string $name): ?ProductAttributeSetTransfer
    {
        $productAttributeSetCriteriaTransfer = new ProductAttributeSetCriteriaTransfer();
        $productAttributeSetCriteriaTransfer->setName($name);

        return $this->repository->findProductAttributeSetByCriteria($productAttributeSetCriteriaTransfer);
    }

    /**
     * @return array<\Generated\Shared\Transfer\ProductAttributeSetTransfer>
     */
    public function getProductAttributeSets(): array
    {
        $productAttributeSets = $this->repository->getProductAttributeSets();
        $productManagementAttributeCollectionTransfer = $this->productAttributeFacade->getProductAttributeCollection();

        foreach ($productAttributeSets as $productAttributeSetTransfer) {
            $this->addProductManagementAttributesToProductAttributeSet($productAttributeSetTransfer, $productManagementAttributeCollectionTransfer);
        }

        return $productAttributeSets;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAttributeSetTransfer $productAttributeSetTransfer
     * @param array<\Generated\Shared\Transfer\ProductManagementAttributeTransfer> $productManagementAttributeCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAttributeSetTransfer
     */
    protected function addProductManagementAttributesToProductAttributeSet(
        ProductAttributeSetTransfer $productAttributeSetTransfer,
        array $productManagementAttributeCollectionTransfer
    ): ProductAttributeSetTransfer {
        foreach ($productManagementAttributeCollectionTransfer as $productManagementAttributeTransfer) {
            if (
                in_array(
                    $productManagementAttributeTransfer->getIdProductManagementAttribute(),
                    $productAttributeSetTransfer->getProductManagementAttributeIds(),
                    true,
                )
            ) {
                $productAttributeSetTransfer->addProductManagementAttribute($productManagementAttributeTransfer);
            }
        }

        return $productAttributeSetTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAttributeSetTransfer $productAttributeSetTransfer
     *
     * @return array<string|null>
     */
    public function getProductManagementAttributeNames(ProductAttributeSetTransfer $productAttributeSetTransfer): array
    {
        $currentLocale = $this->localeFacade->getCurrentLocale();
        $productManagementAttributeNames = [];
        foreach ($productAttributeSetTransfer->getProductManagementAttributes() as $productManagementAttributeTransfer) {
            foreach ($productManagementAttributeTransfer->getLocalizedKeys() as $localizedKey) {
                if ($currentLocale->getLocaleName() === $localizedKey->getLocaleName()) {
                    $productManagementAttributeNames[] = $localizedKey->getKeyTranslation();
                }
            }
        }

        return $productManagementAttributeNames;
    }
}
