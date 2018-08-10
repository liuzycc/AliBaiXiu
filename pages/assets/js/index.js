//主页加载数据
define(['jquery', 'template'], function ($, template) {
  // 定义过滤器
  template.defaults.imports.itfilter = function (content) {
    // 约定文章的长度不过 20 个字符
    return content.length > 20 ? (content.slice(0, 20) + '...') : content;
  };

  // 发起请求, 渲染页面
  $.get('/admin/api/getindexdata.php', function (json) {
    if (json.success) {
      $('#list').html(template('tpl', {
        list: json.result
      }));
    }
  });
})