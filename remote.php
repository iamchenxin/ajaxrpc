<?php
/**
 * Created by PhpStorm.
 * User: z97
 * Date: 15-6-3
 * Time: 下午5:56
 */
class remote_plugin_ajaxrpc extends DokuWiki_Remote_Plugin {
    public function _getMethods() {
        return array(
            'getTime' => array(
                'args' => array(),
                'return' => 'date'
            ),
            'test' => array(
                'args' => array('string'),
                'return' => 'string'
            ),
            'getUser' => array(
                'args' => array(),
                'return' => 'string'
            ),
        );
    }

    public function getTime() {
        return $this->getApi()->toDate(time());
    }

    function test($msg){
        return "i recive your msg ($msg) .";
    }

    public function getUser(){
        global $INPUT;
        return $INPUT->server->str('REMOTE_USER') ;
    }
}