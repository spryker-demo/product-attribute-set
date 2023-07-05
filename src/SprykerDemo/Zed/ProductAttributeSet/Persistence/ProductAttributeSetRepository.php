<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ProductAttributeSet\Persistence;

use Generated\Shared\Transfer\ProductAttributeSetTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \SprykerDemo\Zed\ProductAttributeSet\Persistence\ProductAttributeSetPersistenceFactory getFactory()
 */
class ProductAttributeSetRepository extends AbstractRepository implements ProductAttributeSetRepositoryInterface
{
    /**
     * @param int $idProductAttributeSet
     *
     * @return \Generated\Shared\Transfer\ProductAttributeSetTransfer|null
     */
    public function findProductAttributeSetById(int $idProductAttributeSet): ?ProductAttributeSetTransfer
    {
        $productAttributeSetEntity = $this->getFactory()->getProductAttributeSetQuery()
            ->filterByIdProductAttributeSet($idProductAttributeSet)
            ->findOne();

        if (!$productAttributeSetEntity) {
            return null;
        }

        return $this->getFactory()->createProductAttributeSetMapper()
            ->mapProductAttributeSetEntityToProductAttributeSetTransfer($productAttributeSetEntity, new ProductAttributeSetTransfer());
    }

    /**
     * @param string $name
     *
     * @return \Generated\Shared\Transfer\ProductAttributeSetTransfer|null
     */
    public function getProductAttributeSetByName(string $name): ?ProductAttributeSetTransfer
    {
        $productAttributeSetEntity = $this->getFactory()->getProductAttributeSetQuery()
            ->filterByName($name)
            ->findOne();

        if (!$productAttributeSetEntity) {
            return null;
        }

        return $this->getFactory()->createProductAttributeSetMapper()
            ->mapProductAttributeSetEntityToProductAttributeSetTransfer($productAttributeSetEntity, new ProductAttributeSetTransfer());
    }
}
