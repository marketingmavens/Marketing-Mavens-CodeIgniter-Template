function get_url()
{
  var domain = document.domain;
  if(domain == 'sites.dev'){
    return '/';
  }else if(domain == 'mavenswebsites.com') {
    return '/clients/';
  }else {
    return '/';
  }

}

