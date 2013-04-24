function get_url()
{
  var domain = document.domain;
  if(domain == 'body.dev'){
    return '/';
  }else if(domain == 'mavenswebsites.com') {
    return '/clients/getyourbodyback/';
  }else {
    return '/registration/';
  }

}

