let url_path = document.querySelectorAll("a");

const aTags = document.querySelectorAll('a') 
aTags.forEach(aTag => {
//   aTag.href = "NewHrefAttribute"
  console.log("url list",aTag.href);
 let url_list = document.getElementById('list');
 let pattern = '/\n/'

 url_list.innerHTML+= aTag.href+'\r';

});
