<?php
namespace Think\Search;
/**
 * opensearch索引接口.
 * 
 * 主要功能、创建索引、查看索引内容、删除索引和修改索引名称。
 * 
 * @author guangfan.qu
 *
 */
class CloudsearchIndex  {

  const STATUS_OK = 'OK';
  const STATUS_FAIL = 'FAIL';
  /**
   * 索引名称。
   * @var string
   */
  private $client;

  /**
   * CloudsearchClient实例。
   * @var CloudsearchClient
   */
  private $indexName;

  /**
   * 请求的API的URI。
   * @var string
   */
  private $path;

  public function __construct($indexName, $client) {
    $this->client = $client;
    $this->indexName = $indexName;
    $this->_setPath($indexName);
  }

  /**
   * 用指定的模板名称创建一个新的应用。
   * @param string $templateName
   * @param boolean $isFreeSchema 是否为自定义schema，true为自定义模板，false为四个内
   * 置模板信息：novel, news, bbs, download。
   * @param array $opts 包含应用的备注信息。
   * 
   * @return string 返回api返回的正确或错误的结果。
   */
  public function createByTemplateName($templateName, $isFreeSchema = true, 
      $opts = array()) {
    $params = array(
        'action' => "create",
        'template' => $templateName,
    );

    if (isset($opts['desc']) && !empty($opts['desc'])) {
      $params['index_des'] = $opts['desc'];
    }
    
    if ($isFreeSchema == true) {
      $params['template_type'] = 1;
    } else {
      $params['template_type'] = 0;
    }
    
    return $this->client->call($this->path, $params);
  }

   /**
   * 用指定的模板创建一个新的应用。
   * @param string $template,模版是一个格式化数组
   * @param array $opts 包含应用的备注信息。
   * 
   * @return string 返回api返回的正确或错误的结果。
   */
  public function createByTemplate($template,$opts = array()) {
    $params = array(
        'action' => "create",
        'template' => $template,
    );

    if (isset($opts['desc']) && !empty($opts['desc'])) {
      $params['index_des'] = $opts['desc'];
    }
    
    $params['template_type'] = 2;
    
    return $this->client->call($this->path, $params);
  }
 
  /**
   * 更新当前索引的索引名称和备注信息。
   * @param string $toIndexName
   * @param array $opts
   * @return string
   */
  public function rename($toIndexName, $opts = array()) {
    $params = array(
        'action' => "update",
        'new_index_name' => $toIndexName
    );
    
    if (isset($opts['desc']) && !empty($opts['desc'])) {
      $params['description'] = $opts['desc'];
    }

    $result = $this->client->call($this->path, $params);
    $json = json_decode($result, true);
    if (isset($json['status']) && $json['status'] == 'OK') {
      $this->indexName = $toIndexName;
      $this->_setPath($toIndexName);
    }
    return $result;
  }
  
  private function _setPath($indexName) {
    $this->path = '/index/' . $indexName;
  }

  /**
   * 删除当前的索引。
   * 
   * @return string
   */
  public function delete() {
    return $this->client->call($this->path, array('action' => "delete"));
  }


  /**
   * 查看当前索引的状态。
   */
  public function status() {
    return $this->client->call($this->path, array('action' => "status"));
  }

  /**
   * 列出所有索引
   * @param int $page
   * @param int $pageSize
   */
  public function listIndexes($page = 1, $pageSize = 10) {
    $params = array(
        'page' => $page,
        'page_size'  => $pageSize,
    );
    return $this->client->call('/index', $params);
  }

  /**
   * 获取当前索引的索引名称。
   * @return string
   */
  public function getIndexName() {
    return $this->indexName;
  }
  
  /**
   * 获取索引的最近错误列表。
   *
   * @param int $page 指定获取第几页的错误信息。
   * @param int $pageSize 指定每页显示的错误条数。
   *
   * @return array 返回指定页数的错误信息列表。
   */
  public function getErrorMessage($page = 1, $pageSize = 10) {
    $this->_checkPageClause($page);
    $this->_checkPageSizeClause($pageSize);
  
    $params = array(
        'page' => $page,
        'page_size' => $pageSize
    );
    return $this->client->call('/index/error/' . $this->indexName, $params);
  }
  
  /**
   * 检查$page参数是否合法。
   *
   * @param int $page 指定的页码。
   *
   * @throws Exception 如果参数不正确，则抛出此异常。
   *
   * @access private
   */
  private function _checkPageClause($page) {
    if (NULL == $page || !is_int($page)) {
      throw new \Think\Exception('$page is not an integer.');
    }
    if ($page <= 0) {
      throw new \Think\Exception('$page is not greater than or equal to 0.');
    }
  }
  
  /**
   * 检查$pageSize参数是否合法。
   *
   * @param int $pageSize 每页显示的记录条数。
   *
   * @throws Exception 参数不合法
   *
   * @access private
   */
  private function _checkPageSizeClause($pageSize) {
    if (NULL == $pageSize || !is_int($pageSize)) {
      throw new \Think\Exception('$pageSize is not an integer.');
    }
    if ($pageSize <= 0) {
      throw new \Think\Exception('$pageSize is not greater than 0.');
    }
  }
}
