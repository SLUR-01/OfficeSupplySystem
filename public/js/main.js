// TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .fa-solid.fa-bars');
const sidebar = document.getElementById('sidebar');
const sidebarLabels = document.querySelectorAll('#nav-text, #header-text');

const nav = document.querySelectorAll('#nav-container')



menuBar.addEventListener('click', function (){
    sidebar.classList.toggle('hide');

    const displayStyle = sidebar.classList.contains('hide') ? 'none' : 'block';

    sidebarLabels.forEach(label => {
        label.style.display = displayStyle;
    });
    
   

    
})




// Drop down profile and logout function 
document.addEventListener("DOMContentLoaded", function () {
    const dropdownToggle = document.getElementById("dropdownToggle");
    const dropdownMenu = document.getElementById("dropdownMenu");
    const dropdownArrow = document.getElementById("dropdownArrow");

    dropdownToggle.addEventListener("click", function (event) {
        event.stopPropagation(); // Prevent event from propagating to document
        dropdownMenu.classList.toggle("hidden");
        dropdownArrow.classList.toggle("rotate-180");
    });

    document.addEventListener("click", function (event) {
        if (!dropdownToggle.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.add("hidden");
            dropdownArrow.classList.remove("rotate-180");
        }
    });
});
