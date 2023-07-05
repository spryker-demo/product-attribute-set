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
 * @method \SprykerDemo\Zed\ProductAttributeSet\Persistence\ProductAttributeSetEntityManager getEntityManager()
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
        return $this->getFactory()->createProductAttributeSetReader()->findProductAttributeSetById($idProductAttributeSet);
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
        return $this->getEntityManager()->saveProductAttributeSet($productAttributeSetTransfer);
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
        $this->getEntityManager()->deleteProductAttributeSet($productAttributeSetTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return array<\Generated\Shared\Transfer\ProductAttributeSetTransfer>
     */
    public function getProductAttributeSets(): array
    {
        return $this->getFactory()->createProductAttributeSetReader()->getProductAttributeSets();
    }
}
