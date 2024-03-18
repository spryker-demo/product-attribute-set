<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ProductAttributeSet\Persistence;

use Generated\Shared\Transfer\ProductAttributeSetCriteriaTransfer;
use Generated\Shared\Transfer\ProductAttributeSetTransfer;
use Generated\Shared\Transfer\SpyProductAttributeSetEntityTransfer;
use Generated\Shared\Transfer\SpyProductAttributeSetToSpyProductManagementAttributeEntityTransfer;
use Orm\Zed\ProductAttributeSet\Persistence\SpyProductAttributeSetQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \SprykerDemo\Zed\ProductAttributeSet\Persistence\ProductAttributeSetPersistenceFactory getFactory()
 */
class ProductAttributeSetRepository extends AbstractRepository implements ProductAttributeSetRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAttributeSetCriteriaTransfer $productAttributeSetCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAttributeSetTransfer|null
     */
    public function findProductAttributeSetByCriteria(ProductAttributeSetCriteriaTransfer $productAttributeSetCriteriaTransfer): ?ProductAttributeSetTransfer
    {
        $productAttributeSetQuery = $this->getFactory()
            ->getProductAttributeSetQuery()
            ->joinWithSpyProductAttributeSetToSpyProductManagementAttribute();
        $productAttributeSetQuery = $this->applyCriteria($productAttributeSetQuery, $productAttributeSetCriteriaTransfer);

        $productAttributeSetEntity = $productAttributeSetQuery->find()->getFirst();
        if (!$productAttributeSetEntity) {
            return null;
        }

        return $this->getFactory()->createProductAttributeSetMapper()
            ->mapProductAttributeSetEntityToProductAttributeSetTransfer($productAttributeSetEntity, new ProductAttributeSetTransfer());
    }

    /**
     * @return array<string, int>
     */
    public function getProductAttributeSetIdsIndexedByName(): array
    {
        /** @var \Propel\Runtime\Collection\ObjectCollection $productAttributeSets */
        $productAttributeSets = $this->getFactory()
            ->getProductAttributeSetQuery()
            ->find();

        /** @var array<string, int> $productAttributeSetIdsIndexedByName */
        $productAttributeSetIdsIndexedByName = $productAttributeSets->toKeyValue(
            SpyProductAttributeSetEntityTransfer::NAME,
            SpyProductAttributeSetEntityTransfer::ID_PRODUCT_ATTRIBUTE_SET,
        );

        return $productAttributeSetIdsIndexedByName;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAttributeSetCriteriaTransfer $productAttributeSetCriteriaTransfer
     *
     * @return bool
     */
    public function productAttributeSetExists(ProductAttributeSetCriteriaTransfer $productAttributeSetCriteriaTransfer): bool
    {
        $productAttributeSetQuery = $this->getFactory()->getProductAttributeSetQuery();
        $productAttributeSetQuery = $this->applyCriteria($productAttributeSetQuery, $productAttributeSetCriteriaTransfer);

        return $productAttributeSetQuery->exists();
    }

    /**
     * @param int $idProductAttributeSet
     *
     * @return array<int>
     */
    public function getExistingProductManagementAttributeIds(int $idProductAttributeSet): array
    {
        /** @var \Propel\Runtime\Collection\ObjectCollection $productAttributeSetToSpyProductManagementAttributeEntities */
        $productAttributeSetToSpyProductManagementAttributeEntities = $this->getFactory()
            ->getSpyProductAttributeSetToSpyProductManagementAttributeQuery()
            ->filterByFkProductAttributeSet($idProductAttributeSet)
            ->find();

        return $productAttributeSetToSpyProductManagementAttributeEntities->getColumnValues(SpyProductAttributeSetToSpyProductManagementAttributeEntityTransfer::FK_PRODUCT_MANAGEMENT_ATTRIBUTE);
    }

    /**
     * @param \Orm\Zed\ProductAttributeSet\Persistence\SpyProductAttributeSetQuery $productAttributeSetQuery
     * @param \Generated\Shared\Transfer\ProductAttributeSetCriteriaTransfer $productAttributeSetCriteriaTransfer
     *
     * @return \Orm\Zed\ProductAttributeSet\Persistence\SpyProductAttributeSetQuery
     */
    protected function applyCriteria(
        SpyProductAttributeSetQuery $productAttributeSetQuery,
        ProductAttributeSetCriteriaTransfer $productAttributeSetCriteriaTransfer
    ): SpyProductAttributeSetQuery {
        if ($productAttributeSetCriteriaTransfer->getIdProductAttributeSet()) {
            $productAttributeSetQuery->filterByIdProductAttributeSet(
                $productAttributeSetCriteriaTransfer->getIdProductAttributeSet(),
            );
        }

        if ($productAttributeSetCriteriaTransfer->getName()) {
            $productAttributeSetQuery->filterByName(
                $productAttributeSetCriteriaTransfer->getName(),
            );
        }

        if ($productAttributeSetCriteriaTransfer->getExcludedProductAttributeSetId()) {
            $productAttributeSetQuery->filterByIdProductAttributeSet(
                $productAttributeSetCriteriaTransfer->getExcludedProductAttributeSetId(),
                Criteria::NOT_EQUAL,
            );
        }

        return $productAttributeSetQuery;
    }
}
