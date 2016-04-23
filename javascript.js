// Example 26-14: javascript.js

canvas               = O('logo')
context              = canvas.getContext('2d')
context.font         = 'bold italic 97px Georgia'
context.textBaseline = 'top'
image                = new Image()
image.src            = 'none.jpg'
image.onload = function()
{
  gradient = context.createLinearGradient(0, 0, 0, 89)
  gradient.addColorStop(0.00, '#66FF66')
  gradient.addColorStop(0.66, '#00FF00')
  context.fillStyle = gradient
  context.fillText(  "PH v.2", 0, 0)
  context.strokeText("PH v.2", 0, 0)
  context.drawImage(image, 64, 32)
}
var $secret = $('#secret');
var $toggle = 0;
function O(i) { return typeof i == 'object' ? i : document.getElementById(i) }
function S(i) { return O(i).style                                            }
function C(i) { return document.getElementsByClassName(i)                    }


function imgError(image) {
    image.onerror = "";
    image.src = "noimage.jpg";
    return true;
}



function hidey(){
    
    if($toggle == 0)
    {
        
        document.getElementById("secret").style.display = "";
        $toggle = 1;
    }
    else 
    {
        document.getElementById("secret").style.display = "none";
        $toggle = 0;
    }
}
