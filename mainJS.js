document.getElementById('filterBtn').addEventListener('click', function () {
    document.getElementById('filter-box').style.display = 'block';
});

function applyFilter() {
    // Get values from filter inputs
    const minPrice = document.getElementById('minPrice').value;
    const maxPrice = document.getElementById('maxPrice').value;
    const category = document.getElementById('category').value;

    // Implement your filtering logic here
    console.log('Min Price:', minPrice);
    console.log('Max Price:', maxPrice);
    console.log('Selected Category:', category);

    // Close the filter box
    document.getElementById('filter-box').style.display = 'none';
}

//constants
const img = document.createElement('img');
const dropdown = document.getElementsByClassName('dropdown');

setInterval(function(){
    img.setAttribute('src',src[Math.floor(Math.random()*src.length)])
    document.querySelector('.categoryresults').appendChild(img);
},5000)

function dropDown(){
    document.getElementById('myDropDown').classList.toggle("show");
}

window.addEventListener('click',(e)=>{
    e.preventDefault();
    if(!e.target.matches('.dropbtn')){
        var dropdowns = document.getElementsByClassName('dropdown-content');
        var i;
        for(i=0;i<dropdowns.length;i++){
            var openDropDown = dropdowns[i];
            if(openDropDown.classList.contains('show')){
                openDropDown.classList.remove('show')
            }
        }
    }
})


function helpDropDown(){
    document.getElementById('helpdropdown').classList.toggle("showmore")
}


 window.addEventListener('click',(e)=>{
    e.preventDefault();
    if(!e.target.matches('.droplink')){
        var dropdown2 =document.getElementsByClassName('dropdown');
        var i;
        for(i=0;i<dropdown2.length;i++){
            var openlink = dropdown2[i];
            if(openlink.classList.contains('showmore')){
                openlink.classList.remove('showmore')
            }
        }
    } 
 })

 //search bar
