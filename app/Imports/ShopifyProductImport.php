<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Product;
use App\Models\Upload;
use App\Helpers\LogHelper;

class ShopifyProductImport implements ToCollection, WithHeadingRow
{
    protected $upload;

    public function __construct(Upload $upload)
    {
        $this->upload = $upload;
    }

    
    public function collection(Collection $rows)
    {
        
        $this->upload->update([
            'total_records' => $rows->count()
        ]);

        foreach ($rows as $row)
        {
            try {
                
                $product = Product::where('handle', $row['handle'])->first();
                if($product){
                    $product->title = $row['title'];
                    $product->body_html = $row['body_html'];
                    $product->vendor = $row['vendor'];
                    $product->product_type = $row['product_type'];
                    $product->tags = $row['tags'];
                    $product->variant_price = $row['variant_price'];

                    $product->save();

                    LogHelper::save(

                        $this->upload->id,

                        $product->id,

                        'info',

                        'CSV Uploaded.'

                    );

                    LogHelper::save(

                        $this->upload->id,

                        $product->id,

                        'info',

                        'Product updated successfully.'

                    );

                    if($product->shopify_product_id)
                    {
                        $shopify = app(\App\Services\ShopifyService::class);

                        $shopify->updateProduct($product);

                        $product->status = "updated";
                        $product->error_message = null;

                        $product->save();
                    }
                }else{
                    $product = Product::create([
                        'upload_id' => $this->upload->id,
                        'handle' => $row['handle'],
                        'title' => $row['title'],
                        'body_html' => $row['body_html'],
                        'vendor' => $row['vendor'],
                        'product_type' => $row['product_type'],
                        'tags' => $row['tags'],
                        'published' => strtoupper($row['published']) == 'TRUE',
                        'variant_sku' => $row['variant_sku'],
                        'variant_price' => $row['variant_price'],
                        'variant_compare_at_price' => $row['variant_compare_at_price'],
                        'variant_requires_shipping' => strtoupper($row['variant_requires_shipping']) == 'TRUE',
                        'variant_taxable' => strtoupper($row['variant_taxable']) == 'TRUE',
                        'variant_inventory_tracker' => $row['variant_inventory_tracker'],
                        'variant_inventory_qty' => $row['variant_inventory_qty'],
                        'variant_inventory_policy' => $row['variant_inventory_policy'],
                        'variant_fulfillment_service' => $row['variant_fulfillment_service'],
                        'variant_weight' => $row['variant_weight'],
                        'variant_weight_unit' => $row['variant_weight_unit'],
                        'image_src' => $row['image_src'],
                        'image_position' => $row['image_position'],
                        'image_alt_text' => $row['image_alt_text'],
                        'status' => 'pending'
                    ]);

                    LogHelper::save(

                        $this->upload->id,

                        $product->id,

                        'info',

                        'CSV Uploaded.'

                    );

                    LogHelper::save(

                        $this->upload->id,

                        $product->id,

                        'info',

                        'Product created successfully.'

                    );

                    $shopify = app(\App\Services\ShopifyService::class);

                    $result = $shopify->createProduct($product);

                    if(empty($result['data']['productCreate']['userErrors']))
                    {
                        $shopifyProductId = $result['data']['productCreate']['product']['id'];
                        $product->shopify_product_id = $shopifyProductId;

                        $collectionResult = $shopify->addProductToCollection(

                            env('SHOPIFY_COLLECTION_ID'),

                            $shopifyProductId

                        );

                        if(empty($collectionResult['data']['collectionAddProducts']['userErrors']))
                        {
                            $product->status = "success";
                            
                            $product->error_message = null;

                            LogHelper::save(

                                $this->upload->id,

                                $product->id,

                                'info',

                                'Product added into collection.'

                            );
                        }
                        else
                        {
                            $userErrors = $collectionResult['data']['collectionAddProducts']['userErrors'];

                            $errorMessage = $userErrors[0]['message'] ?? 'Unknown Error';

                            $product->status = "failed";
                            
                            $product->error_message = $errorMessage;

                            LogHelper::save(

                                $this->upload->id,

                                $product->id,

                                'error',

                                $errorMessage

                            );
                        }

                        $product->save();
                    }
                }

                
            } catch (\Exception $e) {

                LogHelper::save(

                    $this->upload->id,

                    $product->id,

                    'error',

                    $e->getMessage()

                );

                dd($e->getMessage());

            }
        }

        $this->upload->update([
            'processed_records' => $rows->count(),
            'successful_records' => $rows->count(),
            'status' => 'completed'
        ]);
    }
}