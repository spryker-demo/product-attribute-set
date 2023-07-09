<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ProductAttributeSet\Business\Reader;

use Generated\Shared\Transfer\ProductAttributeSetCriteriaTransfer;
use Generated\Shared\Transfer\ProductAttributeSetTransfer;
use Generated\Shared\Transfer\ProductManagementAttributeTransfer;
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

        $productAttributeCollection = $this->productAttributeFacade->getProductAttributeCollection();

        $productManagementAttributeTransfers = array_filter(
            $productAttributeCollection,
            function (ProductManagementAttributeTransfer $productManagementAttributeTransfer) use ($productAttributeSetTransfer) {
                return in_array(
                    $productManagementAttributeTransfer->getIdProductManagementAttribute(),
                    $productAttributeSetTransfer->getProductManagementAttributeIds(),
                    true,
                );
            },
        );

        foreach ($productManagementAttributeTransfers as $productManagementAttributeTransfer) {
            $productAttributeSetTransfer->addProductManagementAttribute($productManagementAttributeTransfer);
        }

        return $productAttributeSetTransfer;
    }

    /**
     * @param string $name
     *
     * @return \Generated\Shared\Transfer\ProductAttributeSetTransfer|null
     */
    public function getProductAttributeSetByName(string $name): ?ProductAttributeSetTransfer
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
        $productAttributeCollection = $this->productAttributeFacade->getProductAttributeCollection();
        foreach ($productAttributeSets as $productAttributeSetTransfer) {
            $productManagementAttributeTransfers = array_filter(
                $productAttributeCollection,
                static function (ProductManagementAttributeTransfer $productManagementAttributeTransfer) use ($productAttributeSetTransfer) {
                    return in_array($productManagementAttributeTransfer->getIdProductManagementAttribute(), $productAttributeSetTransfer->getProductManagementAttributeIds(), true);
                },
            );
            foreach ($productManagementAttributeTransfers as $productManagementAttributeTransfer) {
                $productAttributeSetTransfer->addProductManagementAttribute($productManagementAttributeTransfer);
            }
        }

        return $productAttributeSets;
    }
}
