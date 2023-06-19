<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ProductAttributeSet\Business\Deleter;

use Generated\Shared\Transfer\ProductAttributeSetTransfer;
use SprykerDemo\Zed\ProductAttributeSet\Persistence\ProductAttributeSetEntityManagerInterface;

class ProductAttributeSetDeleter implements ProductAttributeSetDeleterInterface
{
    /**
     * @var \SprykerDemo\Zed\ProductAttributeSet\Persistence\ProductAttributeSetEntityManagerInterface
     */
    protected ProductAttributeSetEntityManagerInterface $entityManager;

    /**
     * @param \SprykerDemo\Zed\ProductAttributeSet\Persistence\ProductAttributeSetEntityManagerInterface $productAttributeSetEntityManager
     */
    public function __construct(ProductAttributeSetEntityManagerInterface $productAttributeSetEntityManager)
    {
        $this->entityManager = $productAttributeSetEntityManager;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAttributeSetTransfer $productAttributeSetTransfer
     *
     * @return void
     */
    public function delete(ProductAttributeSetTransfer $productAttributeSetTransfer): void
    {
        $this->entityManager->deleteProductAttributeSet($productAttributeSetTransfer);
    }
}
