<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ProductAttributeSet\Business;

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
     * - Finds product attribute set by name.
     *
     * @api
     *
     * @param string $name
     *
     * @return \Generated\Shared\Transfer\ProductAttributeSetTransfer|null
     */
    public function findProductAttributeSetByName(string $name): ?ProductAttributeSetTransfer;

    /**
     * Specification:
     * - Saves product attribute set.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductAttributeSetTransfer $productAttributeSetTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAttributeSetTransfer
     */
    public function saveProductAttributeSet(ProductAttributeSetTransfer $productAttributeSetTransfer): ProductAttributeSetTransfer;

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
     * - Returns all product attribute sets.
     *
     * @api
     *
     * @return array<\Generated\Shared\Transfer\ProductAttributeSetTransfer>
     */
    public function getProductAttributeSets(): array;

    /**
     * Specification:
     * - Gets product management attribute names of a specific product attribute set.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductAttributeSetTransfer $productAttributeSetTransfer
     *
     * @return array<string|null>
     */
    public function getProductManagementAttributeNames(ProductAttributeSetTransfer $productAttributeSetTransfer): array;
}
