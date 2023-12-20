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
    protected ProductAttributeSetEntityManagerInterface $productAttributeSetEntityManager;

    /**
     * @var \SprykerDemo\Zed\ProductAttributeSet\Persistence\ProductAttributeSetRepositoryInterface
     */
    protected ProductAttributeSetRepositoryInterface $productAttributeSetRepository;

    /**
     * @param \SprykerDemo\Zed\ProductAttributeSet\Persistence\ProductAttributeSetEntityManagerInterface $productAttributeSetEntityManager
     * @param \SprykerDemo\Zed\ProductAttributeSet\Persistence\ProductAttributeSetRepositoryInterface $productAttributeSetRepository
     */
    public function __construct(
        ProductAttributeSetEntityManagerInterface $productAttributeSetEntityManager,
        ProductAttributeSetRepositoryInterface $productAttributeSetRepository
    ) {
        $this->productAttributeSetEntityManager = $productAttributeSetEntityManager;
        $this->productAttributeSetRepository = $productAttributeSetRepository;
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
        if ($productAttributeSetTransfer->getIdProductAttributeSet() === null) {
            $this->saveNewProductAttributeSet($productAttributeSetTransfer);

            return;
        }

        $this->updateExistingProductAttributeSet($productAttributeSetTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAttributeSetTransfer $productAttributeSetTransfer
     *
     * @return void
     */
    protected function saveNewProductAttributeSet(ProductAttributeSetTransfer $productAttributeSetTransfer): void
    {
        $productAttributeSetTransfer = $this->productAttributeSetEntityManager->saveProductAttributeSet($productAttributeSetTransfer);
        $this->productAttributeSetEntityManager->saveAttributeRelations(
            $productAttributeSetTransfer->getIdProductAttributeSetOrFail(),
            $productAttributeSetTransfer->getProductManagementAttributeIds(),
        );
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAttributeSetTransfer $productAttributeSetTransfer
     *
     * @return void
     */
    protected function updateExistingProductAttributeSet(ProductAttributeSetTransfer $productAttributeSetTransfer): void
    {
        $productAttributeSetTransfer = $this->productAttributeSetEntityManager->saveProductAttributeSet($productAttributeSetTransfer);
        $updatedProductManagementAttributeIds = $productAttributeSetTransfer->getProductManagementAttributeIds();
        $existingProductManagementAttributeIds = $this->productAttributeSetRepository
            ->getExistingProductManagementAttributeIds($productAttributeSetTransfer->getIdProductAttributeSetOrFail());
        $productManagementAttributeIdsToAdd = array_diff($updatedProductManagementAttributeIds, $existingProductManagementAttributeIds);
        $productManagementAttributeIdsToRemove = array_diff($existingProductManagementAttributeIds, $updatedProductManagementAttributeIds);

        $this->productAttributeSetEntityManager->saveAttributeRelations(
            $productAttributeSetTransfer->getIdProductAttributeSetOrFail(),
            $productManagementAttributeIdsToAdd,
        );
        $this->productAttributeSetEntityManager->deleteAttributeRelations(
            $productAttributeSetTransfer->getIdProductAttributeSetOrFail(),
            $productManagementAttributeIdsToRemove,
        );
    }
}
