<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ProductAttributeSet\Persistence;

use Generated\Shared\Transfer\ProductAttributeSetTransfer;
use Orm\Zed\ProductAttributeSet\Persistence\SpyProductAttributeSet;
use Orm\Zed\ProductAttributeSet\Persistence\SpyProductAttributeSetToSpyProductManagementAttribute;
use Propel\Runtime\Collection\ObjectCollection;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \SprykerDemo\Zed\ProductAttributeSet\Persistence\ProductAttributeSetPersistenceFactory getFactory()
 */
class ProductAttributeSetEntityManager extends AbstractEntityManager implements ProductAttributeSetEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAttributeSetTransfer $productAttributeSetTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAttributeSetTransfer
     */
    public function saveProductAttributeSet(ProductAttributeSetTransfer $productAttributeSetTransfer): ProductAttributeSetTransfer
    {
        $productAttributeSetEntity = $this->getFactory()
            ->createProductAttributeSetMapper()
            ->mapProductAttributeSetTransferToProductAttributeSetEntity($productAttributeSetTransfer, new SpyProductAttributeSet());

        $productAttributeSetEntity->save();

        $productAttributeSetTransfer->setIdProductAttributeSet($productAttributeSetEntity->getIdProductAttributeSet());

        return $productAttributeSetTransfer;
    }

    /**
     * @param int $idAttributeSet
     * @param array<int> $productManagementAttributeIds
     *
     * @return void
     */
    public function saveAttributeRelations(int $idAttributeSet, array $productManagementAttributeIds): void
    {
        $propelCollection = new ObjectCollection();
        $propelCollection->setModel(SpyProductAttributeSetToSpyProductManagementAttribute::class);

        foreach ($productManagementAttributeIds as $idProductManagementAttribute) {
            $productSetProductManagementAttributeEntity = (new SpyProductAttributeSetToSpyProductManagementAttribute())
                ->setFkProductAttributeSet($idAttributeSet)
                ->setFkProductManagementAttribute($idProductManagementAttribute);

            $propelCollection->append($productSetProductManagementAttributeEntity);
        }

        $propelCollection->save();
    }

    /**
     * @param int $idAttributeSet
     * @param array<int> $productManagementAttributeIds
     *
     * @return void
     */
    public function deleteAttributeRelations(int $idAttributeSet, array $productManagementAttributeIds): void
    {
        if ($productManagementAttributeIds === []) {
            return;
        }

        $this->getFactory()
            ->getSpyProductAttributeSetToSpyProductManagementAttributeQuery()
            ->filterByFkProductAttributeSet($idAttributeSet)
            ->filterByFkProductManagementAttribute_In($productManagementAttributeIds)
            ->delete();
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAttributeSetTransfer $productAttributeSetTransfer
     *
     * @return void
     */
    public function deleteProductAttributeSet(ProductAttributeSetTransfer $productAttributeSetTransfer): void
    {
        if (!$productAttributeSetTransfer->getIdProductAttributeSet()) {
            return;
        }

        $this->getFactory()
            ->getProductAttributeSetQuery()
            ->filterByIdProductAttributeSet($productAttributeSetTransfer->getIdProductAttributeSet())
            ->delete();
    }
}
