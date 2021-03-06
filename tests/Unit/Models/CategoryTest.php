<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Genre;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    private $category;

    protected function setUp(): void{
      parent::setUp();
      $this->category = new Category();
    }

    public function testIfUsingTraits(){
      $traits = [
        SoftDeletes::class, Uuid::class
      ];
      $categoryTraits = array_keys(class_uses(Category::class));
      $this->assertEqualsCanonicalizing($traits, $categoryTraits);
    }

    public function testFillableAttribute()
    {
      $fillable = ['name', 'description','is_active'];
        $this->assertEqualsCanonicalizing( 
          $fillable, 
          $this->category->getFillable()
        );
    }

    public function testCastsAttribute(){
      $casts = [
        'id' => 'string',
        'is_active' => 'bool'
      ];
      $this->assertEqualsCanonicalizing($casts, $this->category->getCasts());
    }
    
    public function testIncrementingAttribute(){
      $this->assertFalse($this->category->incrementing);
    }

    public function testDatesAttribute(){
      $dates = ['deleted_at', 'created_at', 'updated_at'];
      $this->assertEqualsCanonicalizing($dates, $this->category->getDates());
    }
}
