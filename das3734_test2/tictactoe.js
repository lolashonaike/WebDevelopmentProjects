
  function fillBlank(event)
  {
    theElement= event.currentTarget;
    var elt = document.getElementById("tic1");
    var b1 = elt.name;
    var b2 =document.getElementById("tic2").name;
    var b3 = document.getElementById("tic3").name;
    var b4 =document.getElementById("tic4").name;
    var b5 = document.getElementById("tic5").name;
    var b6 = document.getElementById("tic6").name;
    var b7 = document.getElementById("tic7").name;
    var b8 = document.getElementById("tic8").name;
   var b9 = document.getElementById("tic9").name;
   
    var elt = document.getElementById("tic1");
    var b1v = elt.value;
    var b2v =document.getElementById("tic2").value;
    var b3v = document.getElementById("tic3").value;
    var b4v =document.getElementById("tic4").value;
    var b5v = document.getElementById("tic5").value;
    var b6v = document.getElementById("tic6").value;
    var b7v = document.getElementById("tic7").value;
    var b8v = document.getElementById("tic8").value;
   var b9v = document.getElementById("tic9").value;
   var fillval = Math.max(b1,b2,b3,b4,b5,b6,b7,b8,b9) + 1;
  
   if ( fillval > 1 && ((b1v == "X" && b2v == "X" && b3v === "X")||(b4v == "X" && b5v == "X" && b6v === "X")||(b7v == "X" && b8v == "X" && b9v === "X")||
        (b1v == "X" && b4v == "X" && b7v === "X")||(b2v == "X" && b5v == "X" && b8v === "X")||(b3v == "X" && b6v == "X" && b9v === "X")||
         (b1v == "X" && b5v == "X" && b9v === "X")||(b3v == "X" && b5v == "X" && b7v === "X")  )){
     alert("Player X wins");

}
else if ( fillval > 1 && ((b1v == "O" && b2v == "O" && b3v === "O")||(b4v == "O" && b5v == "O" && b6v === "O")||(b7v == "O" && b8v == "O" && b9v === "O")||
        (b1v == "O" && b4v == "O" && b7v === "O")||(b2v == "O" && b5v == "O" && b8v === "O")||(b3v == "O" && b6v == "O" && b9v === "O")||
         (b1v == "O" && b5v == "O" && b9v === "O")||(b3v == "O" && b5v == "O" && b7v === "O")  )){
     alert("Player O wins");

}
 else{
if(theElement.value ==""){
   if (fillval % 2 == 0){
       theElement.value = "O";
       theElement.name = fillval;
   }
   else{
      theElement.value="X"
      theElement.name= fillval;
   }
}
}
  
  }