var upload = document.getElementById('upload');
var image = document.getElementById('image');

function initialize()
{
    // Global variables for current values associated with each slider
    var currentBrightness = 1;
    var currentContrast = 100;
    // alert("Begin!"); // debug message
};

function uploadImage(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            image.setAttribute('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
};

$("#upload").change(function(){
    uploadImage(this);
});

function setContrast(value)
{
    currentContrast = value;
    var filter = 'contrast(' + currentContrast + '%) ' + 'brightness(' + currentBrightness + ')';
    image.style.filter = filter;
    image.style.webkitFilter = filter;
};

function setBrightness(value)
{
    currentBrightness = value;
    var filter = 'contrast(' + currentContrast + '%) ' + 'brightness(' + currentBrightness + ')';
    image.style.filter = filter;
    image.style.webkitFilter = filter;
};

function applyMyNostalgiaFilter() 
{   
    var filter = 'saturate(40%) grayscale(100%) contrast(45%) sepia(100%)';
    image.style.filter = filter;
    image.style.webkitFilter = filter;
};

function applyGrayscaleFilter() 
{   
    var filter = 'grayscale(100%)';
    image.style.filter = filter;
    image.style.webkitFilter = filter;
};

function applySepiaFilter() 
{   
    var filter = 'sepia(100%)';
    image.style.filter = filter;
    image.style.webkitFilter = filter;
};

function applyHueFilter() 
{   
    var filter = 'hue-rotate(180deg)';
    image.style.filter = filter;
    image.style.webkitFilter = filter;
};

function applyInvertFilter() 
{   
    var filter = 'invert(1)';
    image.style.filter = filter;
    image.style.webkitFilter = filter;
};

function applyBlurFilter() 
{   
    var filter = 'blur(2.5px)';
    image.style.filter = filter;
    image.style.webkitFilter = filter;
};


function revertToOriginal() 
{   
    var filter = '';
    image.style.filter = filter;
    image.style.webkitFilter = filter;
};


function submit()
{
     // Read values from form
    var title = document.getElementById("title").value;
    //document.getElementById("debug").innerHTML = title;
    
    var text = document.getElementById("text").value;
    //document.getElementById("debug").innerHTML = text;
    
    // Save filtered image in a variable
    var filteredImage = image;
    // document.getElementById("debug").appendChild(filteredImage); 

    // Manipulate DOM:
    // 1. Clean up (remove) old stuff
    var parent = form.parentElement;
    while (form.firstChild) {
        form.removeChild(form.firstChild);
    }
        
    // 2. Make room for new stuff: formatted title & text + filtered image
    parent.innerHTML = '<h2>' + title + '</h2><p>' + text + '</p>';
    parent.appendChild(filteredImage);   
}

