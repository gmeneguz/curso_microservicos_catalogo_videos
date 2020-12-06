<?php

namespace Tests\Feature\Models;

use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use DatabaseMigrations;
 
    public function testList()
    {
      factory(Genre::class, 1)->create();
      $genres = Genre::all();
      $this->assertCount(1, $genres);
      
      $genreKeys = array_keys($genres->first()->getAttributes());
      $this->assertEqualsCanonicalizing(['id', 'name', 'is_active','created_at', 'updated_at', 'deleted_at'], $genreKeys);
    }
    
    public function testCreate(){

      $genre = Genre::create(['name'=> 'teste1']);
      $genre->refresh();
      $this->assertTrue($genre->is_active);

      $this->assertTrue(Uuid::isValid($genre->id));

      $genre = Genre::create(['name'=> 'teste1', 'is_active' => true]);
      $this->assertTrue($genre->is_active);

      $genre = Genre::create(['name'=> 'teste1', 'is_active' => false]);
      $this->assertFalse($genre->is_active);
    }

    public function testUpdate(){

      $genre = factory(Genre::class)->create([])->first();

      $data = [
        'name' => 'test_name',
        'is_active' => false 
      ];
      $genre->update($data);
      
      foreach($data as $key => $value){
        $this->assertEquals($value, $genre->{$key});

      }
    }

    public function testDelete(){
      $category = Genre::create(['name' => 'test']);

      $category->delete();

      $this->assertCount(0, Genre::all());
    }
}
