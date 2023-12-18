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
     * @param \Generated\Shared\Transfer\ProductAttributeSetCriteriaTransfer $productAttributeSetCriteriaTransfer
     *
     * @return bool
     */
    public function productAttributeSetExists(ProductAttributeSetCriteriaTransfer $productAttributeSetCriteriaTransfer): bool;

    /**
     * @return array<string, int>
     */
    public function getProductAttributeSetIdsIndexedByName(): array;

    /**
     * @param int $idProductAttributeSet
     *
     * @return array<int>
     */
    public function getExistingProductManagementAttributeIds(int $idProductAttributeSet): array;
}
