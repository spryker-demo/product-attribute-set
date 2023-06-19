<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ProductAttributeSet\Business\Saver;

use Generated\Shared\Transfer\ProductAttributeSetTransfer;
use SprykerDemo\Zed\ProductAttributeSet\Persistence\ProductAttributeSetEntityManagerInterface;

class ProductAttributeSetSaver implements ProductAttributeSetSaverInterface
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
     * @return \Generated\Shared\Transfer\ProductAttributeSetTransfer
     */
    public function save(ProductAttributeSetTransfer $productAttributeSetTransfer): ProductAttributeSetTransfer
    {
        return $this->entityManager->saveProductAttributeSet($productAttributeSetTransfer);
    }
}
