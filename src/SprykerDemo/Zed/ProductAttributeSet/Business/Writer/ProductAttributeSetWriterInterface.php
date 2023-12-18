<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ProductAttributeSet\Business\Writer;

use Generated\Shared\Transfer\ProductAttributeSetTransfer;

interface ProductAttributeSetWriterInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAttributeSetTransfer $productAttributeSetTransfer
     *
     * @return void
     */
    public function saveProductAttributeSet(ProductAttributeSetTransfer $productAttributeSetTransfer): void;
}
