<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ProductAttributeSet\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\ProductAttribute\Business\ProductAttributeFacadeInterface;
use SprykerDemo\Zed\ProductAttributeSet\Business\Reader\ProductAttributeSetReader;
use SprykerDemo\Zed\ProductAttributeSet\Business\Reader\ProductAttributeSetReaderInterface;
use SprykerDemo\Zed\ProductAttributeSet\Business\Writer\ProductAttributeSetWriter;
use SprykerDemo\Zed\ProductAttributeSet\Business\Writer\ProductAttributeSetWriterInterface;
use SprykerDemo\Zed\ProductAttributeSet\ProductAttributeSetDependencyProvider;

/**
 * @method \SprykerDemo\Zed\ProductAttributeSet\Persistence\ProductAttributeSetEntityManagerInterface getEntityManager()
 * @method \SprykerDemo\Zed\ProductAttributeSet\Persistence\ProductAttributeSetRepositoryInterface getRepository()
 */
class ProductAttributeSetBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \SprykerDemo\Zed\ProductAttributeSet\Business\Reader\ProductAttributeSetReaderInterface
     */
    public function createProductAttributeSetReader(): ProductAttributeSetReaderInterface
    {
        return new ProductAttributeSetReader(
            $this->getRepository(),
            $this->getProductAttributeFacade(),
        );
    }

    /**
     * @return \SprykerDemo\Zed\ProductAttributeSet\Business\Writer\ProductAttributeSetWriterInterface
     */
    public function createProductAttributeSetWriter(): ProductAttributeSetWriterInterface
    {
        return new ProductAttributeSetWriter($this->getEntityManager(), $this->getRepository());
    }

    /**
     * @return \Spryker\Zed\ProductAttribute\Business\ProductAttributeFacadeInterface
     */
    public function getProductAttributeFacade(): ProductAttributeFacadeInterface
    {
        return $this->getProvidedDependency(ProductAttributeSetDependencyProvider::FACADE_PRODUCT_ATTRIBUTE);
    }
}
