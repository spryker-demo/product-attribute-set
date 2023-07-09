<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ProductAttributeSet\Persistence;

use Generated\Shared\Transfer\ProductAttributeSetCriteriaTransfer;
use Generated\Shared\Transfer\ProductAttributeSetTransfer;

interface ProductAttributeSetRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAttributeSetCriteriaTransfer $productAttributeSetCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAttributeSetTransfer|null
     */
    public function findProductAttributeSetByCriteria(ProductAttributeSetCriteriaTransfer $productAttributeSetCriteriaTransfer): ?ProductAttributeSetTransfer;

    /**
     * @return array<\Generated\Shared\Transfer\ProductAttributeSetTransfer>
     */
    public function getProductAttributeSets(): array;
}
