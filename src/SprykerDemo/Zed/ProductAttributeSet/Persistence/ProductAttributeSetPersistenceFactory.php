<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ProductAttributeSet\Persistence;

use Orm\Zed\ProductAttributeSet\Persistence\SpyProductAttributeSetQuery;
use Orm\Zed\ProductAttributeSet\Persistence\SpyProductAttributeSetToSpyProductManagementAttributeQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;
use SprykerDemo\Zed\ProductAttributeSet\Persistence\Propel\Mapper\ProductAttributeSetMapper;

class ProductAttributeSetPersistenceFactory extends AbstractPersistenceFactory
{
 /**
  * @return \SprykerDemo\Zed\ProductAttributeSet\Persistence\Propel\Mapper\ProductAttributeSetMapper
  */
    public function createProductAttributeSetMapper(): ProductAttributeSetMapper
    {
        return new ProductAttributeSetMapper();
    }

    /**
     * @return \Orm\Zed\ProductAttributeSet\Persistence\SpyProductAttributeSetToSpyProductManagementAttributeQuery
     */
    public function getSpyProductAttributeSetToSpyProductManagementAttributeQuery(): SpyProductAttributeSetToSpyProductManagementAttributeQuery
    {
        return SpyProductAttributeSetToSpyProductManagementAttributeQuery::create();
    }

    /**
     * @return \Orm\Zed\ProductAttributeSet\Persistence\SpyProductAttributeSetQuery
     */
    public function getProductAttributeSetQuery(): SpyProductAttributeSetQuery
    {
        return SpyProductAttributeSetQuery::create();
    }
}
