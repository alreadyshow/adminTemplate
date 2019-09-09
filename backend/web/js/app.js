$.loadingBig = '<i style="font-size: 32px;" class="layui-icon layui-icon-loading-1 layui-anim layui-anim-rotate layui-anim-loop"></i>';
$.loadingMini = '<i class="layui-icon layui-icon-loading-1 layui-anim layui-anim-rotate layui-anim-loop"></i>';
//JavaScript代码区域

layui.use('laydate', function(){
    var laydate = layui.laydate;

    //执行一个laydate实例
    laydate.render({
        elem: '.date-input' //指定元素
    });

    //执行一个laydate实例
    laydate.render({
        elem: '.date-range-input',
        range: true
    });
});


