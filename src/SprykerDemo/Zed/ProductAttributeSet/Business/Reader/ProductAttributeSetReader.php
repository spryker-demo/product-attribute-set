<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ProductAttributeSet\Business\Reader;

use Generated\Shared\Transfer\ProductAttributeSetCriteriaTransfer;
use Generated\Shared\Transfer\ProductAttributeSetTransfer;
use Generated\Shared\Transfer\ProductManagementAttributeCriteriaTransfer;
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
     * @param \SprykerDemo\Zed\ProductAttributeSet\Persistence\ProductAttributeSetRepositoryInterface $productAttributeSetRepository
     * @param \Spryker\Zed\ProductAttribute\Business\ProductAttributeFacadeInterface $productAttributeFacade
     */
    public function __construct(
        ProductAttributeSetRepositoryInterface $productAttributeSetRepository,
        ProductAttributeFacadeInterface $productAttributeFacade
    ) {
        $this->repository = $productAttributeSetRepository;
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

        $this->addProductManagementAttributesToProductAttributeSet($productAttributeSetTransfer);

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
     *
     * @return \Generated\Shared\Transfer\ProductAttributeSetTransfer
     */
    protected function addProductManagementAttributesToProductAttributeSet(
        ProductAttributeSetTransfer $productAttributeSetTransfer
    ): ProductAttributeSetTransfer {
        $productManagementAttributeCollectionTransfer = $this->productAttributeFacade->getProductManagementAttributeCollection(
            new ProductManagementAttributeCriteriaTransfer(),
        );

        foreach ($productManagementAttributeCollectionTransfer->getProductManagementAttributes() as $productManagementAttributeTransfer) {
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
