<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ProductAttributeSet\Business;

use Generated\Shared\Transfer\ProductAttributeSetCriteriaTransfer;
use Generated\Shared\Transfer\ProductAttributeSetTransfer;

interface ProductAttributeSetFacadeInterface
{
    /**
     * Specification:
     * - Finds product attribute set by id.
     *
     * @api
     *
     * @param int $idProductAttributeSet
     *
     * @return \Generated\Shared\Transfer\ProductAttributeSetTransfer|null
     */
    public function findProductAttributeSetById(int $idProductAttributeSet): ?ProductAttributeSetTransfer;

    /**
     * Specification:
     * - Checks if product attributes set exists by provided criteria transfer.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductAttributeSetCriteriaTransfer $productAttributeSetCriteriaTransfer
     *
     * @return bool
     */
    public function productAttributeSetExists(ProductAttributeSetCriteriaTransfer $productAttributeSetCriteriaTransfer): bool;

    /**
     * Specification:
     * - Saves product attribute set.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductAttributeSetTransfer $productAttributeSetTransfer
     *
     * @return void
     */
    public function saveProductAttributeSet(ProductAttributeSetTransfer $productAttributeSetTransfer): void;

    /**
     * Specification:
     * - Deletes product attribute set.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductAttributeSetTransfer $productAttributeSetTransfer
     *
     * @return void
     */
    public function deleteProductAttributeSet(ProductAttributeSetTransfer $productAttributeSetTransfer): void;

    /**
     * Specification:
     * - Returns product attribute set ids indexed by product attribute set name.
     *
     * @api
     *
     * @return array<string, int>
     */
    public function getProductAttributeSetIdsIndexedByName(): array;
}
