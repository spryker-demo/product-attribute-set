<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ProductAttributeSet\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\ProductAttributeSetTransfer;
use Orm\Zed\ProductAttributeSet\Persistence\SpyProductAttributeSet;

class ProductAttributeSetMapper
{
    /**
     * @param \Orm\Zed\ProductAttributeSet\Persistence\SpyProductAttributeSet $productAttributeSetEntity
     * @param \Generated\Shared\Transfer\ProductAttributeSetTransfer $productAttributeSetTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAttributeSetTransfer
     */
    public function mapProductAttributeSetEntityToProductAttributeSetTransfer(
        SpyProductAttributeSet $productAttributeSetEntity,
        ProductAttributeSetTransfer $productAttributeSetTransfer
    ): ProductAttributeSetTransfer {
        $productAttributeSetTransfer->fromArray($productAttributeSetEntity->toArray(), true);

        return $productAttributeSetTransfer;
    }

    /**
     * @param \Orm\Zed\ProductAttributeSet\Persistence\SpyProductAttributeSet $productAttributeSetEntity
     * @param \Generated\Shared\Transfer\ProductAttributeSetTransfer $productAttributeSetTransfer
     *
     * @return \Orm\Zed\ProductAttributeSet\Persistence\SpyProductAttributeSet
     */
    public function mapProductAttributeSetTransferToProductAttributeSetEntity(
        SpyProductAttributeSet $productAttributeSetEntity,
        ProductAttributeSetTransfer $productAttributeSetTransfer
    ): SpyProductAttributeSet {
        return $productAttributeSetEntity->fromArray($productAttributeSetTransfer->toArray());
    }
}
