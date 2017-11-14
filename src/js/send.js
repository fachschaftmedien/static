/**
 * created by NasskalteJuni
 */
const urlParameters = data => Object.keys(data).map((i) => encodeURIComponent(i)+'='+encodeURIComponent(data[i])).join('&');

export default function(data){
  const headers = new Headers();
  headers.append('Authorization', 'Basic ' + btoa("studident:kukident"));
  headers.append('Content-Type','application/x-www-form-urlencoded');
  const body = urlParameters(data);
  console.log(body);
  return fetch('/manage.php', {
    method: 'POST',
    headers: headers,
    body: body
  });
}
