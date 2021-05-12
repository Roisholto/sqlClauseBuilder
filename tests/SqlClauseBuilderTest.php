<?php
use PHPUnit\Framework\TestCase;

use \Roi\SqlClauseBuilder\SqlClauseBuilder ;

final class SqlClauseBuilderTest extends TestCase {

  /**
   * @dataProvider jsonDataProvider
   */
  function testSql($a, $b){
    $searchable_params = [
      'name'=>['col'=> 'merchants.name', 'factors'=>['like','equalto'], 'bind_as'=>PDO::PARAM_STR],
      'type'=>['col'=> 'merchants.type', 'factors'=>['equalto'], 'bind_as'=>PDO::PARAM_STR ],
    ] ;

    $clausebuilder = new SqlClauseBuilder($searchable_params) ;
    $result = $clausebuilder->build($b) ;
    $this->assertIsArray($result['binds']) ;
    $this->assertIsString($result['clause']) ;
    print_r($result) ;
    if($a)
      {
      $this->assertTrue(strlen(trim($result['clause'])) > 0) ;
      $this->assertTrue(count($result['binds']) > 0) ;
      }
    else
      {
      $this->assertSame(0, strlen(trim($result['clause']))) ;
      }

  }

  function jsonDataProvider(){
    return [
      [true, ['name'=>['data'=>['Bob%'],'factor'=>'like'] ]  ],
      [false, []],
      [
        true,
        [
          'name'=>['data'=>['Bob%'],'factor'=>'like'] ,
          'and',
          'type'=>['data'=>['data'], 'factor'=>'equalto']
        ]
      ]
    ] ;
  }

}
?>
