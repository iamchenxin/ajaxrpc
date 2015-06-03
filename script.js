/**
 * Created by z97 on 15-5-29.
 */

function xxajax_process(data){
    var description = "";

    for(var x in data){
        var property=data[x];

        description+=x+" = "+property+"\n";
    }
    if(data['error']){
        for(var x in data['error']){
            var property=data['error'][x];
            description+=x+" = "+property+"\n";
        }
    }
    console.log(description);

}

function ajax_xcall(method,params,callback,id,type){
    if(id!=true){
        id=0;
    }
    if(type!=true){
        type="POST";
    }
    var url = DOKU_BASE + 'lib/exe/ajax.php';
    var request = {jsonrpc:"2.0",method:method,params:params,id: id};
    var mdata = {
        call:"jsonrpc",
        request:JSON.stringify(request) //must JSON.stringify here ! because the rpcserver receive a string request , and the ajax is a text type ! not json!itself
    };
    jQuery.ajax({type:type,url:url,data:mdata,success:callback,dataType:"json"});
}


function test1(){
    var url = DOKU_BASE + 'lib/exe/ajax.php';

    var mdata=new Object();
    mdata['call']="jsonrpc";
//    mdata['request']='{"jsonrpc":"1.0","method":"dokuwiki.appendPage","params":["贷款","\\\\\\\\\n来自ajaxrpc",{"sum":"from ajax"}],"id": 3}';
//    mdata['request'] = {jsonrpc:"2.0",method:"plugin.ajaxrpc.test",params:["hello,i am newnewnewnew"],id: 6};
    mdata['request']='{"jsonrpc":"2.0","method":"dokuwiki.getVersion","params":[],"id": 3}';
//    mdata['request']='test';
//    jQuery.ajax({url:url,data:mdata,success:xxajax_process,dataType:"jsonp",crossDomain:true});
    jQuery.ajax({type:'POST',url:url,data:JSON.stringify(mdata),success:xxajax_process,dataType:"json",crossDomain:true});

}

function test2(){
//    ajax_xcall("dokuwiki.getVersion",[],xxajax_process);
    ajax_xcall("dokuwiki.appendPage",["贷款","来huoho星的贷款\\\\\n",{sum:"from ajax_xcall"}],xxajax_process);

//    ajax_xcall("plugin.ajaxrpc.getUser",[],xxajax_process);
}

function xxinit_ff(){

    test2();
}

jQuery(xxinit_ff);