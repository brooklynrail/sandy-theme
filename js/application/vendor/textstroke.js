/*!
{
  "name": "CSS text-stroke",
  "property": "text-stroke",
  "caniuse": "css-text-stroke",
  "tags": ["css"],
  "knownBugs": ["None"]
}
!*/
 
Modernizr.addTest('textstroke', function() {
  var h1 = document.createElement('h1');
  return !(!('webkitTextStroke' in h1.style) && !('textStroke' in h1.style));
});