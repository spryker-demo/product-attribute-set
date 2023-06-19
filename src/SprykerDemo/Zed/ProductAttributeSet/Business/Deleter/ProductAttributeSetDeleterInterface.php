<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ProductAttributeSet\Business\Deleter;

use Generated\Shared\Transfer\ProductAttributeSetTransfer;

interface ProductAttributeSetDeleterInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAttributeSetTransfer $productAttributeSetTransfer
     *
     * @return void
     */
    public function delete(ProductAttributeSetTransfer $productAttributeSetTransfer): void;
}
