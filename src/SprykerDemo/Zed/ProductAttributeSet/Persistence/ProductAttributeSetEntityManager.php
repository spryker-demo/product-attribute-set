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
        $updatedProductManagementAttributeIds = $productAttributeSetTransfer->getProductManagementAttributeIds();

        if (!$productAttributeSetEntity) {
            $productAttributeSetEntity = new SpyProductAttributeSet();
        }

        $productAttributeSetEntity = $this->getFactory()->createProductAttributeSetMapper()
            ->mapProductAttributeSetTransferToProductAttributeSetEntity(
                $productAttributeSetEntity,
                $productAttributeSetTransfer,
            );

        $productAttributeSetEntity->save();

        $productAttributeSetTransfer = $this->getFactory()->createProductAttributeSetMapper()
            ->mapProductAttributeSetEntityToProductAttributeSetTransfer(
                $productAttributeSetEntity,
                new ProductAttributeSetTransfer(),
            );
        $productAttributeSetTransfer->setProductManagementAttributeIds($this->getProductManagementAttributeIds($productAttributeSetEntity));

        $this->updateProductManagementAttribute(
            $productAttributeSetTransfer,
            $updatedProductManagementAttributeIds,
        );

        return $productAttributeSetTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAttributeSetTransfer $productAttributeSetTransfer
     * @param array<int|null> $updatedProductManagementAttributeIds
     *
     * @return void
     */
    protected function updateProductManagementAttribute(
        ProductAttributeSetTransfer $productAttributeSetTransfer,
        array $updatedProductManagementAttributeIds
    ): void {
        $existingProductManagementAttributeIds = $productAttributeSetTransfer->getProductManagementAttributeIds();

        $storeIdsToAdd = array_diff($updatedProductManagementAttributeIds, $existingProductManagementAttributeIds);
        $storeIdsToRemove = array_diff($existingProductManagementAttributeIds, $updatedProductManagementAttributeIds);

        $this->createAttributeRelations($productAttributeSetTransfer->getIdProductAttributeSet(), $storeIdsToAdd);
        $this->deleteAttributeRelations($productAttributeSetTransfer->getIdProductAttributeSet(), $storeIdsToRemove);
    }

    /**
     * @param int|null $idAttributeSet
     * @param array<int|null> $productManagementAttributeIds
     *
     * @return void
     */
    protected function createAttributeRelations(?int $idAttributeSet, array $productManagementAttributeIds): void
    {
        foreach ($productManagementAttributeIds as $idProductManagementAttribute) {
            (new SpyProductAttributeSetToSpyProductManagementAttribute())
                ->setFkProductAttributeSet($idAttributeSet)
                ->setFkProductManagementAttribute($idProductManagementAttribute)
                ->save();
        }
    }

    /**
     * @param int|null $idAttributeSet
     * @param array<int|null> $productManagementAttributeIds
     *
     * @return void
     */
    public function deleteAttributeRelations(?int $idAttributeSet, array $productManagementAttributeIds): void
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
        if ($productAttributeSetTransfer->getIdProductAttributeSet()) {
            $productAttributeSetEntity = $this->getFactory()->getProductAttributeSetQuery()->findOneByIdProductAttributeSet(
                $productAttributeSetTransfer->getIdProductAttributeSet(),
            );

            if ($productAttributeSetEntity) {
                $productAttributeSetEntity->delete();
            }
        }
    }

    /**
     * @param \Orm\Zed\ProductAttributeSet\Persistence\SpyProductAttributeSet $productAttributeSetEntity
     *
     * @return array<int|null>
     */
    protected function getProductManagementAttributeIds(SpyProductAttributeSet $productAttributeSetEntity): array
    {
        $productManagementAttributeIds = [];
        foreach ($productAttributeSetEntity->getSpyProductAttributeSetToSpyProductManagementAttributes()->getArrayCopy() as $relationEntity) {
            $productManagementAttributeIds[] = $relationEntity->getFkProductManagementAttribute();
        }

        return $productManagementAttributeIds;
    }
}
