## Filament Tree

```sh
composer require yemenpoint/filament-tree
```

publish assets

```sh
php artisan vendor:publish --tag="filament-tree-assets"
php artisan vendor:publish --tag="filament-tree-views"
```

# Tree Field

### migration 
```php
Schema::table('tryings', function (Blueprint $table) {
    $table->json("items")->nullable();
});
```

```php

use Yemenpoint\FilamentTree\Forms\Components\TreeField;

TreeField::make("items")
->setMaxDepth(999)
->default([["id" => "1", "name" => "item 1", "children" => [["id" => "2", "name" => "item 2", "children" => []]]]]),
```
<div align="center">
    <img src="https://github.com/yemenpoint/FilamentTree/blob/main/images/tree.png" alt="">
</div>
<br/>

# Tree Page

## Table structure and model
```structure
categories
id          - integer
parent_id   - integer
order       - integer
name       - string
```
```php
Schema::create('categories', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('parent_id')->nullable();
    $table->integer('order')->nullable()->default(0);
    $table->string('name');
});
```

# model
```php
<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Yemenpoint\FilamentTree\HasTree;

class Category extends Model
{
    use HasTree;
    
    function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')->with("children")->orderBy("order");
    }
}

```
# page

```php 

<?php

namespace App\Filament\Resources\Application\CategoryResource\Pages;

use App\Filament\Resources\Application\CategoryResource;
use App\Models\Category;
use Yemenpoint\FilamentTree\TreePage;

class TreeCategory extends TreePage
{
    protected static string $resource = CategoryResource::class;

    public function getItems(): array
    {
        return Category::with("children")->whereNull("parent_id")->orderBy("order")->get()->toArray();
    }
    
    public function getMaxDepth(): int
    {
        return parent::getMaxDepth(); // TODO: Change the autogenerated stub
    }

    public function isDisabled(): bool
    {
        return parent::isDisabled(); // TODO: Change the autogenerated stub
    }

}

```