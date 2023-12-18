<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ProductAttributeSet\Business;

use Generated\Shared\Transfer\ProductAttributeSetCriteriaTransfer;
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
     * @param \Generated\Shared\Transfer\ProductAttributeSetCriteriaTransfer $productAttributeSetCriteriaTransfer
     *
     * @return bool
     */
    public function productAttributeSetExists(ProductAttributeSetCriteriaTransfer $productAttributeSetCriteriaTransfer): bool
    {
        return $this->getFactory()->createProductAttributeSetReader()->productAttributeSetExists($productAttributeSetCriteriaTransfer);
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
    public function saveProductAttributeSet(ProductAttributeSetTransfer $productAttributeSetTransfer): void
    {
        $this->getFactory()->createProductAttributeSetWriter()->saveProductAttributeSet($productAttributeSetTransfer);
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
     * @return array<string, int>
     */
    public function getProductAttributeSetIdsIndexedByName(): array
    {
        return $this->getFactory()->createProductAttributeSetReader()->getProductAttributeSetIdsIndexedByName();
    }
}
