# VahidIrn\\GraphQLFilter

Define GraphQL schema for connection filtering using Laravel filterQuery models.

# Installation

```
composer require vahidirn/laravel-graphql
```

# Usage

Use FilterQuery trait on Model

```
namespace App;
use VahidIrn\FilterQuery\FilterQuery;

class User extends Model
{
  use \VahidIrn\FilterQuery\FilterQueryTrait;
  
  protected $filterQuery = [
    'name' => FilterQuery::String
  ];
}
```

Create GraphQL User type

```
namespace App\GraphQL\Type;

use App\User;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class User extends GraphQLType
{
  protected $attributes = [
    'name' => 'User'
  ];
  public function fields() {
    return [
      'id' => [
        'type' => Type::id(),
      ],
      'name' => [
        'type' => Type::string()
      ]
    ]
  }
}
```

Create GraphQL UserFilter type. The UserFilter fields defintion will be automatically populated with fields in `User::$filterQuery`.

```
namespace App\GraphQL\Type;

use App\User;
use VahidIrn\GraphQLFilter\Type\FilterType;

class UserFilter extends FilterType
{
  protected $model = User::class;
}
```

Create GraphQL query type to list User records using the User model's filterQuery settings.

```
namespace App\GraphQL\Type;

use App\User;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;

class UsersQuery extends Query
{
  protected $attributes = [
    'name' => 'users'
  ];
  public function type() {
    return Type::listOf(GraphQL::type('User'));
  }
  public function args() {
    return [
      'filter' => [
        'type' => GraphQL::type('UserFilter')
      ]
    ];
  }
  public function resolve($root, $args, $context) {
    return User::filter($args['filter'])->orderBy('name')->limit(10)->get();
  }
}
```

A GraphQL query can now use the `FilterQuery::String` rules to perform searches.

```
query Users {
  users (filter: { name_MATCH: 'vahid' }) {
    name
  }
}
```
