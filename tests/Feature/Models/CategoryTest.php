<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class CategoryTest extends TestCase
{

  use DatabaseMigrations;
 
    public function testList()
    {
      factory(Category::class, 1)->create();
      $categories = Category::all();
      $this->assertCount(1, $categories);
      
      $categoryKeys = array_keys($categories->first()->getAttributes());
      $this->assertEqualsCanonicalizing(['id', 'name', 'is_active','description','created_at', 'updated_at', 'deleted_at'], $categoryKeys);
    }
    
    public function testCreate(){

      $category = Category::create(['name'=> 'teste1']);
      $category->refresh();
      $this->assertNull($category->description);
      $this->assertTrue($category->is_active);

      $this->assertTrue(Uuid::isValid($category->id));

      $category = Category::create(['name'=> 'teste1', 'description' => null]);
      $this->assertNull($category->description);

      $category = Category::create(['name'=> 'teste1', 'is_active' => true]);
      $this->assertTrue($category->is_active);

      $category = Category::create(['name'=> 'teste1', 'is_active' => false]);
      $this->assertFalse($category->is_active);
    }

    public function testUpdate(){

      $category = factory(Category::class)->create([
        'description' => 'test_description'
      ]);

      $data = [
        'name' => 'test_name',
        'description'=> 'test_description',
        'is_active' => false 
      ];
      $category->update($data);
      
      foreach($data as $key => $value){
        $this->assertEquals($value, $category->{$key});

      }
    }

    public function testDelete(){
      $category = Category::create(['name' => 'test']);

      $category->delete();

      $this->assertCount(0, Category::all());
    }
}
