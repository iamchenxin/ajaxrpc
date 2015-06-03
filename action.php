<?php
/**
 * User: z9764
 * Date: 2015/5/29
 * Time: 2:29
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN', DOKU_INC . 'lib/plugins/');
require_once (DOKU_PLUGIN . 'action.php');
require_once (DOKU_INC . 'inc/jsonrpc_core.php');

class  action_plugin_ajaxrpc extends DokuWiki_Action_Plugin
{
    /*
        var $helper;

        function action_plugin_ajaxpeon(){
            $this->helper = $this->loadHelper('ajaxpeon', false);
        }
    */
    function register(&$controller)
    {
        $controller->register_hook('AJAX_CALL_UNKNOWN', 'BEFORE', $this, '_ajax_call');
//        $controller->register_hook('XMLRPC_CALLBACK_REGISTER', 'BEFORE',  $this, 'registerCallback');
    }

    /**
     * handle ajax requests
     */
    function _ajax_call(&$event, $param)
    {
        if ($event->data !== 'jsonrpc') {
            return;
        }
        //no other ajax call handlers needed
        $event->stopPropagation();
        $event->preventDefault();
        $rpc_server=new jsonrpc_server();

        //e.g. access additional request variables
        global $INPUT; //available since release 2012-10-13 "Adora Belle"

        $rpc_request=$INPUT->str('request');
        $rt='';
        if($rpc_request){
            $rt=$rpc_server->rpc($rpc_request);
        }

        //json library of DokuWiki
        require_once DOKU_INC . 'inc/JSON.php';
        $json = new JSON();
        //set content type
        header('Content-Type: application/json');
        if($INPUT->str("callback")){
            echo $INPUT->str("callback")."(".$rt.")";
        }else {
            echo $rt;
        }
    }
/*
    function registerCallback(&$event) {
        $event->data->addCallback(
            'plugin.ajaxrpc.test',
            'plugin:ajaxrpc:test',
            array('msg'),
            'blah.',
            true
        );
    }

    function test($msg){
        return "i recive your msg ($msg) .";
    }
*/
}