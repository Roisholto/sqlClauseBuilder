# sqlClauseBuilder
Build sql clause from an array 

### Example 
```php 
   <?php$searchable_params = [
                            'mid'=>['col'=>'merchants.m_id','factors'=>['equalto'],'bind_as'=>PDO::PARAM_STR],
                            'name'=>['col'=> 'merchants.name', 'factors'=>['like','equalto'], 'bind_as'=>PDO::PARAM_STR],
                            'type'=>['col'=> 'merchants.type', 'factors'=>['equalto'], 'bind_as'=>PDO::PARAM_STR ],
                            'closeness'=>['col'=>'merchants.location' , 'factors'=>['greaterthan','lesserthan'], 'bind_as'=>PDO::PARAM_STR ]
                            ] ;

$clausebuilder = new sqlClauseBuilder($searchable_params) ;
$search = ['name'=>['data'=>['Bob%'],'factor'=>'like'] ]  ]
$clause = $clausebuilder->build($build) ;  // returns ['clause'=> 'merchants.name LIKE ?', 'binds'=>[ ['Bob%',PDO::PARAM_STR] ] ) ```
