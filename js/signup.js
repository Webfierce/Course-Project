// Get Variales
 const realFileBtn = document.getElementById("real-file");
 const customBtn = document.getElementById("custom-button");
 const customTxt = document.getElementById("custom-text");

 // create event listener to link custom button
 // To the real input button
 customBtn.addEventListener("click", function(){
   realFileBtn.click();
 });

 // Create event listener to display the image Name
 // You want to upload
 // To change color of the custom button, when I file is uploaded or not.
 realFileBtn.addEventListener("change", function(){
   if (realFileBtn.value) {
     customTxt.innerHTML = realFileBtn.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];
     customBtn.style.border = '2px solid green';
     customTxt.style.color = '#fff';
   } else {
     customTxt.innerHTML = "No avatar chosen, yet.";
     customTxt.style.color = 'red';
   }
 });
