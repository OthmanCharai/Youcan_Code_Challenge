<?php

namespace Tests\Unit;

use App\Exceptions\UploadImageException;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Testing\File;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     * @throws UploadImageException
     */
    public function test_product_store()
    {
        // Create and make new instance of category, product
        $product = Product::factory()->make()->toArray();
        $category = Category::factory()->create();

        $image = File::image('sample.jpg', 600, 400)->size(100);

        // Create new Request
        $request = array_merge($product, ['category_id' => $category->id, 'image' => $image]);

        $response = $this->post(route('product.store'), $request);

        $this->assertDatabaseHas('products', [
                "name" => $product['name'],
                "description" => $product['description'],
                "price" => $product['price']]
        );

        $this->assertDatabaseHas('category_product', [
            'product_id' => $response->json()['data']['id'],
            'category_id' => $category->id
        ]);

        $this->assertEquals(201, $response->status());
    }
}
