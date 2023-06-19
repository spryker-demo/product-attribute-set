<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ProductAttributeSet\Business\Saver;

use Generated\Shared\Transfer\ProductAttributeSetTransfer;

interface ProductAttributeSetSaverInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAttributeSetTransfer $productAttributeSetTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAttributeSetTransfer
     */
    public function save(ProductAttributeSetTransfer $productAttributeSetTransfer): ProductAttributeSetTransfer;
}
