<?php

namespace Think\Search;
/**
 * opensearch 统计接口。
 * 
 * 用户可以通过此接口获取某索引的pv及top query信息。
 * 
 * TODO 完成pv信息的获取。
 * 
 * @author guangfan.qu
 *
 */
class CloudsearchAnalysis {
  
  /**
   * 统计的应用名称。
   * @var string
   */
  private $indexName;
  
  /**
   * CloudsearchClient 实例。
   * @var CloudsearchClient 
   */
  private $client;
  
  /**
   * 指定API接口的相对路径。
   * @var string
   */
  private $path;

  /**
   * 构造函数。
   * @param string $indexName 指定统计信息的应用名称。
   * @param CloudsearchClient $client 此对象由CloudsearchClient类实例化。
   */
  public function __construct($indexName, $client) {
    $this->indexName = $indexName;
    $this->client = $client;
    $this->path = '/top/query/' . $indexName;
  }

  /**
   * 通过指定的天数和个数，返回top query信息。
   * @param int $num 指定返回的记录个数。
   * @param int $days 指定统计从昨天开始向前多少天的数据。
   * @return array
   */
  public function getTopQuery($num, $days) {
    $params = array(
      'num' => $num,
      'days' => $days
    );

    return $this->client->call($this->path, $params);
  }
}
?>