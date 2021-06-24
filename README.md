# SqlClauseBuilder
Build SQL clause from an array.

##### Installation

To add the package to your dependencies, you should have composer installed on your machine. Run the command below in your project directory

 `composer require roi/sql-clause-builder`

###### Namespace

You can access the class within this namespace `\Roi\SqlClauseBuilder`

##### Usage

In order to use the package you must include the auto-generated `autoload.php` file by composer usually in the location `{project-root}/vendor` at the top of your script. 

If you are using a PHP framework like Laravel, Slim etc, you can skip the above because it would be automatically added. 

`SqlClauseBuilder` requires you to first define an associative array of parameters that is acceptable. See sample below 

```php
$searchable_params = [
    'name'=>[
        'col'=> 'merchants.name', 
        'factors'=>[
            'like',
            'equalto'
        ], 
        'bind_as'=>PDO::PARAM_STR
    ],
    'type'=>[
        'col'=> 'merchants.type', 
        'factors'=>[
            'equalto'
        ], 
        'bind_as'=>PDO::PARAM_STR
    ],
] ;
```

Notice that each entry in the array above is an associative array with 3 defined keys, which are 

* `col`, a string which implies to the corresponding column in the table 
* `factors`, an array of SQL operations that can be performed on the specified column
* `bind_as`, the explicit data type for the parameter. See https://www.php.net/manual/en/pdo.constants.php for a list options. 

Please note that the keys are required.

Next, create an instance of `SqlClauseBuilder` with the defined searchable columns passed as the argument.

Note that the `$searchable_params` is the only argument required by the constructor

```php
$clausebuilder = new \Roi\SqlClauseBuilder\SqlClauseBuilder($searchable_params) ;
```

Then you could easily fit this in a PDO prepared statement, binding the parameters ;

Next call the `build` method, passing the array you want built into a SQL clause

```php
$data = ['name'=>['data'=>['Bob%'],'factor'=>'like'] ] ;
$clause = $clausebuilder->build($data) ; // returns ['clause'=> 'merchants.name LIKE ?', 'binds'=>[ ['Bob%',PDO::PARAM_STR] ] ]
```

The build method returns an array with structure like below

```php
[
    'clause'=> 'merchants.name LIKE ?', 
    'binds'=>[ 
        [
            'Bob%',PDO::PARAM_STR
        ] 
    ] 
]
```

You can use the result in your query as demonstrated below

```php
$query = $Pdo->prepare("SELECT * FROM table WHERE $clause['clause'] ") ;
foreach($clause['binds'] as $key=>$val){
  $query->bindParam($val[0], $val[1]) ;
}
$query->execute() ;
```



### WHAT IS COVERED

The following operators are supported 

* like,
* equalto
* notequalto
* greaterthan
* lesserthan
* greaterthanorequalto
* lesserthanorequalto
* between
* notbetween
* isnull
* notisnull



### TODO

- [ ] add support for more operators
- [ ] provide a method that allows users add operators 
