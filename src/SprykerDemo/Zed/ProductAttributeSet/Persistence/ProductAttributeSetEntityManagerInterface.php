<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ProductAttributeSet\Persistence;

use Generated\Shared\Transfer\ProductAttributeSetTransfer;

interface ProductAttributeSetEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAttributeSetTransfer $productAttributeSetTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAttributeSetTransfer
     */
    public function saveProductAttributeSet(ProductAttributeSetTransfer $productAttributeSetTransfer): ProductAttributeSetTransfer;

    /**
     * @param \Generated\Shared\Transfer\ProductAttributeSetTransfer $productAttributeSetTransfer
     *
     * @return void
     */
    public function deleteProductAttributeSet(ProductAttributeSetTransfer $productAttributeSetTransfer): void;

    /**
     * @param int $idAttributeSet
     * @param array<int> $productManagementAttributeIds
     *
     * @return void
     */
    public function saveAttributeRelations(int $idAttributeSet, array $productManagementAttributeIds): void;

    /**
     * @param int $idAttributeSet
     * @param array<int> $productManagementAttributeIds
     *
     * @return void
     */
    public function deleteAttributeRelations(int $idAttributeSet, array $productManagementAttributeIds): void;
}
