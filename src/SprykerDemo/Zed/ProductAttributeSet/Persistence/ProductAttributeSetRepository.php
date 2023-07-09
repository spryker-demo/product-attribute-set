<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ProductAttributeSet\Persistence;

use Generated\Shared\Transfer\ProductAttributeSetCriteriaTransfer;
use Generated\Shared\Transfer\ProductAttributeSetTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \SprykerDemo\Zed\ProductAttributeSet\Persistence\ProductAttributeSetPersistenceFactory getFactory()
 */
class ProductAttributeSetRepository extends AbstractRepository implements ProductAttributeSetRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAttributeSetCriteriaTransfer $productAttributeSetCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAttributeSetTransfer|null
     */
    public function findProductAttributeSetByCriteria(ProductAttributeSetCriteriaTransfer $productAttributeSetCriteriaTransfer): ?ProductAttributeSetTransfer
    {
        $productAttributeSetQuery = $this->getFactory()->getProductAttributeSetQuery();
        if($productAttributeSetCriteriaTransfer->getIdProductAttributeSet()) {
            $productAttributeSetQuery->filterByIdProductAttributeSet(
                $productAttributeSetCriteriaTransfer->getIdProductAttributeSet()
            );
        }
        if($productAttributeSetCriteriaTransfer->getName()) {
            $productAttributeSetQuery->filterByName(
                $productAttributeSetCriteriaTransfer->getName()
            );
        }
        $productAttributeSetEntity = $productAttributeSetQuery->findOne();

        if (!$productAttributeSetEntity) {
            return null;
        }

        return $this->getFactory()->createProductAttributeSetMapper()
            ->mapProductAttributeSetEntityToProductAttributeSetTransfer($productAttributeSetEntity, new ProductAttributeSetTransfer());

    }

    /**
     * @return array<\Generated\Shared\Transfer\ProductAttributeSetTransfer>
     */
    public function getProductAttributeSets(): array
    {
        $productAttributeSetsEntities = $this->getFactory()->getProductAttributeSetQuery()->find();

        $productAttributeSetsTransfers = [];
        foreach ($productAttributeSetsEntities as $productAttributeSetEntity) {
            $productAttributeSetsTransfers[] = $this->getFactory()->createProductAttributeSetMapper()
                ->mapProductAttributeSetEntityToProductAttributeSetTransfer($productAttributeSetEntity, new ProductAttributeSetTransfer());
        }

        return $productAttributeSetsTransfers;
    }
}
