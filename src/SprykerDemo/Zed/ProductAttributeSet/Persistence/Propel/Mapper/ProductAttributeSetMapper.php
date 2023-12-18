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

        $productManagementAttributeIds = $this->getProductManagementAttributeIds($productAttributeSetEntity);
        $productAttributeSetTransfer->setProductManagementAttributeIds($productManagementAttributeIds);

        return $productAttributeSetTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAttributeSetTransfer $productAttributeSetTransfer
     * @param \Orm\Zed\ProductAttributeSet\Persistence\SpyProductAttributeSet $productAttributeSetEntity
     *
     * @return \Orm\Zed\ProductAttributeSet\Persistence\SpyProductAttributeSet
     */
    public function mapProductAttributeSetTransferToProductAttributeSetEntity(
        ProductAttributeSetTransfer $productAttributeSetTransfer,
        SpyProductAttributeSet $productAttributeSetEntity
    ): SpyProductAttributeSet {
        $productAttributeSetEntity->fromArray($productAttributeSetTransfer->toArray());
        $productAttributeSetEntity->setNew($productAttributeSetTransfer->getIdProductAttributeSet() === null);

        return $productAttributeSetEntity;
    }

    /**
     * @param \Orm\Zed\ProductAttributeSet\Persistence\SpyProductAttributeSet $productAttributeSetEntity
     *
     * @return array<int|null>
     */
    protected function getProductManagementAttributeIds(SpyProductAttributeSet $productAttributeSetEntity): array
    {
        $productManagementAttributeIds = [];
        foreach ($productAttributeSetEntity->getSpyProductAttributeSetToSpyProductManagementAttributes() as $relationEntity) {
            $productManagementAttributeIds[] = $relationEntity->getFkProductManagementAttribute();
        }

        return $productManagementAttributeIds;
    }
}
