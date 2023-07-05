<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ProductAttributeSet\Business\Reader;

use Generated\Shared\Transfer\ProductAttributeSetTransfer;

interface ProductAttributeSetReaderInterface
{
    /**
     * @param int $idProductAttributeSet
     *
     * @return \Generated\Shared\Transfer\ProductAttributeSetTransfer|null
     */
    public function findProductAttributeSetById(int $idProductAttributeSet): ?ProductAttributeSetTransfer;

    /**
     * @param string $name
     *
     * @return \Generated\Shared\Transfer\ProductAttributeSetTransfer|null
     */
    public function getProductAttributeSetByName(string $name): ?ProductAttributeSetTransfer;
}
