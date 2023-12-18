<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ProductAttributeSet\Business\Writer;

use Generated\Shared\Transfer\ProductAttributeSetTransfer;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;
use SprykerDemo\Zed\ProductAttributeSet\Persistence\ProductAttributeSetEntityManagerInterface;
use SprykerDemo\Zed\ProductAttributeSet\Persistence\ProductAttributeSetRepositoryInterface;

class ProductAttributeSetWriter implements ProductAttributeSetWriterInterface
{
    use TransactionTrait;

    /**
     * @var \SprykerDemo\Zed\ProductAttributeSet\Persistence\ProductAttributeSetEntityManagerInterface
     */
    protected ProductAttributeSetEntityManagerInterface $entityManager;

    /**
     * @var \SprykerDemo\Zed\ProductAttributeSet\Persistence\ProductAttributeSetRepositoryInterface
     */
    protected ProductAttributeSetRepositoryInterface $repository;

    /**
     * @param \SprykerDemo\Zed\ProductAttributeSet\Persistence\ProductAttributeSetEntityManagerInterface $entityManager
     * @param \SprykerDemo\Zed\ProductAttributeSet\Persistence\ProductAttributeSetRepositoryInterface $repository
     */
    public function __construct(ProductAttributeSetEntityManagerInterface $entityManager, ProductAttributeSetRepositoryInterface $repository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAttributeSetTransfer $productAttributeSetTransfer
     *
     * @return void
     */
    public function saveProductAttributeSet(ProductAttributeSetTransfer $productAttributeSetTransfer): void
    {
        $this->getTransactionHandler()->handleTransaction(function () use ($productAttributeSetTransfer): void {
            $this->executeSaveProductAttributeSet($productAttributeSetTransfer);
        });
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAttributeSetTransfer $productAttributeSetTransfer
     *
     * @return void
     */
    protected function executeSaveProductAttributeSet(ProductAttributeSetTransfer $productAttributeSetTransfer): void
    {
        $isNew = $productAttributeSetTransfer->getIdProductAttributeSet() === null;

        $productAttributeSetTransfer = $this->entityManager->saveProductAttributeSet($productAttributeSetTransfer);
        $updatedProductManagementAttributeIds = $productAttributeSetTransfer->getProductManagementAttributeIds();

        if ($productAttributeSetTransfer->getIdProductAttributeSet() === null) {
            return;
        }

        if ($isNew) {
            $this->entityManager->saveAttributeRelations($productAttributeSetTransfer->getIdProductAttributeSet(), $updatedProductManagementAttributeIds);

            return;
        }

        $existingProductManagementAttributeIds = $this->repository->getExistingProductManagementAttributeIds($productAttributeSetTransfer->getIdProductAttributeSet());
        $productManagementAttributeIdsToAdd = array_diff($updatedProductManagementAttributeIds, $existingProductManagementAttributeIds);
        $productManagementAttributeIdsToRemove = array_diff($existingProductManagementAttributeIds, $updatedProductManagementAttributeIds);

        $this->entityManager->saveAttributeRelations($productAttributeSetTransfer->getIdProductAttributeSet(), $productManagementAttributeIdsToAdd);
        $this->entityManager->deleteAttributeRelations($productAttributeSetTransfer->getIdProductAttributeSet(), $productManagementAttributeIdsToRemove);
    }
}
