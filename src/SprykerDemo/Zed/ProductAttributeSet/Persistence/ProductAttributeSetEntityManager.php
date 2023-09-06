<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ProductAttributeSet\Persistence;

use Generated\Shared\Transfer\ProductAttributeSetTransfer;
use Orm\Zed\ProductAttributeSet\Persistence\SpyProductAttributeSet;
use Orm\Zed\ProductAttributeSet\Persistence\SpyProductAttributeSetToSpyProductManagementAttribute;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;

/**
 * @method \SprykerDemo\Zed\ProductAttributeSet\Persistence\ProductAttributeSetPersistenceFactory getFactory()
 */
class ProductAttributeSetEntityManager extends AbstractEntityManager implements ProductAttributeSetEntityManagerInterface
{
    use TransactionTrait;

    /**
     * @param \Generated\Shared\Transfer\ProductAttributeSetTransfer $productAttributeSetTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAttributeSetTransfer
     */
    public function saveProductAttributeSet(ProductAttributeSetTransfer $productAttributeSetTransfer): ProductAttributeSetTransfer
    {
        return $this->getTransactionHandler()->handleTransaction(function () use ($productAttributeSetTransfer): ProductAttributeSetTransfer {
            return $this->executeSaveProductAttributeSet($productAttributeSetTransfer);
        });
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAttributeSetTransfer $productAttributeSetTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAttributeSetTransfer
     */
    protected function executeSaveProductAttributeSet(ProductAttributeSetTransfer $productAttributeSetTransfer): ProductAttributeSetTransfer
    {
        $productAttributeSetEntity = null;
        if ($productAttributeSetTransfer->getIdProductAttributeSet()) {
            $productAttributeSetEntity = $this->getFactory()->getProductAttributeSetQuery()->findOneByIdProductAttributeSet(
                $productAttributeSetTransfer->getIdProductAttributeSet(),
            );
        }

        if (!$productAttributeSetEntity) {
            $productAttributeSetEntity = new SpyProductAttributeSet();
        }

        $productAttributeSetEntity->fromArray($productAttributeSetTransfer->toArray());
        $productAttributeSetEntity->save();

        $existingProductManagementAttributeIds = array_map(static function (SpyProductAttributeSetToSpyProductManagementAttribute $relationEntity) {
            return $relationEntity->getFkProductManagementAttribute();
        }, $productAttributeSetEntity->getSpyProductAttributeSetToSpyProductManagementAttributes()->getArrayCopy());
        $updatedProductManagementAttributeIds = $productAttributeSetTransfer->getProductManagementAttributeIds();

        $storeIdsToAdd = array_diff($updatedProductManagementAttributeIds, $existingProductManagementAttributeIds);
        $storeIdsToRemove = array_diff($existingProductManagementAttributeIds, $updatedProductManagementAttributeIds);

        $this->createAttributeRelations($productAttributeSetEntity->getIdProductAttributeSet(), $storeIdsToAdd);
        $this->deleteAttributeRelations($productAttributeSetEntity->getIdProductAttributeSet(), $storeIdsToRemove);

        return (new ProductAttributeSetTransfer())->fromArray($productAttributeSetEntity->toArray(), true);
    }

    /**
     * @param int $idAttributeSet
     * @param array<int|null> $productManagementAttributeIds
     *
     * @return void
     */
    protected function createAttributeRelations(int $idAttributeSet, array $productManagementAttributeIds): void
    {
        foreach ($productManagementAttributeIds as $idProductManagementAttribute) {
            (new SpyProductAttributeSetToSpyProductManagementAttribute())
                ->setFkProductAttributeSet($idAttributeSet)
                ->setFkProductManagementAttribute($idProductManagementAttribute)
                ->save();
        }
    }

    /**
     * @param int $idAttributeSet
     * @param array<int|null> $productManagementAttributeIds
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
            ->find()
            ->delete();
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAttributeSetTransfer $productAttributeSetTransfer
     *
     * @return void
     */
    public function deleteProductAttributeSet(ProductAttributeSetTransfer $productAttributeSetTransfer): void
    {
        if ($productAttributeSetTransfer->getIdProductAttributeSet()) {
            $productAttributeSetEntity = $this->getFactory()->getProductAttributeSetQuery()->findOneByIdProductAttributeSet(
                $productAttributeSetTransfer->getIdProductAttributeSet(),
            );

            if ($productAttributeSetEntity) {
                $productAttributeSetEntity->delete();
            }
        }
    }
}
