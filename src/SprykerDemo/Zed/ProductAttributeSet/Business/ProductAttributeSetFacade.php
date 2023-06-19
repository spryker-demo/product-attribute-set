<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ProductAttributeSet\Business;

use Generated\Shared\Transfer\ProductAttributeSetTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \SprykerDemo\Zed\ProductAttributeSet\Business\ProductAttributeSetBusinessFactory getFactory()
 */
class ProductAttributeSetFacade extends AbstractFacade implements ProductAttributeSetFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idProductAttributeSet
     *
     * @return \Generated\Shared\Transfer\ProductAttributeSetTransfer|null
     */
    public function findProductAttributeSetById(int $idProductAttributeSet): ?ProductAttributeSetTransfer
    {
        return $this->getFactory()->createProductAttributeSetReader()->getProductAttributeSetById($idProductAttributeSet);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $name
     *
     * @return \Generated\Shared\Transfer\ProductAttributeSetTransfer|null
     */
    public function findProductAttributeSetByName(string $name): ?ProductAttributeSetTransfer
    {
        return $this->getFactory()->createProductAttributeSetReader()->getProductAttributeSetByName($name);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductAttributeSetTransfer $productAttributeSetTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAttributeSetTransfer
     */
    public function saveProductAttributeSet(ProductAttributeSetTransfer $productAttributeSetTransfer): ProductAttributeSetTransfer
    {
        return $this->getFactory()->createProductAttributeSetSaver()->save($productAttributeSetTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductAttributeSetTransfer $productAttributeSetTransfer
     *
     * @return void
     */
    public function deleteProductAttributeSet(ProductAttributeSetTransfer $productAttributeSetTransfer): void
    {
        $this->getFactory()->createProductAttributeSetDeleter()->delete($productAttributeSetTransfer);
    }
}
