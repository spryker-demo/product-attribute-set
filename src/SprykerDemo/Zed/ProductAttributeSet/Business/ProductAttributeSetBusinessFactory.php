<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ProductAttributeSet\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\ProductAttribute\Business\ProductAttributeFacadeInterface;
use SprykerDemo\Zed\ProductAttributeSet\Business\Deleter\ProductAttributeSetDeleter;
use SprykerDemo\Zed\ProductAttributeSet\Business\Deleter\ProductAttributeSetDeleterInterface;
use SprykerDemo\Zed\ProductAttributeSet\Business\Reader\ProductAttributeSetReader;
use SprykerDemo\Zed\ProductAttributeSet\Business\Reader\ProductAttributeSetReaderInterface;
use SprykerDemo\Zed\ProductAttributeSet\Business\Saver\ProductAttributeSetSaver;
use SprykerDemo\Zed\ProductAttributeSet\Business\Saver\ProductAttributeSetSaverInterface;
use SprykerDemo\Zed\ProductAttributeSetGui\ProductAttributeSetGuiDependencyProvider;

/**
 * @method \SprykerDemo\Zed\ProductAttributeSet\Persistence\ProductAttributeSetEntityManagerInterface getEntityManager()
 * @method \SprykerDemo\Zed\ProductAttributeSet\Persistence\ProductAttributeSetRepositoryInterface getRepository()
 */
class ProductAttributeSetBusinessFactory extends AbstractBusinessFactory
{
 /**
  * @return \Spryker\Zed\ProductAttribute\Business\ProductAttributeFacadeInterface
  */
    public function getProductAttributeFacade(): ProductAttributeFacadeInterface
    {
        return $this->getProvidedDependency(ProductAttributeSetGuiDependencyProvider::FACADE_PRODUCT_ATTRIBUTE);
    }

    /**
     * @return \SprykerDemo\Zed\ProductAttributeSet\Business\Reader\ProductAttributeSetReaderInterface
     */
    public function createProductAttributeSetReader(): ProductAttributeSetReaderInterface
    {
        return new ProductAttributeSetReader($this->getRepository(), $this->getProductAttributeFacade());
    }

    /**
     * @return \SprykerDemo\Zed\ProductAttributeSet\Business\Saver\ProductAttributeSetSaverInterface
     */
    public function createProductAttributeSetSaver(): ProductAttributeSetSaverInterface
    {
        return new ProductAttributeSetSaver($this->getEntityManager());
    }

    /**
     * @return \SprykerDemo\Zed\ProductAttributeSet\Business\Deleter\ProductAttributeSetDeleterInterface
     */
    public function createProductAttributeSetDeleter(): ProductAttributeSetDeleterInterface
    {
        return new ProductAttributeSetDeleter($this->getEntityManager());
    }
}
