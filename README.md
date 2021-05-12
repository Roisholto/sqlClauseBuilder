# sqlClauseBuilder
Build sql clause from an array

## Example
```php
<?php

$searchable_params = [
    'name'=>['col'=> 'merchants.name', 'factors'=>['like','equalto'], 'bind_as'=>PDO::PARAM_STR],
    'type'=>['col'=> 'merchants.type', 'factors'=>['equalto'], 'bind_as'=>PDO::PARAM_STR ],
     ] ;

$clausebuilder = new \Roi\SqlClauseBuilder\SqlClauseBuilder($searchable_params) ;
$data = ['name'=>['data'=>['Bob%'],'factor'=>'like'] ] ;
$clause = $clausebuilder->build($data) ; // returns ['clause'=> 'merchants.name LIKE ?', 'binds'=>[ ['Bob%',PDO::PARAM_STR] ] )

?> ```

Then you could easily fit this in a pdo prepared statement, binding the parameters ;
```php
<?php

$query = $Pdo->prepare("SELECT * FROM table WHERE $clause['clause'] ") ;
foreach($clause['binds'] as $key=>$val){
  $query->bindParam($val[0], $val[1]) ;
}
$query->execute() ;
?>
```
