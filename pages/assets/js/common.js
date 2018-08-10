(function(){

  //参数是路径   返回一个  k:v   形式的对象
  function paramToObj(str)
  {
    if(str[0] == '?')
    {
      str = str.substr(1);
    }
    var cc = str;
    var tmp_array = cc.split('&');
    var obj = {};
    for(var i=0;i<tmp_array.length;i++)
    {
      var tmp = tmp_array[i].split('=');
      obj[tmp[0]] = decodeURIComponent(tmp[1]);
    }
    return obj;
  }
  function checkUrlSearch(search)
  {
    var obj = paramToObj(search);
    for(var k in obj)
    {
      if(obj[k] == '')
      {
        return false;
      }
    }
    return true;
  }

  //封装一波提示信息   alert-danger红色    alert-info蓝色
  function alertMsg(selector,msg){
    $(selector).fadeIn(200).find('span').text(msg);
    setTimeout(function(){
      $(selector).fadeOut(500);
    },2000);
  }

  window.I = {
    paramToObj : paramToObj,
    checkUrlSearch:checkUrlSearch,
    alertMsg:alertMsg
  }
})(window)