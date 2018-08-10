define(['jquery','template'],function($,temp){
  $.get('api/getnav-menus.php',function(res){
    res = JSON.parse(res);
    if(res.success)
    {
      var data = JSON.parse(res.result[0]['value']);
      $('#list tbody').html(temp('tpl',{list:data}));
    }
  })
})