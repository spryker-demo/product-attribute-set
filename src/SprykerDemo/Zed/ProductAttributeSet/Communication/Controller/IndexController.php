<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ProductAttributeSet\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerDemo\Zed\ProductAttributeSet\Business\ProductAttributeSetFacadeInterface getFacade()
 */
class IndexController extends AbstractController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function indexAction(Request $request): JsonResponse
    {
        $attributeSetId = $this->castId($request->query->get('attribute-set-id'));

        if (!$attributeSetId) {
            return $this->jsonResponse(['error' => 'Attribute set id is required'], 400);
        }

        $attributeSet = $this->getFacade()->findProductAttributeSetById($attributeSetId);

        if (!$attributeSet) {
            return $this->jsonResponse(['error' => 'Attribute set not found'], 404);
        }

        return $this->jsonResponse(
            $attributeSet->toArray(),
        );
    }
}
