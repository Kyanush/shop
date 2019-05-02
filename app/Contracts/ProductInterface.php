<?php

namespace App\Contracts;

interface ProductInterface
{
    public function productDelete($product_id);
    public function productClone($product_id, array $data, array $copy = []);
    public function productGroupSave(int $product_id, int $product_group_id, array $product_ids);
    public function productImagesSave(array $images, $product_id);
    public function productAttributesSave(int $product_id, array $attributes, bool $new_attributes);
    public function priceMinMax($filters);
    public function productsAttributesFilters($filters, $useInFilter = true);
}