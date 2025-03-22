// alert('1');
function onrangeupdate(val) {
    document.getElementById('rangespan').textContent = val;
}

function oncolorupdate(val) {
    document.getElementById('colorspan').textContent = val;
}
document.addEventListener("DOMContentLoaded", function() {
    const backToTopButton2 = document.getElementById("scrollToTop");
    window.addEventListener("scroll", function () {
        if (window.scrollY > 300) {
            backToTopButton2.style.display = "flex"; 
            backToTopButton2.style.opacity = "1";
        } else {
            backToTopButton2.style.opacity = "0";
            backToTopButton2.style.display = "none";
        }
    });

    backToTopButton2.addEventListener("click", function () {
        window.scrollTo({ top: 0, behavior: "smooth" });
    });
});


function changeImage(event, src) {
    document.getElementById('mainImage').src = src;
    document.querySelectorAll('.thumbnail').forEach(thumb => thumb.classList.remove('active'));
    event.target.classList.add('active');
}