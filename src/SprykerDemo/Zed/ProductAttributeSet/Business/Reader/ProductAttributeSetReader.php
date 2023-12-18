<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ProductAttributeSet\Business\Reader;

use Generated\Shared\Transfer\ProductAttributeSetCriteriaTransfer;
use Generated\Shared\Transfer\ProductAttributeSetTransfer;
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
     * @param \SprykerDemo\Zed\ProductAttributeSet\Persistence\ProductAttributeSetRepositoryInterface $repository
     * @param \Spryker\Zed\ProductAttribute\Business\ProductAttributeFacadeInterface $productAttributeFacade
     */
    public function __construct(
        ProductAttributeSetRepositoryInterface $repository,
        ProductAttributeFacadeInterface $productAttributeFacade
    ) {
        $this->repository = $repository;
        $this->productAttributeFacade = $productAttributeFacade;
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
     * @param \Generated\Shared\Transfer\ProductAttributeSetCriteriaTransfer $productAttributeSetCriteriaTransfer
     *
     * @return bool
     */
    public function productAttributeSetExists(ProductAttributeSetCriteriaTransfer $productAttributeSetCriteriaTransfer): bool
    {
        return $this->repository->productAttributeSetExists($productAttributeSetCriteriaTransfer);
    }

    /**
     * @return array<string, int>
     */
    public function getProductAttributeSetIdsIndexedByName(): array
    {
        return $this->repository->getProductAttributeSetIdsIndexedByName();
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
}
