<?php
namespace Common\Model;


interface IMessage
{

    /**获取聊天源，一般用于创建聊天时对顶部来源进行赋值
     * @param $message
     * @return mixed
     */
    public function getSource($message);

    /**获得查找的内容，在第一次创建会话的时候获取第一个聊天的内容时触发
     * @param $message
     * @return mixed
     */
    public function getFindContent($message);

    /**在自己发送聊天消息的时候被触发，一般用于同步内容到对应的应用
     * @param $source_message
     * @param $talk
     * @param $content
     * @return array
     */
    public function postMessage($source_message, $talk, $content);
    
} 