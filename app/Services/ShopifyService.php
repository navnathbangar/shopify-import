<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ShopifyService
{
    protected $store;
    protected $token;

    public function __construct()
    {
        $this->store = env('SHOPIFY_STORE');
        $this->token = env('SHOPIFY_ACCESS_TOKEN');
    }

    public function graphql($query, $variables = null)
    {
        $body = [
            'query' => $query,
        ];

        if ($variables !== null) {
            $body['variables'] = $variables;
        }

        $response = Http::withHeaders([
            'X-Shopify-Access-Token' => $this->token,
            'Content-Type' => 'application/json',
        ])->post(
            "https://{$this->store}/admin/api/2025-01/graphql.json",
            $body
        );

        return $response->json();
    }

    public function createProduct($product)
    {
        $mutation = <<<GRAPHQL

        mutation productCreate(\$input: ProductInput!) {

            productCreate(input: \$input) {

                product {

                    id
                    title

                }

                userErrors {

                    field
                    message

                }

            }

        }

        GRAPHQL;

        $variables = [

            "input" => [

                "title" => $product->title,

                "descriptionHtml" => $product->body_html,

                "vendor" => $product->vendor,

                "productType" => $product->product_type,

                "tags" => explode(',', $product->tags),

                "status" => "ACTIVE"

            ]

        ];

        return $this->graphql($mutation, $variables);
    }

    public function addProductToCollection($collectionId, $productId)
    {
        $mutation = <<<GRAPHQL

        mutation collectionAddProducts(\$id: ID!, \$productIds: [ID!]!) {

        collectionAddProducts(

            id: \$id,

            productIds: \$productIds

        ) {

            userErrors {

            field
            message

            }

        }

        }

        GRAPHQL;

        $variables = [

            "id" => $collectionId,

            "productIds" => [

                $productId

            ]

        ];

        return $this->graphql($mutation, $variables);
    }

    public function updateProduct($product)
    {
        $mutation = <<<GRAPHQL

        mutation productUpdate(\$input: ProductUpdateInput!) {

        productUpdate(input: \$input) {

            product {

            id
            title

            }

            userErrors {

            field
            message

            }

        }

        }

        GRAPHQL;

        $variables = [

            "input" => [

                "id" => $product->shopify_product_id,

                "title" => $product->title,

                "descriptionHtml" => $product->body_html,

                "vendor" => $product->vendor,

                "productType" => $product->product_type,

                "tags" => explode(',', $product->tags)

            ]

        ];

        return $this->graphql($mutation, $variables);
    }

    public function findProductByHandle($handle)
    {
        $query = <<<GRAPHQL
        query(\$handle: String!) {
        productByHandle(handle: \$handle) {
            id
            title
        }
        }
        GRAPHQL;

        return $this->graphql($query, [
            'handle' => $handle
        ]);
    }

    
    public function testConnection()
    {
        $response = Http::withHeaders([
            'X-Shopify-Access-Token' => $this->token,
            'Content-Type' => 'application/json',
        ])->post(
            "https://{$this->store}/admin/api/2025-01/graphql.json",
            [
                "query" => "{ shop { name } }"
            ]
        );

        dd(
            $response->status(),
            $response->json(),
            $response->body()
        );
    }
}