/**
  项目JS主入口
  以依赖Layui的layer和form模块为例
**/
layui.define(['layer', 'laytpl', 'jquery'], function(exports) {
    var layer = layui.layer,
        laytpl = layui.laytpl,
        $ = layui.jquery;

    layer.msg('hello');

    exports('index', {}); //注意，这里是模块输出的核心，模块名必须和use时的模块名一致
});
